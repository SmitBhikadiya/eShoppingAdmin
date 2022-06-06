import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ApplicationService {

  header = { 'content-type':'application/json' };

  constructor(
    private http:HttpClient
  ) { }

  getTestimonials(){
    return this.http.post<any>(`${environment.API_SERVER_URL}/testimonial.php`, { getTestmonials:'getTestmonials'}, {headers: this.header});
  }

  getBanners(){
    return this.http.post<any>(`${environment.API_SERVER_URL}/banner.php`, { getBanners:'getBanners'}, {headers: this.header});
  }

  getAboutUs(){
    return this.http.post<any>(`${environment.API_SERVER_URL}/aboutus.php`, { aboutus:'aboutus'}, {headers: this.header});
  }

  contactUs(name:string, subject:string, email:string, message:string){
    return this.http.post<any>(`${environment.API_SERVER_URL}/contactus.php`, { contactus:'contactus', name, email, subject, message}, {headers: this.header});
  }
}
