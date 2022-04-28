import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { UserAuthService } from './user-auth.service';

@Injectable({
  providedIn: 'root'
})
export class AuthInterceptorService implements HttpInterceptor {

  constructor(private userAuth:UserAuthService) { }

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    // const data = JSON.parse(this.userAuth.getToken());
    // let token = '';
    // if(data.access_token == null){
    //   token = data.access_token;
    // }
    // // add custom header
    // req = req.clone({
    //   headers: req.headers.set('app-author', 'Dzhavat')
    // });

    // console.log('processing request',req);
    
    // // pass on the modified request object
    console.log("Interceptor called!!");
    return next.handle(req);
  }
}
