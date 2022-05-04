import { Component, Input, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { IProduct } from 'src/app/interfaces/product';
import { CartService } from 'src/app/services/cart.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
declare let $:any;

@Component({
  selector: 'app-add-to-cart-btn',
  template: '<a title="Add to Cart" (click)="addToCart()" class="cart-button">Add to Cart</a>',
  styles: ['a{cursor:pointer;}']
})
export class AddToCartBtnComponent implements OnInit {

  @Input() prd:any;
  product!:IProduct;
  error:string = '';
  constructor(private router:Router,private userAuth:UserAuthService, private cartService:CartService) { }

  ngOnInit(): void {
  }
  
  addToCart(qty:number=1, sizeid:number=0, colorid:number=0){
    if(this.userAuth.isLoggedIn()){
      const data = JSON.parse(this.userAuth.getToken());
      const user = data.user;
      let colorId = (colorid==0) ? this.prd.productColorIds.split(",")[0] : colorid;
      let sizeId = (sizeid==0) ? this.prd.productSizeIds.split(",")[0] : sizeid;
      this.cartService.addItemToCart(this.prd, user.id, colorId, sizeId, 1, this.prd.productPrice*qty).subscribe((res)=>{
        if(res!=undefined || res.error==''){
          this.router.navigate(['cart']);
        }
      },(err)=>{
        console.log(err);
        this.error = err;
      });
    }else{
      $("#Login-popup").modal("show");
    }
  }
}
