import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { IColor } from 'src/app/interfaces/color';
import { IProduct } from 'src/app/interfaces/product';
import { ISize } from 'src/app/interfaces/size';
import { ProductService } from 'src/app/services/product.service';
import { environment } from 'src/environments/environment';

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

  constructor(private productService:ProductService, private router:Router, private route:ActivatedRoute) { 
    router.events.subscribe((ev)=>{
      if(ev instanceof NavigationEnd){
        this.ngOnInit();
      }
    });
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
