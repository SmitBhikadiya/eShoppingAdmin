import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { IColor } from '../interfaces/color';
import { IProduct } from '../interfaces/prodduct';
import { ISize } from '../interfaces/size';

@Injectable({
  providedIn: 'root'
})
export class ProductService {

  constructor(private http:HttpClient) { }

  getProducts(load:number, formvalues:string) : Observable<any>{
    let query_ = new URLSearchParams(formvalues).toString();
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}&${query_}`);
  }

  getProductsById(id:number) : Observable<any>{
    return this.http.get<IProduct>(`${environment.API_SERVER_URL}/product.php?id=${id}`);
  }

  getProductsByCatId(id:number) : Observable<any>{
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?catid=${id}`);
  }

  getProductsBySubCatId(id:number) : Observable<any>{
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?subcatid=${id}`);
  }

  getProductsByCatName(load:number, cat:string, formvalues:any): Observable<any>{
    let query_ = new URLSearchParams(formvalues).toString();
    console.log(`${environment.API_SERVER_URL}/product.php?load=${load}&catname=${cat}&${query_}`);
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}&catname=${cat}&${query_}`);
  }

  getProductsBySubCatName(load:number, cat:string, subcat:string, formvalues:string): Observable<any>{
    let query_ = new URLSearchParams(formvalues).toString();
    console.log(`${environment.API_SERVER_URL}/product.php?load=${load}&catname=${cat}&subcatname=${subcat}&${query_}`);
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}&catname=${cat}&subcatname=${subcat}&${query_}`);
  }

  getColors() : Observable<any>{
    return this.http.get<IColor[]>(`${environment.API_SERVER_URL}/color.php`);
  }

  getColorByIds(ids:string) : Observable<any>{
    return this.http.get<any>(`${environment.API_SERVER_URL}/color.php?colorids=${ids}`);
  }

  getSizes() : Observable<any>{
    return this.http.get<ISize[]>(`${environment.API_SERVER_URL}/size.php`);
  }

  getSizeByIds(ids:string) : Observable<any>{
    return this.http.get<any>(`${environment.API_SERVER_URL}/size.php?sizeids=${ids}`);
  }
}
