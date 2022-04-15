import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { IProduct } from 'src/app/interfaces/prodduct';
import { ProductService } from 'src/app/services/product.service';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.css']
})
export class ProductsComponent implements OnInit {

  category!:any;
  subcategory!:any;
  products!:IProduct[];
  error:string = '';
  defaultLoadProduct:number = environment.DEFAULT_LOAD_PRODUCT;

  imageURL:string = environment.IMAGES_SERVER_URL;

  constructor(private productService:ProductService, private router:Router,private route:ActivatedRoute) {
    this.router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.ngOnInit();
      }
    });
  }

  ngOnInit(): void {
    this.route.paramMap.subscribe((params)=>{
      this.category = params.get("category");
      this.subcategory = params.get("subcategory");
    });
    this.getProductsBy(this.category, this.subcategory, this.defaultLoadProduct);
  }

  getProductsBy(cat:string, subcat:string, load:number) : void{
    if(cat==null){
      this.productService.getProducts(load).subscribe((res)=>{
        this.products = res["result"];
      }, (err)=>{
        this.error=err;
      });
    }else if(subcat==null){
      this.productService.getProductsByCatName(load, cat).subscribe((res)=>{
        this.products = res["result"];
      }, (err)=>{
        this.error=err;
      });
    }else{
      this.productService.getProductsBySubCatName(load, cat, subcat).subscribe((res)=>{
        this.products = res["result"];
      }, (err)=>{
        this.error=err;
      });
    }
  }

  loadMoreProduct(load:number){
    this.defaultLoadProduct = load+2;
    this.getProductsBy(this.category, this.subcategory, this.defaultLoadProduct);
  }

  trackByProduct(index:number, product:IProduct){
    return product.id;
  }
}
