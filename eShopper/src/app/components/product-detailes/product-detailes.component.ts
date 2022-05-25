import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { OwlOptions, SlidesOutputData } from 'ngx-owl-carousel-o';
import { CustomValidation } from 'src/app/customValidation';
import { IColor } from 'src/app/interfaces/color';
import { IProduct } from 'src/app/interfaces/product';
import { ISize } from 'src/app/interfaces/size';
import { SetCurrPipe } from 'src/app/pipes/set-curr.pipe';
import { CartService } from 'src/app/services/cart.service';
import { CurrencyService } from 'src/app/services/currency.service';
import { NotificationService } from 'src/app/services/notification.service';
import { ProductService } from 'src/app/services/product.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
import { WishlistService } from 'src/app/services/wishlist.service';
import { environment } from 'src/environments/environment';
declare let $: any;

@Component({
  selector: 'app-product-detailes',
  templateUrl: './product-detailes.component.html',
  styleUrls: ['./product-detailes.component.css']
})
export class ProductDetailesComponent implements OnInit {

  prdid!: number;
  error: string = '';
  product!: IProduct;
  sizes!: ISize[];
  colors!: IColor[];
  imgURL = environment.IMAGES_SERVER_URL;
  show: boolean = false;
  productImages!: string[];
  noImageURL = environment.IMAGES_SERVER_URL + "/noimage.jpg";
  cartId:any = null;
  wishListId:any = null;
  userId:any = null;
  productReviews:any = null;
  btn = "ADD TO CART";
  cartItems!: any;
  subTotal!: any;
  reviewByUser = null;
  cartForm!: FormGroup;
  reviewForm!:FormGroup;

  limit: number = 10; // <==== Edit this number to limit API results

  customOptions1: OwlOptions = {
    loop: true,
    center: true,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: true,
    navSpeed: 700,
    dots: false,
    dotsData: false,
    navText: ['', ''],
    nav: false,
    responsive: {
      0: {
        items: 1
      },
      400: {
        items: 1
      },
      740: {
        items: 1
      },
      940: {
        items: 1
      }
    }
  }
  customOptions2: OwlOptions = {
    loop: true,
    center: true,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: true,
    autoWidth: true,
    navSpeed: 700,
    dots: false,
    dotsData: false,
    nav: true,
    navText: ['<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>'],
    responsive: {
      0: {
        items: 4
      },
      400: {
        items: 4
      },
      740: {
        items: 4
      },
      940: {
        items: 4
      }
    },
  }

  currency = '';
  isLoggin = false;

