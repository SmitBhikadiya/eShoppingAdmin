import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { map, Observable, Subject } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserAuthService {
  logincred!: any;
  isUserLoggedIn = new Subject<boolean>();
  constructor(private http: HttpClient) { }

  userLogin(loginCred: any) {
    return this.http.post<any>(`${environment.API_SERVER_URL}/login.php`, loginCred)
      .pipe(map(res => {
        console.log(123, res);
        this.setToken(JSON.stringify(res));
        this.logincred = loginCred;
        this.refreshTokenTimer();
        this.isUserLoggedIn.next(true);
        return res;
      }));
  }

  userRegister(registerCred: any) {
    return this.http.post<any>(`${environment.API_SERVER_URL}/register.php`, registerCred)
      .pipe(map(Users => {
        return Users;
      }));
  }

  refreshToken() {
    let refreshToken_ = this.getRefreshToken();
    let header_ = {'Content-Type': 'application/json'};
    //console.log("FromRefreshToken Method "+refreshToken_);
    return this.http.post<any>(`${environment.API_SERVER_URL}/refreshToken.php`, {'refreshToken': refreshToken_},{ headers : header_}).
      pipe(map((res: any) => {
        this.setAccessToken(res["result"]);
        this.setTokenExpiry(res["expiry"]);
        this.refreshTokenTimer();
        console.log("Refresh Res " + res["result"]);
        return res["result"];
      }));
  }

  verifyOTP(verifyotp:string, email:string){
    return this.http.post<any>(`${environment.API_SERVER_URL}/changepassword.php`, {verifyotp, email}, {headers: {'content-type':'application/json'}});
  }

  updatePasswordByOTP(otp:string, email:string, newpassword:string, repassword:string){
    return this.http.post<any>(`${environment.API_SERVER_URL}/changepassword.php`, {otp, email, newpassword, repassword}, {headers: {'content-type':'application/json'}});
  }

  forgotPassword(forgotPassword:string){
    return this.http.post<any>(`${environment.API_SERVER_URL}/changepassword.php`, {forgotPassword}, {headers: {'content-type':'application/json'}});
  }

  changePassword(userId:number, oldpassword:string, newpassword:string, repassword:string){
    return this.http.post<any>(`${environment.API_SERVER_URL}/changepassword.php`, {userId, oldpassword, newpassword, repassword}, {headers: {'content-type':'application/json'}});
  }

  getUserDetailesByUsername(username: string | null) {
    return this.http.get<any>(`${environment.API_SERVER_URL}/users.php?username=${username}`);
  }

  updateProfile(data: FormData): Observable<any> {
    return this.http.post<any>(`${environment.API_SERVER_URL}/users.php`, data);
  }

  isUsernameExits(username: string | null) {
    return this.http.get<any>(`${environment.API_SERVER_URL}/register.php?username=${username}`);
  }

  isEmailExits(email: any) {
    return this.http.get<any>(`${environment.API_SERVER_URL}/register.php?email=${email}`);
  }

  private setTokenExpiry(time:any){
    const data = localStorage.getItem("token");
    if (data != null) {
      const obj = JSON.parse(data);
      obj.expiry = time;
      localStorage.setItem("token", JSON.stringify(obj));
    }
  }

  getRefreshToken() {
    const data = localStorage.getItem("token");
    if (data != null) {
      return JSON.parse(data).refresh_token;
    } else {
      return null;
    }
  }

  setRefreshToken(token: any) {
    const data = localStorage.getItem("token");
    if (data != null) {
      const obj = JSON.parse(data);
      obj.refresh_token = token;
      localStorage.setItem("token", JSON.stringify(obj));
    }
  }

  getAccessToken() {
    const data = localStorage.getItem("token");
    if (data != null) {
      return JSON.parse(data).access_token;
    } else {
      return null;
    }
  }

  setAccessToken(token: any) {
    const data = localStorage.getItem("token");
    if (data != null) {
      const obj = JSON.parse(data);
      obj.access_token = token;
      localStorage.setItem("token", JSON.stringify(obj));
    }
  }

  refreshTokenTimeOut:any;

  refreshTokenTimer(){
    const token = this.getToken();
    if(token!==null){
      const data = JSON.parse(token);
      const exp_time = new Date(data.expiry).getTime();
      const curr_time = Math.ceil(Date.now()/1000)
      const timeout = exp_time - curr_time;
      console.log("timeout: "+timeout);
      this.refreshTokenTimeOut = setTimeout(()=>{
        this.refreshToken().subscribe();
        this.stopRefreshToken();
      }, (timeout+1)*1000);
    }
  }

  private stopRefreshToken(){
    clearTimeout(this.refreshTokenTimeOut);
  }

  setToken(token: string) {
    localStorage.setItem('token', token);
  }

  getToken(): any {
    return localStorage.getItem('token');
  }

  deleteToken() {
    localStorage.removeItem('token');
  }

  logout() {
    this.isUserLoggedIn.next(false);
    this.deleteToken();
    this.stopRefreshToken();
  }

  isLoggedIn() {
    let token = this.getToken();
    if (token == null || token == '' || token == undefined) {
      return false;
    } else {
      if (JSON.parse(token).error) {
        return false;
      }
      return true;
    }
  }

}
