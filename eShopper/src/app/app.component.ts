import { Component, OnInit } from '@angular/core';
import { IProduct } from './interfaces/prodduct';
import { ProductService } from './services/product.service';
 
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  title = 'eShopping';
  //city!:ICity[];
  products!:IProduct[];
  constructor(private service:ProductService){}
  
  ngOnInit() {
    
  }
}
