import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class NewsletterService {

  constructor(
    private http: HttpClient
  ) { }

  subscribeNewsletter(email:string){
    return this.http.post<any>(`${environment.API_SERVER_URL}/newsletter.php`, {email} , {headers: {'content-type':'application/json'}});
  }
}
