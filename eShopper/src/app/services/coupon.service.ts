import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})

export class CouponService {

  header_ = {'Content-Type': 'application/json'};

  constructor(private http:HttpClient) { }

  getCouponByCode(couponCode:string){
    return this.http.post<any>(`${environment.API_SERVER_URL}/coupon.php`, {couponCode}, {headers:this.header_});
  }

  getAllCouponBy(availiablity:number){
    return this.http.post<any>(`${environment.API_SERVER_URL}/coupon.php`, {availiablity}, {headers:this.header_});
  }
}
