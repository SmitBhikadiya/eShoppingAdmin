import { Component, OnInit } from '@angular/core';
import { CartService } from 'src/app/services/cart.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
import { environment } from 'src/environments/environment';
import { AddressService } from 'src/app/services/address.service';
import { ServicetaxService } from 'src/app/services/servicetax.service';
import { ProductService } from 'src/app/services/product.service';
import { NotificationService } from 'src/app/services/notification.service';
import { CurrencyService } from 'src/app/services/currency.service';
import { SetCurrPipe } from 'src/app/pipes/set-curr.pipe';
import { NavigationEnd, Router } from '@angular/router';
import { CouponService } from 'src/app/services/coupon.service';
import { CheckoutService } from 'src/app/services/checkout.service';
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
  userId!: any;
  coupon!:any;
  countries = [];
  states = [];
  colors = [];
  sizes = [];
  taxPercentage = 0;
  tax = 0;
  taxData!:any;
  discount = 0;
  currency = 'INR';
  flag: boolean = true;
  alertMsg: { error: boolean, message: string } = { error: false, message: '' };
  updateItem_: { isEditable: boolean, itemId: any } = { isEditable: false, itemId: 0 }
  constructor(
    private cartService: CartService,
    private addressService: AddressService,
    private userAuth: UserAuthService,
    private productService: ProductService,
    private cuurencyPipe: SetCurrPipe,
    private taxservice: ServicetaxService,
    private toast: NotificationService,
    private currService: CurrencyService,
    private couponService: CouponService,
    private stripeService: CheckoutService,
    private router: Router
  ) {

    const data = JSON.parse(this.userAuth.getToken());
    this.userId = data.user.id;

    router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.currency = currService.getCurrency();
      }
    });

    currService.currSubject.subscribe((curr) => {
      this.currency = curr;
      this.calculateSubTotal();
    });
    
  }

  ngOnInit(): void {
    this.getCartItems();
    this.getCountries();
  }

  checkout(){
    this.stripeService.getCheckOutSession(this.cartItems, this.coupon, this.taxData, this.userId).subscribe({
      next: (res)=>{
        console.log(123,res);
      },
      error: (err)=>{
        console.log(456, err);
      }
    });
  }

  couponApply(event:any){
    $("#couponInput").parent().find(".spanError").remove();
    let coupon  = (event.target.value).toUpperCase();
    if(coupon!='' && coupon.length >= 5){
        this.couponService.getCouponByCode(coupon).subscribe({
          next:(res)=>{
            this.coupon = res.result;
            this.checkCouponAvailablityAndSet(this.coupon)
          },
          error: (err)=>{
            this.toast.showError("Error: "+err);
          }
        });
    }
  }

  checkCouponAvailablityAndSet(coupon:any){
    $("#couponInput").parent().find(".spanError").remove();
    if(coupon.length==undefined){
      if(this.isCouponExpired(coupon.couponExpiry)){
        this.toast.showError("Coupon has been expired!!");
        this.unsetCoupon();
      }else{
        if(!(coupon.maximumTotalUsage >= 1)){
          this.toast.showError("No More referrals available!!");
          this.unsetCoupon();
        }else{
          if(this.subTotal >= coupon.requireAmountForApplicable){
            this.discount = coupon.discountAmount;
            this.calculateSubTotal();
            this.toast.showSuccess("Coupon applied successfully!!");
          }else{
            this.toast.showError(`Cart SubTotal must be greater than ${this.cuurencyPipe.transform(this.coupon.requireAmountForApplicable, this.currency)}!!`);
            this.unsetCoupon(true);
          }
        }
      }
    }else{
      $("#couponInput").after("<span class='spanError'>Invalid Coupon</span>");
      this.unsetCoupon();
    }
  }

  isCouponExpired(couponExpiry:any){
    let currDateTime = new Date();
    let expiryTime = new Date(couponExpiry);
    if( currDateTime.getTime() > expiryTime.getTime()){
      return true;
    }else{
      return false;
    }
  }

  toggleItemUpdate(itemId: number, sizeIds: string, colorIds: string) {
    $(".colorName").removeClass("hide");
    $(".sizeName").removeClass("hide");
    $(".colorList").removeClass("show");
    $(".sizeList").removeClass("show");
    $(".colorLi1_" + itemId).toggleClass("hide");
    $(".colorLi2_" + itemId).toggleClass("show");
    $(".sizeLi1_" + itemId).toggleClass("hide");
    $(".sizeLi2_" + itemId).toggleClass("show");
    if (this.updateItem_.isEditable == false) {
      this.getColorByIds(colorIds);
      this.getSizeByIds(sizeIds);
    }
  }

  getCountries() {
    this.addressService.getCountry().subscribe((res) => {
      this.countries = res["result"];
    });
  }

  getSizeByIds(ids: string) {
    console.log(ids);
    this.productService.getSizeByIds(ids).subscribe((res) => {
      this.sizes = res["result"];
    }, (err) => {
      console.log(err);
    });
  }

  getColorByIds(ids: string) {
    console.log(ids);
    this.productService.getColorByIds(ids).subscribe((res) => {
      this.colors = res["result"];
    }, (err) => {
      console.log(err);
    });
  }

  getStatesByCountryId(id: any) {
    this.addressService.getStatesByCountryId(id).subscribe((res) => {
      this.states = res["result"];
      this.unsetTax();
    });
  }

  getTaxByState(countryId: any, stateId: any) {
    this.taxservice.getTaxByState(countryId, stateId).subscribe((res) => {
      let result = res["result"];
      if(result.length==undefined){
        this.taxData = result;      
        this.taxPercentage = this.taxData.tax;
        this.calculateSubTotal();
      }else{
        this.unsetTax();
      }
    }, (err) => {
      this.unsetTax();
    });
  }

  unsetTax(){
    this.taxPercentage = 0;
    this.tax = 0;
    this.taxData = undefined;
    this.calculateSubTotal();
  }

  getCartItems() {
    this.cartService.getCartItems(this.userId).subscribe((res) => {
      this.cartItems = res["result"];
      if (this.cartItems == '') {
        this.cartItems = null;
      } else {
        setTimeout(() => {
          this.calculateSubTotal();
        }, 1000);
      }
    }, (err) => {
      console.log(err);
    });
  }

  removeItemFromCart(cartId: any) {
    this.cartService.removeItemFromCart(cartId).subscribe((res) => {
      if (res.error == '') {
        this.getCartItems();
        this.toast.showSuccess("Item removed Successfully!!");
      }
    }, (err) => {
      this.toast.showError(`Error : ${err}`);
    });
  }

  clearCart() {
    this.cartService.removeAllItemFromCart(this.userId).subscribe((res) => {
      if (res.error == '') {
        this.cartItems = null;
        this.toast.showSuccess("Cart cleared succesfully!!");
      }
    }, (err) => {
      this.toast.showError(`Error : ${err}`);
    });
  }

  updateItem(item: any) {
    let colorId = $(`.colorFor_${item.id}`).val();
    let sizeId = $(`.sizeFor_${item.id}`).val();
    let qty = Number($(`.qty_${item.id}`).val());
    colorId = (colorId == null) ? item.productColorId : colorId;
    sizeId = (sizeId == null) ? item.productSizeId : sizeId;
    if (qty >= 1 && qty <= Number(item.totalQuantity)) {
      this.subTotal = qty * item.productPrice;
      this.cartService.updateCartItem(item.id, this.userId, colorId, sizeId, qty, this.subTotal).subscribe({
        next: (res) => {
          if (res.error == '') {
            this.toast.showSuccess(`${item.productName} is updated successfully!!`);
            this.getCartItems();
            this.flag = true;
          } else {
            this.toast.showError(`Error : ${res.error}`);
            this.flag = false;
          }
        }, error: (err) => {
          this.toast.showError(`Error : ${err}`);
          this.flag = false;
        }
      });
    } else {
      this.toast.showError("Item Out Of Stock!!!");
      this.flag = false;
    }
    this.flag = false;
  }

  countItemSubTotal(event: any, unit: any, target1: any, item: any) {
    let qty = event.target.value;
    if (qty > 0) {
      let unitp = unit.value;
      let itemsubtotal = qty * unitp;
      this.updateItem(item)
      if (this.flag) {
        target1.innerText = this.cuurencyPipe.transform(itemsubtotal.toString(), this.currency);
        this.calculateSubTotal();
      }
    } else {
      this.toast.showError("Invalid Quantity!!!");
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
    this.subTotal = subTotal;
    $(".summary-table tbody .subtotal").html(this.cuurencyPipe.transform(subTotal.toString(), this.currency));
    if(this.coupon!=undefined && (this.subTotal < this.coupon.requireAmountForApplicable)){
      this.removedCoupon();
    }
    this.tax = (subTotal - Number(this.discount)) * (Number(this.taxPercentage)/100);
    $(".summary-table tbody .summary-price strong").html(this.cuurencyPipe.transform((subTotal + Number(this.tax) - Number(this.discount)).toString(), this.currency));
  }

  removedCoupon(){
    this.toast.showWarning(`Coupon Removed: Sub Total must be greater or equal then ${this.cuurencyPipe.transform(this.coupon.requireAmountForApplicable, this.currency)}`);
    this.unsetCoupon(true);
  }

  unsetCoupon(isValueRemoved:boolean = false){
    this.discount = 0;
    this.coupon = undefined;
    if(isValueRemoved){
      (<HTMLInputElement>document.getElementById("couponInput")).value = '';
    }
    this.tax = (this.subTotal - Number(this.discount)) * (Number(this.taxPercentage)/100);
    $(".summary-table tbody .summary-price strong").html(this.cuurencyPipe.transform((this.subTotal + Number(this.tax) - Number(this.discount)).toString(), this.currency));
  }

}
