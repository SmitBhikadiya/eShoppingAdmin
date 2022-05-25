import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class OrdersService {

  
  header_ = {'Content-Type': 'application/json'};

  constructor(private http:HttpClient) { }

  createOrder(cartItems:any, userId:number, checkoutData:any, taxData:any, discountData:any, subTotal:number, currency:string){
    return this.http.post<any>(`${environment.API_SERVER_URL}/order.php`, {cartItems, userId, checkoutData, taxData, discountData, subTotal, currency}, {headers:this.header_});
  }

  updateOrder(orderData:any){
    return this.http.post<any>(`${environment.API_SERVER_URL}/order.php`, {orderData}, {headers:this.header_});
  }

  setPaymentDone(setPayment:number, userId:number, couponData:any){
    couponData = (couponData==undefined) ? '' : couponData;
    return this.http.post<any>(`${environment.API_SERVER_URL}/order.php`, {setPayment, userId, couponData}, {headers:this.header_});
  }

  removeOrderIfPaymentNotDone(removeOrder:number, userId:number, ifpayment:number){
    return this.http.post<any>(`${environment.API_SERVER_URL}/order.php`, {removeOrder, userId, ifpayment}, {headers:this.header_});
  }

  getOrderDetailsBy(getOrderDetails:number, userId:number){
    return this.http.post<any>(`${environment.API_SERVER_URL}/order.php`, {getOrderDetails, userId}, {headers:this.header_});
  }

  getAllOrder(getAll:number, filter:string, search:string){
    return this.http.post<any>(`${environment.API_SERVER_URL}/order.php`, {getAll, filter, search}, {headers:this.header_});
  }

  getOrderById(getBy:number, userId:number){
    return this.http.post<any>(`${environment.API_SERVER_URL}/order.php`, {getBy, userId}, {headers:this.header_});
  }

  getOrderHistory(getHistory:number){
    return this.http.post<any>(`${environment.API_SERVER_URL}/order.php`, {getHistory}, {headers:this.header_});
  }
}
