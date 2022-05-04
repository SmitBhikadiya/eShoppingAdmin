import { Component, OnInit } from '@angular/core';
import { CartService } from 'src/app/services/cart.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
import { environment } from 'src/environments/environment';
import { CurrencyPipe } from '@angular/common';
import { Router } from '@angular/router';
import { AddressService } from 'src/app/services/address.service';
import { ServicetaxService } from 'src/app/services/servicetax.service';
import { ProductService } from 'src/app/services/product.service';
declare let $: any;

@Component({
  selector: 'app-cart-detailes',
  templateUrl: './cart-detailes.component.html',
  styleUrls: ['./cart-detailes.component.css']
})

export class CartDetailesComponent implements OnInit {

  cartItems = null;
  imgServerURL = environment.IMAGES_SERVER_URL;
  subTotal!: any;
  userId!:any;
  countries = [];
  states = [];
  colors = [];
  sizes = [];
  tax = 0;
  updateItem_:{ isEditable:boolean, itemId:any } = { isEditable:false, itemId:0 }
  constructor(
    private cartService: CartService,
    private addressService:AddressService,
    private userAuth: UserAuthService,
    private productService:ProductService,
    private cuurencyPipe: CurrencyPipe,
    private taxservice:ServicetaxService
    ) { 
    const data = JSON.parse(this.userAuth.getToken());
    this.userId = data.user.id;
  }

  ngOnInit(): void {
    this.getCartItems();
    this.getCountries();
  }

  toggleItemUpdate(itemId:number, sizeIds:string, colorIds:string){
    $(".colorName").removeClass("hide");
    $(".sizeName").removeClass("hide");
    $(".colorList").removeClass("show");
    $(".sizeList").removeClass("show");
    $(".colorLi1_"+itemId).toggleClass("hide");
    $(".colorLi2_"+itemId).toggleClass("show");
    $(".sizeLi1_"+itemId).toggleClass("hide");
    $(".sizeLi2_"+itemId).toggleClass("show");
    if(this.updateItem_.isEditable==false){
      this.getColorByIds(colorIds);
      this.getSizeByIds(sizeIds);
    }    
  }

  getCountries() {
    this.addressService.getCountry().subscribe((res) => {
      this.countries = res["result"];
    });
  }

  getSizeByIds(ids:string){
    console.log(ids);
    this.productService.getSizeByIds(ids).subscribe((res)=>{
      this.sizes = res["result"];
    },(err)=>{
      console.log(err);
    });
  }

  getColorByIds(ids:string){
    console.log(ids);
    this.productService.getColorByIds(ids).subscribe((res)=>{
      this.colors = res["result"];
    },(err)=>{
      console.log(err);
    });
  }

  getStatesByCountryId(id: any) {
    this.addressService.getStatesByCountryId(id).subscribe((res) => {
      this.states = res["result"];
      console.log(res["result"]);
    });
  }

  getTaxByState(countryId:any, stateId:any){
    this.taxservice.getTaxByState(countryId, stateId).subscribe((res)=>{
      this.tax = res["result"];
      console.log(res);
      this.calculateSubTotal();
    }, (err) => {
      this.tax = 0;
      console.log(err);
      this.calculateSubTotal();
    });
  }

  getCartItems() {
    this.cartService.getCartItems(this.userId).subscribe((res) => {
      this.cartItems = res["result"];
      if(this.cartItems==''){
        this.cartItems = null;
      }else{
        setTimeout(() => {
          this.calculateSubTotal();
        }, 1000);
      }
    }, (err) => {
      console.log(err);
    });
  }

  removeItemFromCart(cartId:any){
    this.cartService.removeItemFromCart(cartId).subscribe((res)=>{
      if(res.error==''){
        this.getCartItems();
      }
    }, (err) => {
      console.log(err);
    });
  }

  clearCart() {
    this.cartService.removeAllItemFromCart(this.userId).subscribe((res) => {
      if(res.error==''){
        this.cartItems = null;
      }
    }, (err) => {
      console.log(err);
    });
  }

  updateItem(item:any){
    let colorId = $(`.colorFor_${item.id}`).val();
    let sizeId = $(`.sizeFor_${item.id}`).val();
    let qty = Number($(`.qty_${item.id}`).val());
    colorId = (colorId==null) ? item.productColorId : colorId;
    sizeId = (sizeId==null) ? item.productSizeId : sizeId;
    if(qty >= 1 && qty <= Number(item.totalQuantity)){
      let subtotal = qty*item.productPrice;
      this.cartService.updateCartItem(item.id, this.userId, colorId, sizeId, qty, subtotal).subscribe({
        next: (res)=>{
          console.log(res);
          this.getCartItems();
        },error: (err)=>{
          console.log(err);
        }
      });
    }else{
      alert("Invalid Qty");
    }
  }

  updateCart() {
    // step 1: get data

    // step 2: check product quauntity

    // step 3: store data into database
  }

  countItemSubTotal(event: any, unit: any, target1: any, item:any) {
    let qty = event.target.value;
    if(qty>0){
      let unitp = unit.value;
      let itemsubtotal = qty * unitp;
      target1.innerText = this.cuurencyPipe.transform(itemsubtotal, 'USD');
      this.updateItem(item);
      this.calculateSubTotal();
    }else{
      alert("Invalid Quantity");
    }
  }

  calculateSubTotal() {
    const rows = document.querySelectorAll(".shopping-table tbody tr");
    let subTotal = 0;
    rows.forEach((row) => {
      let qty = Number((<HTMLInputElement>row.querySelector(".qty"))?.value);
      let unitprice = Number((<HTMLInputElement>row.querySelector(".unitprice"))?.value);
      subTotal += (unitprice * qty);
    });
    const temp = subTotal;
    $(".summary-table tbody .subtotal").html(this.cuurencyPipe.transform(temp, 'USD'));
    $(".summary-table tbody .summary-price strong").html(this.cuurencyPipe.transform(temp+Number(this.tax), 'USD'));
  }

}
