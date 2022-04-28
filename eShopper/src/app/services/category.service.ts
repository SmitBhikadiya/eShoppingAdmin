import { HttpClient } from '@angular/common/http';
import { Injectable, SkipSelf } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { ICategory } from '../interfaces/category';
import { ISubCategory } from '../interfaces/subcategory';

@Injectable({
  providedIn: 'root'
})
export class CategoryService {

  constructor(private http:HttpClient) { }

  getCategory() : Observable<any>{
    return this.http.get<ICategory[]>(`${environment.API_SERVER_URL}/category.php`);
  }

  getSubCategory() : Observable<any>{
    return this.http.get<ISubCategory[]>(`${environment.API_SERVER_URL}/subcategory.php`);
  }

  getSubCategoryByCatId(id:number) : Observable<any>{
    return this.http.get<ISubCategory[]>(`${environment.API_SERVER_URL}/subcategory.php?catid=${id}`);
  }

  getSubCategoryByCatName(catname:string) : Observable<any>{
    return this.http.get<ISubCategory[]>(`${environment.API_SERVER_URL}/subcategory.php?catname=${catname}`);
  }
}
