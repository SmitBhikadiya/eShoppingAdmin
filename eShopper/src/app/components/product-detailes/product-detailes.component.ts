import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { OwlOptions, SlidesOutputData } from 'ngx-owl-carousel-o';
import { CustomValidation } from 'src/app/customValidation';
import { IColor } from 'src/app/interfaces/color';
import { IProduct } from 'src/app/interfaces/product';
import { ISize } from 'src/app/interfaces/size';
import { CartService } from 'src/app/services/cart.service';
import { ProductService } from 'src/app/services/product.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
import { environment } from 'src/environments/environment';
declare let $:any;

@Component({
  selector: 'app-product-detailes',
  templateUrl: './product-detailes.component.html',
  styleUrls: ['./product-detailes.component.css']
})
export class ProductDetailesComponent implements OnInit {

  prdid!:number;
  error:string = '';
  product!:IProduct;
  sizes!:ISize[];
  colors!:IColor[];
  imgURL = environment.IMAGES_SERVER_URL;
  show:boolean = false;
  productImages!:string[];
  noImageURL = environment.IMAGES_SERVER_URL+"/noimage.jpg";
  cartId:any = null;
  userId:any = null;
  cartForm!:FormGroup;
  btn = "ADD TO CART";


  limit: number = 10; // <==== Edit this number to limit API results
  
  customOptions1: OwlOptions = {
    loop: true,
    center:true,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: true,
    navSpeed: 700,
    dots: false,
    dotsData:false,
    navText: [ '', '' ],
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
    center:true,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: true,
    autoWidth:true,
    navSpeed: 700,
    dots:false,
    dotsData:false,
    nav: true,
    navText: [ '<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>' ],
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

  constructor(
    private productService:ProductService,
    private router:Router,
    private formBuilder:FormBuilder,
    private userAuth:UserAuthService, 
    private cartService:CartService, 
    private route:ActivatedRoute
    ) { 
    router.events.subscribe((ev)=>{
      if(ev instanceof NavigationEnd){
        this.ngOnInit();
      }
    });

    this.cartForm = formBuilder.group(
      {
        pcolor: ['0', Validators.required],
        psize: ['0', Validators.required],
        pqty: [1, Validators.min(1)]
      }
    );
  }

  ngOnInit(): void {
    this.route.params.subscribe((param)=>{
      this.prdid = param["id"];
    });
    this.getProductById();
  }

  addTocart(){
    console.log(this.cartForm.value);
    console.log(this.cartId);
    if(this.validateAddtoCart()){
      let colorId = this.cartForm.controls["pcolor"].value;
      let sizeId = this.cartForm.controls["psize"].value;
      let qty = this.cartForm.controls["pqty"].value;
      let subTotal = Number(qty) * Number(this.product["productPrice"])
      if(this.userId!=null){
        if(this.cartId!=null){
          this.updateCartItem(colorId , sizeId, qty, subTotal);
        }else{
          this.addItemToCart(colorId , sizeId, qty, subTotal);
        }
        this.getProductById();
      }else{
        $("#Login-popup").modal("show");
      }
    }
  }

  updateCartItem(colorId:number, sizeId:number, qty:number, subtotal:number){
    console.log("Updating...");
    this.cartService.updateCartItem(this.cartId, this.userId, colorId, sizeId, qty, subtotal).subscribe({ next:(res)=>{
      console.log(res);
      console.log("Updated Successfully");
    }, error: (err)=>{
      console.log(err);
    }});
  }

  addItemToCart(colorId:number, sizeId:number, qty:number, subtotal:number){
    console.log("Adding...");
    this.cartService.addItemToCart(this.product, this.userId, colorId, sizeId, qty, subtotal).subscribe({ next:(res)=>{
      console.log(res);
      console.log("Added Successfully");
    }, error: (err)=>{
      console.log(err);
    }})
  }

  toggleReview(){
    this.show = !this.show;
  }

  getData(data: SlidesOutputData, synk:any){
    synk.to((data.startPosition)?.toString());
  }

  getCartDetailesBy(prdId:number){
    if(this.userAuth.isLoggedIn()){
      this.userId = JSON.parse(this.userAuth.getToken()).user.id;
      this.cartService.getCartItemsByPrdId(prdId, this.userId).subscribe({ next:(res)=>{
        const data = res.result; 
        if(data.id!=undefined){
          this.cartId = data.id;
          this.btn = "UPDATE CART";
          this.setFormControls(data.productColorId, data.productSizeId, data.quantity);
        }else{
          this.btn = "ADD TO CART";
          this.cartId = null;
        }
      }, error: (err)=>{
        console.log(err);
      }});
    }
  }

  setFormControls(colorId:number, sizeId:number, qty:number){
    this.cartForm.controls["pcolor"].setValue(colorId);
    this.cartForm.controls["psize"].setValue(sizeId);
    this.cartForm.controls["pqty"].setValue(qty);
  }

  getProductById(){
    this.productService.getProductsById(this.prdid).subscribe((res)=>{
      this.product = res["result"];
      this.productImages = this.product["productImages"].split(",").map((n) => `${this.imgURL}/product/${n}`);
      if(this.product["productImages"]==''){
        this.productImages = [this.noImageURL];
        $(".wrapper2").hide();
      }
      this.getCartDetailesBy(this.product["id"]);
      this.getSizeByIds(this.product["productSizeIds"]);
      this.getColorByIds(this.product["productColorIds"]);
    },(err)=>{
      this.error = err;
    });
  }

  getSizeByIds(ids:string){
    console.log(ids);
    this.productService.getSizeByIds(ids).subscribe((res)=>{
      this.sizes =  res["result"];
    },(err)=>{
      this.error = err;
    });
  }

  getColorByIds(ids:string){
    console.log(ids);
    this.productService.getColorByIds(ids).subscribe((res)=>{
      this.colors =  res["result"];
    },(err)=>{
      this.error = err;
    });
  }

  validateAddtoCart(){
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
