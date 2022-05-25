import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class WishlistService {

  header = {'content-type': 'application/json'};
  constructor(
    private http:HttpClient
  ) { }

  getWishBy(userId:number){
    const getWish='getWish'
    return this.http.post<any>(`${environment.API_SERVER_URL}/wishlist.php`, {getWish,userId}, {headers: this.header});
  }

  addWish(userId:number, productId:number){
    const addWish='addWish';
    return this.http.post<any>(`${environment.API_SERVER_URL}/wishlist.php`, {addWish,userId,productId}, {headers: this.header});
  }

  deleteWish(wishId:number){
    const removeWish='removeWish';
    return this.http.post<any>(`${environment.API_SERVER_URL}/wishlist.php`, {removeWish, wishId}, {headers: this.header});
  }
}
