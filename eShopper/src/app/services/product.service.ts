import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { IColor } from '../interfaces/color';
import { IProduct } from '../interfaces/product';
import { ISize } from '../interfaces/size';

@Injectable({
  providedIn: 'root'
})
export class ProductService {

  constructor(private http:HttpClient) { }

  getProducts(load:number, formvalues:string, sortby:string, trending='0,1') : Observable<any>{
    let query_ = (formvalues==='') ? '' : new URLSearchParams(formvalues).toString();
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}&${query_}&sortby=${sortby}&trending=${trending}`);
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

  getProductsByCatName(load:number, cat:string, formvalues:any, sortby:string): Observable<any>{
    let query_ = new URLSearchParams(formvalues).toString();
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}&catname=${cat}&${query_}&sortby=${sortby}`);
  }

  getProductsBySubCatName(load:number, cat:string, subcat:string, formvalues:string, sortby:string): Observable<any>{
    let query_ = new URLSearchParams(formvalues).toString();
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}&catname=${cat}&subcatname=${subcat}&${query_}&sortby=${sortby}`);
  }

  getColors() : Observable<any>{
    return this.http.get<IColor[]>(`${environment.API_SERVER_URL}/color.php`);
  }

  getColorByIds(ids:string) : Observable<any>{
    return this.http.get<any>(`${environment.API_SERVER_URL}/color.php?colorids=${ids}`);
  }

  getColorsBy(cat:string, subcat:string) : Observable<any>{
    return this.http.get<any>(`${environment.API_SERVER_URL}/color.php?cat=${cat}&subcat=${subcat}`);
  }

  getSizes() : Observable<any>{
    return this.http.get<ISize[]>(`${environment.API_SERVER_URL}/size.php`);
  }

  getSizeByIds(ids:string) : Observable<any>{
    return this.http.get<any>(`${environment.API_SERVER_URL}/size.php?sizeids=${ids}`);
  }

  getSizesBy(cat:string, subcat:string) : Observable<any>{
    return this.http.get<any>(`${environment.API_SERVER_URL}/size.php?cat=${cat}&subcat=${subcat}`);
  }
}
