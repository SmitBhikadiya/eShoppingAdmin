import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { IProduct } from 'src/app/interfaces/product';
import { CartService } from 'src/app/services/cart.service';
import { CurrencyService } from 'src/app/services/currency.service';
import { NotificationService } from 'src/app/services/notification.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
import { WishlistService } from 'src/app/services/wishlist.service';
import { environment } from 'src/environments/environment';
declare let $: any;

@Component({
  selector: 'app-wishlist',
  templateUrl: './wishlist.component.html',
  styleUrls: ['./wishlist.component.css']
})

export class WishlistComponent implements OnInit {

  currency = 'inr';
  userId: any = null;
  wishlistData: any = null;
  productBaseURL = environment.IMAGES_SERVER_URL;

  constructor(
    private userAuth: UserAuthService,
    private currService: CurrencyService,
    private wishService: WishlistService,
    private toaster: NotificationService,
    private cartService: CartService,
    private router: Router
  ) {

    currService.currSubject.subscribe((res) => {
      this.currency = res;
    });

    userAuth.isUserLoggedIn.subscribe((res) => {
      if (!res) {
        router.navigate(['/']);
      } else {
        this.loadUser();
      }
    });
  }

  ngOnInit(): void {
    this.loadUser();
    this.getWishList();
  }

  loadUser() {
    const token = JSON.parse(this.userAuth.getToken());
    this.userId = token.user.id;
  }

  addToCart(prd: IProduct) {
    if (this.userAuth.isLoggedIn()) {
      this.cartService.getCartItemsByPrdId(prd.id, this.userId).subscribe({
        next: (res) => {
          const data = res.result;
          if (data.id != undefined) {
            this.increaseItemQty(data.id);
          } else {
            this.addNewItemToCart(this.userId, prd);
          }
        },
        error: (err) => {
          this.toaster.showError(err.error.message,"ServerError");
        }
      });
    } else {
      $("#Login-popup").modal("show");
    }
  }

  addNewItemToCart(userId: number, prd: any, qty: number = 1, sizeid: number = 0, colorid: number = 0) {
    let colorId = (colorid == 0) ? prd.productColorIds.split(",")[0] : colorid;
    let sizeId = (sizeid == 0) ? prd.productSizeIds.split(",")[0] : sizeid;
    this.cartService.addItemToCart(prd, userId, colorId, sizeId, 1, prd.productPrice * qty).subscribe((res) => {
      if (res.error == '') {
        this.getCartItems();
        this.toaster.showSuccess("New Item Added Successfully!!!");
      } else {
        this.toaster.showError(res.error);
      }
    }, (err) => {
      this.toaster.showError(err.error.message,"ServerError");
    });
  }

  increaseItemQty(cartId: number) {
    if (this.userAuth.isLoggedIn()) {
      this.cartService.increaseItemQty(cartId).subscribe((res) => {
        if (res.error == '') {
          this.getCartItems();
          this.toaster.showSuccess("Added More Item Successfully!!!");
        } else {
          this.toaster.showError(res.error);
        }
      }, (err) => {
        this.toaster.showError(err.error.message,"ServerError");
      });
    } else {
      $("#Login-popup").modal("show");
    }
  }


  getCartItems() {
    this.cartService.getCartItems(this.userId).subscribe();
  }

  removeWish(id: number) {
    this.wishService.deleteWish(id).subscribe({
      next: (res) => {
        if(res.error!=''){
          this.toaster.showError(res.error);
        }
        this.getWishList();
      },
      error: (err) => {
        this.toaster.showError(err.error.message,"ServerError");
      }
    });
  }

  getWishList() {
    this.wishService.getWishBy(this.userId).subscribe({
      next: (res) => {
        const result = res.result;
        if (result.length > 0) {
          this.wishlistData = result;
        }else{
          this.wishlistData = null;
        }
      },
      error: (err) => {
        this.toaster.showError(err.error.message,"ServerError");
      }
    });
  }

}
