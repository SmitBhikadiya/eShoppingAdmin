import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { map, Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserAuthService {
  logincred!:any;
  constructor(private http: HttpClient) { }

  userLogin(loginCred: any) {
    return this.http.post<any>(`${environment.API_SERVER_URL}/login.php`, loginCred)
      .pipe(map(res => {
        this.setToken(JSON.stringify(res));
        this.logincred = loginCred;
        //this.refreshTokenTimer();
        return res;
      }));
  }

  userRegister(registerCred: any) {
    return this.http.post<any>(`${environment.API_SERVER_URL}/register.php`, registerCred)
      .pipe(map(Users => {
        return Users;
      }));
  }

  // refreshToken(){
  //   return this.http.post(`${environment.API_SERVER_URL}/auth.php`, {'refreshToken':'refreshToken'}, {headers: new HttpHeaders({'Content-Type': 'application/json'})}).
  //   pipe(map((res)=>{
  //     this.userLogin(this.logincred).subscribe();
  //     if(res!=null){
  //       this.setRefreshToken(JSON.stringify(res));
  //     }
  //     this.refreshTokenTimer();
  //     console.log(res);
  //     return res;
  //   }));
  // }

  // setRefreshToken(token:any){
  //   localStorage.removeItem("REFRESH_TOKEN");
  //   localStorage.setItem("REFRESH_TOKEN", token);
  // }

  // private refreshTokenTimeOut:any;

  // refreshTokenTimer(){
  //   const data = JSON.parse(this.getToken());

  //   //set a timeout to refresh token
  //   const expires = new Date(data.expiry);
  //   const timeout = expires.getTime() - Math.ceil(Date.now()/1000);
  //   console.log(timeout);
  //   this.refreshTokenTimeOut = setTimeout(()=>{
  //     if(true){
  //       this.refreshToken().subscribe();
  //       console.log("called");
  //     }
  //   }, (timeout+1)*1000);
  // }

  // private stopRefreshToken(){
  //   clearTimeout(this.refreshTokenTimeOut);
  // }
  
  getUserDetailesByUsername(username:string|null){
    return this.http.get<any>(`${environment.API_SERVER_URL}/users.php?username=${username}`);
  }

  updateProfile(data:FormData) : Observable<any>{
    return this.http.post<any>(`${environment.API_SERVER_URL}/users.php`,data);
  }

  isUsernameExits(username:string|null){
    return this.http.get<any>(`${environment.API_SERVER_URL}/register.php?username=${username}`);
  }

  isEmailExits(email:any){
    return this.http.get<any>(`${environment.API_SERVER_URL}/register.php?email=${email}`);
  }

  setToken(token: string) {
    localStorage.setItem('token', token);
  }

  getToken() : any {
    return localStorage.getItem('token');
  }

  private deleteToken() {
    localStorage.removeItem('token');
  }

  logout(){
    this.deleteToken();
    //this.stopRefreshToken();
  }

  isLoggedIn() {
    let token = this.getToken();
    if(token==null || token=='' || token==undefined){
      return false;
    }else{
      if(JSON.parse(token).error){
        return false;
      }
      return true;
    }
  }

}
