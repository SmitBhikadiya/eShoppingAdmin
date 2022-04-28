import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import { UserAuthService } from '../services/user-auth.service';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {
  constructor(private userAuth:UserAuthService, private router:Router){}
  canActivate(){
    if(this.userAuth.isLoggedIn()){
      return true;
    }else{
      this.router.navigate(['/']);
      return false;
    }
  }
  
}
