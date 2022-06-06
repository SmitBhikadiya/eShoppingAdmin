import { CurrencyPipe } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, map, Subject } from 'rxjs';
import { environment } from 'src/environments/environment';
import { IProduct } from '../interfaces/product';

@Injectable({
  providedIn: 'root'
})
export class CartService {

  api_url = environment.API_SERVER_URL;
  subtotal = 0;
  header_ = {'Content-Type': 'application/json'};
  cartItemSubject = new Subject<any>();
  removeCartSubject = new Subject<any>();

  constructor(private http:HttpClient, private currPipe:CurrencyPipe) { }

  getCartItems(userId:number) : Observable<any>{
    const data = {userId};
    return this.http.post<any>(`${this.api_url}/cart.php`, data, {headers:this.header_}).pipe(map((res: any) => {
      if(res!=undefined && res.result!=''){
        this.calculateSubTotal(res.result);
        this.cartItemSubject.next({cartItems:res.result, subTotal: this.subtotal});
      }
      return res;
    }));
  }

  getCartItemsByPrdId(prdId:number, userId_:number){
    const data = {prdId, userId_};
    return this.http.post<any>(`${this.api_url}/cart.php`, data, {headers:this.header_});
  }

  addItemToCart(product:IProduct, userId:number, color:number, size:number, qty:number, subtotal:number) : Observable<any>{
    const data = {product, userId, color, size, qty, subtotal};
    return this.http.post<any>(`${this.api_url}/cart.php`, data, {headers:this.header_});
  }

  increaseItemQty(incId:number){
    const data = {incId};
    return this.http.post<any>(`${this.api_url}/cart.php`, data, {headers:this.header_});
  }

  updateCartItem(cartId:number, userId:number, color:number, size:number, qty:number, subtotal:number){
    const data = {cartId, userId, color, size, qty, subtotal};
    return this.http.post<any>(`${this.api_url}/cart.php`, data, {headers:this.header_});
  }

  removeAllItemFromCart(removeCart:any){
    return this.http.post<any>(`${this.api_url}/cart.php`, {removeCart}, {headers:this.header_});
  }

  removeItemFromCart(removeId:number){
    return this.http.post<any>(`${this.api_url}/cart.php`, {removeId}, {headers:this.header_}).pipe(map((res)=>{
      this.removeCartSubject.next(true);
      return res;
    }));
  }

  calculateSubTotal(cartItems:any){
    let subtotal_ = 0;
    cartItems.forEach((item:any)=>{
      let unitprice = item.unitPrize;
      let qty = item.quantity;
      subtotal_ += unitprice*qty;
    });
    this.subtotal = subtotal_;
  }

  getSubTotal(){
    return this.subtotal;
  }
}