  constructor(
    private productService: ProductService,
    private router: Router,
    private formBuilder: FormBuilder,
    private userAuth: UserAuthService,
    private cartService: CartService,
    private route: ActivatedRoute,
    private toast: NotificationService,
    private wishService:WishlistService,
    private currPipe: SetCurrPipe,
    private currService:CurrencyService
  ) {

    router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.currency = currService.getCurrency();
        this.ngOnInit();
      }
    });

    currService.currSubject.subscribe((curr)=>{
      this.currency = curr;
    });

    userAuth.isUserLoggedIn.subscribe((res)=>{
      if(res){
        this.isLoggin = true;
      }else{
        this.isLoggin = false;
      }
      this.setAddToCartForm("ADD TO CART",0,0,1);
      this.setReviewForm("Submit", 0, '');
      this.productReviews = null;
      this.cartId = null;
    });

    cartService.cartItemSubject.subscribe(data => {
      this.cartItems = data.cartItems;
      this.subTotal = data.subTotal;
    });

    cartService.removeCartSubject.subscribe(data =>{
      if(data==true){
        this.setAddToCartForm("ADD TO CART",0,0,1);
      }
    });

    this.setAddToCartForm("ADD TO CART",0,0,1);
    this.setReviewForm("Submit", 0, '');
  }

  ngOnInit(): void {

    const token = JSON.parse(this.userAuth.getToken());
    
    if(token!=null){
      this.isLoggin = true;
      this.userId = token.user.id;
    }

    this.route.params.subscribe((param) => {
      this.prdid = param["id"];
    });

    this.getProductById();

  }

  setReviewForm(btn:string, rating:number, review:string){
    this.reviewForm = this.formBuilder.group({
      stars: [`${rating}`, Validators.required],
      review: [`${review}`, [Validators.required, Validators.maxLength(255)]],
      button: [`${btn}`]
    })
  }

  setAddToCartForm(btn:string, pcolor:number, psize:number, pqty:number){
    this.cartId = null;
    this.btn = btn;
    this.cartForm = this.formBuilder.group(
      {
        pcolor: [`${pcolor}`, Validators.required],
        psize: [`${psize}`, Validators.required],
        pqty: [pqty, Validators.min(1)]
      }
    );
  }

  addProductToWishList(){
    if (this.userAuth.isLoggedIn()) {
      this.userId = JSON.parse(this.userAuth.getToken()).user.id;
      let colorId = this.cartForm.controls["pcolor"].value;
      let sizeId = this.cartForm.controls["psize"].value;
      if (this.wishListId != null) {
        this.toast.showWarning("Product is already added in wishlist");
      } else {
        this.addToWishList(this.prdid, this.userId);
      }
    } else {
      $("#Login-popup").modal("show");
    }
  }

  addToWishList(prdId:number, userId:number){
    if(this.prdid!=null && this.userId!=null){
      this.wishService.addWish(userId, prdId).subscribe({
        next: (res)=>{
          if(res.error == ''){
            this.toast.showSuccess("Product is added to your wishlist!!");
          }else{
            this.toast.showError(res.error);
          }
        },
        error: (err)=>{
          this.toast.showError(err, "ServerError");
        }
      });
    }else{
      this.toast.showWarning("Product Id or User Id can't be null");
    }
  }

  addTocart() {
    if (this.validateAddtoCart()) {
      if (this.userAuth.isLoggedIn()) {
        this.userId = JSON.parse(this.userAuth.getToken()).user.id;
        let colorId = this.cartForm.controls["pcolor"].value;
        let sizeId = this.cartForm.controls["psize"].value;
        let qty = this.cartForm.controls["pqty"].value;
        let subTotal = Number(qty) * Number(this.product["productPrice"])
        if (this.cartId != null) {
          this.updateCartItem(colorId, sizeId, qty, subTotal);
        } else {
          this.addItemToCart(colorId, sizeId, qty, subTotal);
        }
      } else {
        $("#Login-popup").modal("show");
      }
    }
  }

  reviewSubmit(){
    if (this.validateReview()) {
      console.log(this.reviewForm.value, this.reviewByUser); 
      if(this.reviewByUser==null){
        this.addReview(this.reviewForm.value);
      }else{
        this.updateReview(this.reviewForm.value);
      }
      this.getAllReviewBy(this.prdid);
    }
  }

  addReview(formValue:any){
    if(this.isLoggin){
      this.productService.insertReview(this.prdid, this.userId, formValue.stars, formValue.review).subscribe({
        next: (res) => {
          if(res.error==''){
            this.reviewByUser = res.result[0];
            this.setReviewForm('Update', formValue.stars, formValue.review);
            this.getAllReviewBy(this.prdid);
            this.toast.showSuccess("Review Added Successfully!!");
          }else{
            this.toast.showError(res.error, 'ServerError');
          }
        },
        error: (err) => {
          this.toast.showError(err.error, 'HttpResponceError');
        },
      });
    }else{
      this.toast.showError('Login is must required!!!');
    }
  }

  updateReview(formValue:any){
    if(this.isLoggin){
      if(this.reviewByUser!=null){
        const reviewId = this.reviewByUser['id'];
        this.productService.updateReview(reviewId, formValue.stars, formValue.review).subscribe({
          next: (res) => {
            if(res.error==''){
              this.toast.showSuccess("Review Updated Successfully!!");
              this.getAllReviewBy(this.prdid);
            }else{
              this.toast.showError(res.error, 'ServerError');
            }
          },
          error: (err) => {
            this.toast.showError(err.error, 'HttpResponceError');
          },
        });
      }
    }else{
      this.toast.showError('Login is must required!!!');
    }
  }

  getCartItems() {
    console.log(this.isLoggin);
    
    if(this.isLoggin){
      const data = JSON.parse(this.userAuth.getToken());
    this.cartService.getCartItems(data.user.id).subscribe((res) => {
      this.cartItems = res["result"];
      this.subTotal = this.cartService.getSubTotal();
      if (this.cartItems == '') {
        this.cartItems = null;
        this.subTotal = 0;
      }
      this.subTotal = this.currPipe.transform(this.subTotal, this.currency);
      if(this.cartItems!=null || this.prdid!=null || this.prdid!=undefined){
        const res = this.cartItems.filter((item:any)=>{
          if(item.productId==this.prdid){
            return item;
          }
        });    
        if(res.length == 1){
          const data = res[0];
          this.cartId = data.id;
          this.btn = "UPDATE CART";
          this.setFormControls(data.productColorId, data.productSizeId, data.quantity);
        }else {
          this.btn = "ADD TO CART";
          this.cartId = null;
        }
      }
    }, (err) => {
      this.toast.showError("Error: " + err);
    });
    }
  }

  updateCartItem(colorId: number, sizeId: number, qty: number, subtotal: number) {
    console.log("Updating...");
    if(this.isLoggin){
      this.cartService.updateCartItem(this.cartId, this.userId, colorId, sizeId, qty, subtotal).subscribe({
        next: (res) => {
          if (res.error == '') {
            this.getCartItems();
            this.toast.showSuccess("Item Updated Successfully!!!");
          } else {
            this.toast.showError(res.error);
          }
        }, error: (err) => {
          this.toast.showError("Error: " + err);
        }
      });
    }else{
      this.toast.showError('Login is must required!!!');
    }
  }

  addItemToCart(colorId: number, sizeId: number, qty: number, subtotal: number) {
    console.log("Adding...");
    if(this.isLoggin){
      this.cartService.addItemToCart(this.product, this.userId, colorId, sizeId, qty, subtotal).subscribe({
        next: (res) => {
          if (res.error == '') {
            this.getCartItems();
            this.toast.showSuccess("Item Added Successfully!!!");
          } else {
            this.toast.showError(res.error);
          }
        }, error: (err) => {
          this.toast.showError("Error: " + err);
        }
      });
    }else{
      this.toast.showError('Login is must required!!!');
    }
  }

  toggleReview() {
    const reviewForm = <HTMLElement>document.getElementById('reviewForm');
    if(reviewForm?.style.getPropertyValue('display') == 'block'){
      reviewForm.style.display = 'none';
    }else{
      const getReviewDetails = () => {
        console.log("Fetching.. Reviews", new Date().getSeconds());
        this.getAllReviewBy(this.prdid);
        this.getReviewByUser(this.userId, this.prdid);
        console.log("Fetched", new Date().getSeconds());
        reviewForm.style.display = 'block';
      }
      getReviewDetails();
    }
  }

  getReviewByUser(userId:number, productId:number){
    if(this.isLoggin){
      this.productService.getReviewByIds(productId, userId).subscribe({
        next: (res)=>{
          const result = res.result;
          console.log(result);
          if(result.length == 1){
            this.reviewByUser = result[0];
            this.setReviewForm("Update", result[0].productRate, result[0].review);
          }else{
            this.reviewByUser = null;
            this.setReviewForm("Submit", 0, '');
          }
        },
        error(err) {
          console.log(err);
        },
      });
    }
  }

  getAllReviewBy(prdId:number){
    this.productService.getReviewByProductId(prdId).subscribe({
      next: (res)=>{
        const result = res.result;
        if(result.length > 0){
          this.productReviews = result;
        }
      },
      error(err) {
        console.log(err);
      },
    });
  }

  trackByReview(index:number, item:any){
    return item.id;
  }

  getData(data: SlidesOutputData, synk: any) {
    synk.to((data.startPosition)?.toString());
  }

  setFormControls(colorId: number, sizeId: number, qty: number) {
    this.cartForm.controls["pcolor"].setValue(colorId);
    this.cartForm.controls["psize"].setValue(sizeId);
    this.cartForm.controls["pqty"].setValue(qty);
  }

  getProductById() {
    this.productService.getProductsById(this.prdid).subscribe((res) => {
      this.product = res["result"];
      this.productImages = this.product["productImages"].split(",").map((n) => `${this.imgURL}/product/${n}`);
      if (this.product["productImages"] == '') {
        this.productImages = [this.noImageURL];
        $(".wrapper2").hide();
      }
      this.getSizeByIds(this.product["productSizeIds"]);
      
    }, (err) => {
      this.error = err;
    });
  }

  getSizeByIds(ids: string) {
    console.log(ids);
    this.productService.getSizeByIds(ids).subscribe((res) => {
      this.sizes = res["result"];
      this.getColorByIds(this.product["productColorIds"]);
    }, (err) => {
      this.error = err;
    });
  }

  getColorByIds(ids: string) {
    console.log(ids);
    this.productService.getColorByIds(ids).subscribe((res) => {
      this.colors = res["result"];
      this.getCartItems();
    }, (err) => {
      this.error = err;
    });
  }

  validateReview(){
    const validator = new CustomValidation();
    $("#reviewForm .spanError").remove();
    validator.isRadioSelected(".rating", "stars", 'Give atleast one star');
    validator.isFieldEmpty("#review");
    if ($("#reviewForm").find('.spanError').length == 0) {
      return true;
    } else {
      return false;
    }
  }

  validateAddtoCart() {
    const validator = new CustomValidation();
    $("#cartForm .spanError").remove();
    validator.isFieldSelected("#psize", "Product size");
    validator.isFieldSelected("#pcolor", "Product color");
    validator.isTypeNumberFieldValid("#pqty", 1, this.product["totalQuantity"], "Qty");
    if ($("#cartForm").find('.spanError').length == 0) {
      return true;
    } else {
      return false;
    }
  }

}
