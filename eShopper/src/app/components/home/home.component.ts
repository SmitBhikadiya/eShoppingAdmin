import { Component, OnInit, ViewChild } from '@angular/core';
import { NavigationEnd, Router } from '@angular/router';
import { IProduct } from 'src/app/interfaces/product';
import { ProductService } from 'src/app/services/product.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
import { environment } from 'src/environments/environment';
import { HeaderComponent } from '../header/header.component';

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
  noImageURL = environment.IMAGES_SERVER_URL+"/noimage.jpg";

  constructor(private productService:ProductService, private userAuth:UserAuthService, private router:Router) {
    this.router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.ngOnInit();
      }
    });
  }

  ngOnInit(): void {
    this.getProducts();
  }

  getProducts(){
    this.productService.getProducts(this.defaultLoadProduct, '', 'latest', '1').subscribe((res)=>{
      this.products = res["result"];
      console.log(res);
    },(err)=>{
      this.error = err;
    });
  }

}
