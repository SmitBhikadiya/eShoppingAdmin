import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { OwlOptions, SlidesOutputData } from 'ngx-owl-carousel-o';
import { Toast } from 'ngx-toastr';
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
  reviewByUser:any = null;
  cartForm!: FormGroup;
  reviewForm!:FormGroup;
  isReviewToggle = false;
  avgRating = 0;

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
    private toaster: NotificationService,
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
      this.isLoggin = res;
      this.setAndgetDefault();
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
  }

  ngOnInit(): void {
    this.setAndgetDefault();
  }

  setAndgetDefault(){
    this.setAddToCartForm("ADD TO CART",0,0,1);
    this.setReviewForm(0, '');

    let token = this.userAuth.getToken();
    if(token!=null){
      token = JSON.parse(token);
      this.isLoggin = true;
      this.userId = token.user.id;
    }

    this.route.params.subscribe((param) => {
      this.prdid = param["id"];
    });

    this.getProductById();
    this.getAllReviewBy(this.prdid);
  }

  setReviewForm(rating:number, review:string){
    this.reviewForm = this.formBuilder.group({
      stars: [`${rating}`, Validators.required],
      review: [`${review}`, [Validators.required, Validators.maxLength(255)]],
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
      if (this.wishListId != null) {
        this.toaster.showWarning("Product is already added in wishlist");
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
            this.toaster.showSuccess("Product is added to your wishlist!!");
          }else{
            this.toaster.showError(res.error);
          }
        },
        error: (err)=>{
          this.toaster.showError(err.error.message,"ServerError");
        }
      });
    }else{
      this.toaster.showWarning("Product Id or User Id can't be null");
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
        this.addReview(this.reviewForm.value);
        this.getAllReviewBy(this.prdid);
        this.reviewForm.reset();
    }
  }

  addReview(formValue:any){
    if(this.isLoggin && this.userId != null){
      this.productService.insertReview(this.prdid, this.userId, formValue.stars, formValue.review).subscribe({
        next: (res) => {
          if(res.error==''){
            this.reviewByUser = res.result;
            this.isReviewToggle = false;
            this.getAllReviewBy(this.prdid);
            this.toaster.showSuccess("Review Added Successfully!!");
          }else{
            this.toaster.showError(res.error, 'ServerError');
          }
        },
        error: (err) => {
          this.toaster.showError(err.error.message,"ServerError");
        },
      });
    }else{
      this.toaster.showError('Login is must required!!!');
    }
  }

  getCartItems() {
    
    if(this.isLoggin && this.userId!=null){
    this.cartService.getCartItems(this.userId).subscribe((res) => {
      this.cartItems = res["result"];
      this.subTotal = this.cartService.getSubTotal();
      if (this.cartItems == '') {
        this.cartItems = null;
        this.subTotal = 0;
      }
      this.subTotal = this.currPipe.transform(this.subTotal, this.currency);
      if(this.cartItems!=null && (this.prdid!=null || this.prdid!=undefined)){
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
      this.toaster.showError(err.error.message,"ServerError");
    });
    }
  }

  updateCartItem(colorId: number, sizeId: number, qty: number, subtotal: number) {
    if(this.isLoggin){
      this.cartService.updateCartItem(this.cartId, this.userId, colorId, sizeId, qty, subtotal).subscribe({
        next: (res) => {
          if (res.error == '') {
            this.getCartItems();
            this.toaster.showSuccess("Item Updated Successfully!!!");
          } else {
            this.toaster.showError(res.error);
          }
        }, error: (err) => {
          this.toaster.showError(err.error.message,"ServerError");
        }
      });
    }else{
      this.toaster.showError('Login is must required!!!');
    }
  }

  addItemToCart(colorId: number, sizeId: number, qty: number, subtotal: number) {
    if(this.isLoggin){
      this.cartService.addItemToCart(this.product, this.userId, colorId, sizeId, qty, subtotal).subscribe({
        next: (res) => {
          if (res.error == '') {
            this.getCartItems();
            this.toaster.showSuccess("Item Added Successfully!!!");
          } else {
            this.toaster.showError(res.error);
          }
        }, error: (err) => {
          this.toaster.showError(err.error.message,"ServerError");
        }
      });
    }else{
      this.toaster.showError('Login is must required!!!');
    }
  }

  getAllReviewByUser(userId:number, productId:number, data:any){
    if(this.isLoggin){
      this.productService.getAllReviewByIds(productId, userId).subscribe({
        next: (res)=>{
          const result = res.result;
          if(result.length > 0){
            this.reviewByUser = result;
            let totalRating = 0;
            this.productReviews = data.map((review:any)=>{
              totalRating += Number(review['productRate']);
              review['isMyReview'] = (this.isIdExitsInReviewByUser(review['id']) > 0);
              return review;
            });  
            this.avgRating = Math.floor((totalRating)/this.productReviews.length);      
          }else{
            this.reviewByUser = null;
          }
        },
        error: (err) => {
          this.toaster.showError(err.error.message,"ServerError");
        },
      });
    }else{
      this.reviewByUser = null;
    }
  }

  getAllReviewBy(prdId:number){
    this.productService.getReviewByProductId(prdId).subscribe({
      next: (res)=>{
        const result = res.result;
        if(result.length > 0){
          this.getAllReviewByUser(this.userId, this.prdid, result);
        }else{
          this.productReviews = null;
          this.avgRating = 0;
        }
      },
      error: (err) => {
        this.toaster.showError(err.error.message,"ServerError");
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
      this.toaster.showError(err.error.message,"ServerError");
    });
  }

  getSizeByIds(ids: string) {
    this.productService.getSizeByIds(ids).subscribe((res) => {
      this.sizes = res["result"];
      this.getColorByIds(this.product["productColorIds"]);
    }, (err) => {
      this.toaster.showError(err.error.message,"ServerError");
    });
  }

  getColorByIds(ids: string) {
    this.productService.getColorByIds(ids).subscribe((res) => {
      this.colors = res["result"];
      this.getCartItems();
    }, (err) => {
      this.toaster.showError(err.error.message,"ServerError");
    });
  }

  isIdExitsInReviewByUser(reviewId:number){
    const reviews = this.reviewByUser?.filter((review:any)=>review.id==reviewId);
    return reviews.length;
  }

  deleteReview(reviewId:number){
    if(this.reviewByUser!=null && this.isIdExitsInReviewByUser(reviewId) > 0){
      this.productService.deleteReview(reviewId).subscribe({
        next: (res)=>{
          if(res.error==''){
            this.getAllReviewBy(this.prdid);
            this.reviewForm.reset();
            this.toaster.showSuccess("Your Review Deleted Successfully!!");
          }else{
            this.toaster.showError(res.error);
          }
        },
        error: (err)=>{
          this.toaster.showError(err.error.message,"ServerError");
        }
      });
    }else{
      this.toaster.showError("Invalid Request");
    }
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
