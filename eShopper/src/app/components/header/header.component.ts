import { CurrencyPipe } from '@angular/common';
import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { AppComponent } from 'src/app/app.component';
import { ICategory } from 'src/app/interfaces/category';
import { ISubCategory } from 'src/app/interfaces/subcategory';
import { CartService } from 'src/app/services/cart.service';
import { CategoryService } from 'src/app/services/category.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
import { environment } from 'src/environments/environment';
declare let $: any;

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  categories!: ICategory[];
  subcategories!: ISubCategory[];
  error!: string;
  username: any = '';
  isLoggin: boolean = false;
  cartItems = null;
  isCartVisisble: boolean = true;
  subTotal: any;
  imgServerURL = environment.IMAGES_SERVER_URL;
  @ViewChild(AppComponent) appComponent!: AppComponent;

  constructor(private cartService: CartService, private currPipe: CurrencyPipe, private catService: CategoryService, private router: Router, private userAuth: UserAuthService) { }

  ngOnInit(): void {
    this.getCategory();
    this.isLoggin = this.userAuth.isLoggedIn();
    if (this.isLoggin) {
      this.username = JSON.parse(this.userAuth.getToken()).user.username;
    } else {
      this.cartItems = null;
    }
  }

  userLogout() {
    this.userAuth.logout();
    this.isLoggin = false;
  }

  getCategory() {
    this.catService.getCategory().subscribe((res) => {
      this.categories = res["result"];
    },
      (err) => {
        this.error = err;
      });
  }

  getSubCategory(id: number) {
    this.catService.getSubCategoryByCatId(id).subscribe((res) => {
      this.subcategories = res["result"];
    },
      (err) => {
        this.error = err;
      });
  }

  getCartItems() {
    const data = JSON.parse(this.userAuth.getToken());
    this.cartService.getCartItems(data.user.id).subscribe((res) => {
      this.cartItems = res["result"];
      this.subTotal = this.cartService.getSubTotal();
      if (this.cartItems == '') {
        this.cartItems = null;
        this.subTotal = 0;
      }
      this.subTotal = this.currPipe.transform(this.subTotal, 'USD');
      $(".add-to-cart").toggleClass("active");
      $(".cart-wrap").slideToggle(500);
    }, (err) => {
      console.log(err);
    });
  }

  removeItemFromCart(cartId: any) {
    this.cartService.removeItemFromCart(cartId).subscribe((res) => {
      if (res.error == '') {
        this.getCartItems();
        let currentUrl = this.router.url;
        this.router.navigateByUrl('/', { skipLocationChange: true }).then(() => {
          this.router.navigate([currentUrl]);
        });
      }
    }, (err) => {
      console.log(err);
    });
  }
}
