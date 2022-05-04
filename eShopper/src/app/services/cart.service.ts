import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, map } from 'rxjs';
import { environment } from 'src/environments/environment';
import { IProduct } from '../interfaces/product';

@Injectable({
  providedIn: 'root'
})
export class CartService {

  api_url = environment.API_SERVER_URL;
  subtotal = 0;
  header_ = {'Content-Type': 'application/json'};

  constructor(private http:HttpClient) { }

  getCartItems(userId:number) : Observable<any>{
    const data = {userId};
    return this.http.post<any>(`${this.api_url}/cart.php`, data, {headers:this.header_}).pipe(map((res: any) => {
      if(res!=undefined && res.result!=''){
        this.calculateSubTotal(res.result);
      }
      return res;
    }));
  }

  getCartItemsByPrdId(prdId:number, userId_:number){
    const data = {prdId, userId_};
    //console.log(data);
    return this.http.post<any>(`${this.api_url}/cart.php`, data, {headers:this.header_});
  }

  addItemToCart(product:IProduct, userId:number, color:number, size:number, qty:number, subtotal:number) : Observable<any>{
    const data = {product, userId, color, size, qty, subtotal};
    return this.http.post<any>(`${this.api_url}/cart.php`, data, {headers:this.header_}).pipe(map((res: any) => {
      if(res!=undefined && res.error==''){
        // let prdId = product.id;
        // let cartId = res.cartId;
        //this.addItemToCartLocal({prdId, cartId, userId, color, size, qty, subtotal});
      }else{
        console.log("Add Item to Cart Error: "+res.error);
      }
      return res;
    }));
  }

  updateCartItem(cartId:number, userId:number, color:number, size:number, qty:number, subtotal:number){
    const data = {cartId, userId, color, size, qty, subtotal};
    console.log(data);
    return this.http.post<any>(`${this.api_url}/cart.php`, data, {headers:this.header_});
  }

  removeAllItemFromCart(removeCart:any){
    return this.http.post<any>(`${this.api_url}/cart.php`, {removeCart}, {headers:this.header_});
  }

  removeItemFromCart(removeId:number){
    return this.http.post<any>(`${this.api_url}/cart.php`, {removeId}, {headers:this.header_});
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

  // addItemToCartLocal(item:any){
  //   let cart = this.getCartFromLocal();
  //   if(cart==null || cart==undefined || cart==''){
  //     this.setCartToLocal([item]);
  //   }else{
  //     const data = JSON.parse(cart) as Array<any>;
  //     data.push(item);
  //     this.setCartToLocal(data);
  //   }
  // }

  // removeItemFromCartLocal(cartId:number){
  //   const cart = this.getCartFromLocal();
  //   if(cart!=null){
  //     let data = JSON.parse(cart) as Array<any>;
  //     data = data.filter(item => item.cartId !== cartId);
  //     console.log(data);
  //     this.setCartToLocal(data);
  //   }
  // }

  // getCartFromLocal(){
  //   return localStorage.getItem("cart");
  // }

  // setCartToLocal(cart:any){
  //   localStorage.setItem("cart",JSON.stringify(cart));
  // }
}
