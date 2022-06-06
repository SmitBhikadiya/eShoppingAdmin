import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, debounceTime, map, Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { IColor } from '../interfaces/color';
import { IProduct } from '../interfaces/product';
import { ISize } from '../interfaces/size';

@Injectable({
  providedIn: 'root'
})
export class ProductService {

  header = {'content-type':'application/json'};

  search = new BehaviorSubject<string>('');

  constructor(private http:HttpClient) { }

  getProducts(load:number, formvalues:string, sortby:string, trending='0,1') : Observable<any>{
    let query_ = (formvalues==='') ? '' : new URLSearchParams(formvalues).toString();
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}&${query_}&sortby=${sortby}&trending=${trending}`);
  }

  getProductsBySearch(load:number, formvalues:string, sortby:string, search:string, trending='0,1') : Observable<any>{
    let query_ = (formvalues==='') ? '' : new URLSearchParams(formvalues).toString();
    return this.http.get<IProduct[]>(`${environment.API_SERVER_URL}/product.php?load=${load}&${query_}&sortby=${sortby}&searchBy=${search}&trending=${trending}`);
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

  getColorsByCat(catName:string) : Observable<any>{
    return this.http.get<any>(`${environment.API_SERVER_URL}/color.php?catName=${catName}`);
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

  getSizesByCat(catName:string) : Observable<any>{
    return this.http.get<any>(`${environment.API_SERVER_URL}/size.php?catName=${catName}`);
  }

  getColorsByProduct(prdId:number){
    return this.http.get<any>(`${environment.API_SERVER_URL}/color.php?prdId=${prdId}`).pipe(map((res)=>{
      if(res!=''){
        return res.split(",");
      }else{
        return [];
      }
    }));
  }

  getSizesByProduct(prdId:number){
    return this.http.get<any>(`${environment.API_SERVER_URL}/size.php?prdId=${prdId}`).pipe(map((res)=>{
      if(res!=''){
        return res.split(",");
      }else{
        return [];
      }
    }));
  }

  getReviewByProductId(productId:number){
    const getProReview = 'getProReview';
    return this.http.post<any>(`${environment.API_SERVER_URL}/review.php`, {getProReview, productId}, {headers: this.header});
  }

  getAllReviewByIds(productId:number, userId:number){
    const getReview = 'getReview';
    return this.http.post<any>(`${environment.API_SERVER_URL}/review.php`, {getReview, productId, userId}, {headers: this.header})
  }
  
  getReviewById(reviewId:number){
    const getReview = 'getReview';
    return this.http.post<any>(`${environment.API_SERVER_URL}/review.php`, {getReview, reviewId}, {headers: this.header})
  }

  insertReview(productId:number, userId:number, rating:number, review:string){
    const setReview = 'setReview';
    return this.http.post<any>(`${environment.API_SERVER_URL}/review.php`, {setReview, productId, userId, rating, review}, {headers: this.header})
  }

  updateReview(reviewId:number, rating:number, review:string){
    const updateReview = 'updateReview';
    return this.http.post<any>(`${environment.API_SERVER_URL}/review.php`, {updateReview, reviewId, rating, review}, {headers: this.header})
  }

  deleteReview(reviewId:number){
    const deleteReview = 'deleteReview';
    return this.http.post<any>(`${environment.API_SERVER_URL}/review.php`, {deleteReview, reviewId}, {headers: this.header})
  }
}
