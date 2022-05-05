import { CurrencyPipe } from '@angular/common';
import { Component, Input, OnInit } from '@angular/core';
import { IProduct } from 'src/app/interfaces/product';
import { CartService } from 'src/app/services/cart.service';
import { NotificationService } from 'src/app/services/notification.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
declare let $:any;

@Component({
  selector: 'app-add-to-cart-btn',
  template: '<a title="Add to Cart" (click)="addToCart()" class="cart-button">Add to Cart</a>',
  styles: ['a{cursor:pointer;}']
})
export class AddToCartBtnComponent implements OnInit {

  @Input() prd:any;
  cartItems!:any;
  subTotal!:any;
  product!:IProduct;

  constructor(
    private userAuth:UserAuthService, 
    private cartService:CartService,
    private toast:NotificationService,
    private currPipe:CurrencyPipe) { }

  ngOnInit(): void {
  }

  addToCart(){
    if(this.userAuth.isLoggedIn()){
      const data = JSON.parse(this.userAuth.getToken());
      const user = data.user;
      this.cartService.getCartItemsByPrdId(this.prd.id, user.id).subscribe({
        next: (res)=>{
          const data = res.result; 
          if(data.id!=undefined){
            console.log("Increment Qty");
            this.increaseItemQty(data.id);
          }else{
            console.log("New Add");
            this.addNewItemToCart(user.id);
          }
        },
        error: (err)=>{
          this.toast.showError("Error: "+err);
        }
      });
    }else{
      $("#Login-popup").modal("show");
    }
  }
  
  addNewItemToCart(userId:number ,qty:number=1, sizeid:number=0, colorid:number=0){
      let colorId = (colorid==0) ? this.prd.productColorIds.split(",")[0] : colorid;
      let sizeId = (sizeid==0) ? this.prd.productSizeIds.split(",")[0] : sizeid;
      this.cartService.addItemToCart(this.prd, userId, colorId, sizeId, 1, this.prd.productPrice*qty).subscribe((res)=>{
        if(res.error==''){
          this.getCartItems();
          this.toast.showSuccess("New Item Added Successfully!!!");
        }else{
          this.toast.showError(res.error);
        }
      },(err)=>{
        this.toast.showError("Error: "+err);
      });
  }

  increaseItemQty(cartId:number){
    if(this.userAuth.isLoggedIn()){
      this.cartService.increaseItemQty(cartId).subscribe((res)=>{
        if(res.error==''){
          this.getCartItems();
          this.toast.showSuccess("Added More Item Successfully!!!");
        }else{
          this.toast.showError(res.error);
        }
      },(err)=>{
        console.log(err);
        this.toast.showError("Error: "+err);
      });
    }else{
      $("#Login-popup").modal("show");
    }
  }

  getCartItems() {
    console.log("Get Item Method called");
     const data = JSON.parse(this.userAuth.getToken());
     this.cartService.getCartItems(data.user.id).subscribe((res) => {
       this.cartItems = res["result"];
       this.subTotal = this.cartService.getSubTotal();
       if (this.cartItems == '') {
         this.cartItems = null;
         this.subTotal = 0;
       }
       this.subTotal = this.currPipe.transform(this.subTotal, 'USD');
     }, (err) => {
       console.log(err);
     });
   }
}
