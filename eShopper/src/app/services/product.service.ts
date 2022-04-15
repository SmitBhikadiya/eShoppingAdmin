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

  getProducts(load:number) : Observable<any>{
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}`);
  }

  getProductsByCatId(id:number) : Observable<any>{
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?catid=${id}`);
  }

  getProductsBySubCatId(id:number) : Observable<any>{
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?subcatid=${id}`);
  }

  getProductsByCatName(load:number, cat:string): Observable<any>{
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}&catname=${cat}`);
  }

  getProductsBySubCatName(load:number, cat:string, subcat:string): Observable<any>{
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}&catname=${cat}&subcatname=${subcat}`);
  }

  getColors() : Observable<IColor[]>{
    return this.http.get<IColor[]>(`${environment.API_SERVER_URL}/product.php`);
  }

  getSizes() : Observable<ISize[]>{
    return this.http.get<ISize[]>(`${environment.API_SERVER_URL}/product.php`);
  }
}
