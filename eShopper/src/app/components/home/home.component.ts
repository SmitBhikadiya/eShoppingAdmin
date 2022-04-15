import { Component, OnInit } from '@angular/core';
import { IProduct } from 'src/app/interfaces/prodduct';
import { ProductService } from 'src/app/services/product.service';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  products!:IProduct[];
  error:string = '';
  imageURL = environment.IMAGES_SERVER_URL;
  defaultLoadProduct = environment.DEFAULT_LOAD_PRODUCT;

  constructor(private productService:ProductService) { }

  ngOnInit(): void {
    this.getProducts();
  }

  getProducts(){
    this.productService.getProducts(this.defaultLoadProduct).subscribe((res)=>{
      this.products = res["result"];
    },(err)=>{
      this.error = err;
    });
  }

}
