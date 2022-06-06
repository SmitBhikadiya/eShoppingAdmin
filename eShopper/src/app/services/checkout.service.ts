import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class CheckoutService {

  header_ = {'Content-Type': 'application/json'};

  constructor(
    private http:HttpClient
  ) { }

  getCheckOutSession(cartData:any, couponData:any, taxData:any, userId:any, currency:string){
    let cartDetailes = {cartData, couponData, taxData, userId, currency};
    return this.http.post<any>(`${environment.API_STRIPE_PAYMENT_URL}/checkout_session.php`, {cartDetailes}, {headers:this.header_});
  }
}
