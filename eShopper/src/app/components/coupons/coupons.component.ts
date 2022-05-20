import { Component, OnInit } from '@angular/core';
import { NavigationEnd, Router } from '@angular/router';
import { CouponService } from 'src/app/services/coupon.service';
import { CurrencyService } from 'src/app/services/currency.service';

@Component({
  selector: 'app-coupons',
  templateUrl: './coupons.component.html',
  styleUrls: ['./coupons.component.css']
})
export class CouponsComponent implements OnInit {


  availableCoupons = null;
  expiredCoupons = null;
  currency = 'inr';

  constructor(
    private currService:CurrencyService,
    private couponService:CouponService,
    private router:Router
  ) {

    router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.currency = currService.getCurrency();
      }
    });

    currService.currSubject.subscribe((curr) => {
      this.currency = curr;
    });

  }

  ngOnInit(): void {
    this.getAvailableCoupon();
    this.getExpiredCoupon();
  }

  getAvailableCoupon(){
    this.couponService.getAllCouponBy(1).subscribe({
      next: (res)=>{
        const result = res.result;
        if(result.length > 0){
          this.availableCoupons = result;
        }
        console.log(123, this.availableCoupons); 
      },
      error: (err)=>{
        console.log(err.error);
      }
    });
  }
  getExpiredCoupon(){
    this.couponService.getAllCouponBy(0).subscribe({
      next: (res)=>{
        const result = res.result;
        if(result.length > 0){
          this.expiredCoupons = result;
        }
        console.log(123, this.expiredCoupons); 
      },
      error: (err)=>{
        console.log(err.error);
      }
    });
  }

}
