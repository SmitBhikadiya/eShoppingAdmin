import { HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { Injectable, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { BehaviorSubject, catchError, filter, Observable, switchMap, take, throwError } from 'rxjs';
import { HeaderComponent } from '../components/header/header.component';
import { UserAuthService } from './user-auth.service';

@Injectable({
  providedIn: 'root'
})
export class AuthInterceptorService implements HttpInterceptor {
  private isRefreshing = false;
  private refreshTokenSubject: BehaviorSubject<any> = new BehaviorSubject<any>(null);
  constructor(private userAuth:UserAuthService, private router:Router) { }

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    
    const access_token = this.userAuth.getAccessToken();
    let newReq = req;
    if(access_token!=null){
      newReq = this.addToken(req, access_token);
    }
    

    //console.log('processing request',req);
    return next.handle(newReq).pipe(catchError(error => {
      if (error instanceof HttpErrorResponse){ 
        if(error.status === 401) {
          return this.handle401Error(newReq, next);
        }else if(error.status === 403){
          return this.handle403Error(newReq, next);
        }
      }
      return throwError(error);
    }));
  }

  private handle401Error(req:HttpRequest<any>, next:HttpHandler){
    console.log("401 Unauthorized!!!");
    if(!this.isRefreshing){
      this.isRefreshing = true;
      this.refreshTokenSubject.next(null);
      const refresh = this.userAuth.getRefreshToken();
      //console.log("refresh "+refresh);
      if(refresh!=null){
        return this.userAuth.refreshToken().pipe(switchMap((jwtToken:any)=>{
          console.log("Token Refreshing...");
          this.isRefreshing = false;
          this.refreshTokenSubject.next(jwtToken);
          return next.handle(this.addToken(req, jwtToken));
        }),
        catchError((err)=>{
          if(err instanceof HttpErrorResponse && err.status===403){
            return this.handle403Error(req, next);
          }
          return throwError(err);
        }));
      }
    }
    return this.refreshTokenSubject.pipe(
      filter(token => token !==null),
      take(1),
      switchMap((jwtToken:any)=>next.handle(this.addToken(req, jwtToken)))
    );
  }

  private handle403Error(req:HttpRequest<any>, next:HttpHandler){
    this.isRefreshing = false;
    this.userAuth.logout();
    window.location.reload();
    return next.handle(req.clone({headers: req.headers.delete('access_token')}));
  }

  private addToken(req:HttpRequest<any>, token:string){
    return req.clone({
      setHeaders: {
        access_token : token
      }
    });
  }
}
