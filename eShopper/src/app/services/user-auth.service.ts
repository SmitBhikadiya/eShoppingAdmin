import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { map } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserAuthService {
  constructor(private http: HttpClient) { }

  userLogin(loginCred: any) {
    return this.http.post<any>(`${environment.API_SERVER_URL}/login.php`, loginCred)
      .pipe(map(Users => {
        if(Users.length > 0){
          this.setToken(Users[0].username);
        }
        return Users;
      }));
  }

  userRegister(registerCred: any) {
    return this.http.post<any>(`${environment.API_SERVER_URL}/register.php`, registerCred)
      .pipe(map(Users => {
        return Users;
      }));
  }

  isUsernameExits(username:any){
    return this.http.get<any>(`${environment.API_SERVER_URL}/register.php?username=${username}`);
  }

  isEmailExits(email:any){
    return this.http.get<any>(`${environment.API_SERVER_URL}/register.php?email=${email}`);
  }

  setToken(token: string) {
    localStorage.setItem('token', token);
  }
  getToken() {
    return localStorage.getItem('token');
  }
  deleteToken() {
    localStorage.removeItem('token');
  }
  isLoggedIn() {
    if (this.getToken() == null) {
      return false;
    } else {
      return true;
    }
  }
}
