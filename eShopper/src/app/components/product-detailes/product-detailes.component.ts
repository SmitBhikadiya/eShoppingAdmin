import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { OwlOptions, SlidesOutputData } from 'ngx-owl-carousel-o';
import { IColor } from 'src/app/interfaces/color';
import { IProduct } from 'src/app/interfaces/product';
import { ISize } from 'src/app/interfaces/size';
import { ProductService } from 'src/app/services/product.service';
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

  constructor(private productService:ProductService, private router:Router, private route:ActivatedRoute) { 
    router.events.subscribe((ev)=>{
      if(ev instanceof NavigationEnd){
        //this.ngOnInit();
      }
    });
  }

  getData(data: SlidesOutputData, synk:any){
    synk.to((data.startPosition)?.toString());
  }

  ngOnInit(): void {
    this.route.params.subscribe((param)=>{
      this.prdid = param["id"];
    });
    this.getProductById();
  }

  toggleReview(){
    this.show = !this.show;
  }

  getProductById(){
    this.productService.getProductsById(this.prdid).subscribe((res)=>{
      this.product = res["result"];
      this.productImages = this.product["productImages"].split(",").map((n) => `${this.imgURL}/product/${n}`);
      if(this.product["productImages"]==''){
        this.productImages = [this.noImageURL];
        $(".wrapper2").hide();
      }
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

}
