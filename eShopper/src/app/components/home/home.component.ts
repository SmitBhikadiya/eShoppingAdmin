
import { CurrencyPipe } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { NavigationEnd, Router } from '@angular/router';
import { IProduct } from 'src/app/interfaces/product';
import { ApplicationService } from 'src/app/services/application.service';
import { CurrencyService } from 'src/app/services/currency.service';
import { NotificationService } from 'src/app/services/notification.service';
import { ProductService } from 'src/app/services/product.service';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  products!: IProduct[];
  ActProducts!: IProduct[];
  imageURL = environment.IMAGES_SERVER_URL;
  defaultLoadProduct = 8;
  noImageURL = environment.IMAGES_SERVER_URL + "/noimage.jpg";
  cartItems!: any;
  subTotal!: any;
  currency = 'inr';

  constructor(
    private productService: ProductService,
    private router: Router,
    private currService: CurrencyService,
    private appService:ApplicationService,
    private toaster:NotificationService,
    private currPipe: CurrencyPipe
  ) {

    this.router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.currency = currService.getCurrency();
      }
    });

    currService.currSubject.subscribe((curr) => {
      this.currency = curr;
    });

  }

  ngOnInit(): void {
    this.getProducts();
  }
  
  getProducts() {
    this.productService.getProducts(this.defaultLoadProduct, '', 'latest', '1').subscribe((res) => {
      this.products = res["result"];
    }, (err) => {
      this.toaster.showError(err.error.message,"ServerError");
    });
  }

}
