import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { CustomValidation } from 'src/app/customValidation';
import { NotificationService } from 'src/app/services/notification.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
declare let $:any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  loginForm!: FormGroup;
  message: { msg: string, isError: boolean, color: string, image: string } = { msg: '', isError: false, color: 'success', image: 'success.svg' };
  validator = new CustomValidation();
  triggerError = false;

  constructor(
    private userAuth: UserAuthService, 
    private toaster:NotificationService,
    private router: Router,
    private builder: FormBuilder) {
  }

  ngOnInit() {
    this.loginForm = this.builder.group({
      username: ['', [Validators.required]],
      password: ['', [Validators.required, Validators.pattern(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/)]]
    });    
  }

  toggleEye(event:Event, loginpass:HTMLInputElement){
    const inputElem = loginpass;
    const imgElem = <HTMLElement>event.target;
    if(inputElem.getAttribute('type')=='password'){
        inputElem.setAttribute('type', 'text');
        imgElem.setAttribute('src', '../../../assets/images/eye-solid.svg');
    }else{
        inputElem.setAttribute('type', 'password');
        imgElem.setAttribute('src', '../../../assets/images/eye-slash-solid.svg');
    }
  }

  userLogin() {
    this.triggerError = true;
    if (this.formValidate()) {
      this.triggerError = false;
      var formData: any = new FormData();
      formData.append('username', this.loginForm.get('username')?.value);
      formData.append('password', this.loginForm.get('password')?.value);
      this.userAuth.userLogin(formData).subscribe({
        next: res => {
        const isLogin = this.userAuth.isLoggedIn();
        if (isLogin) {
          document.getElementById("Login-popup")?.click();
          this.userAuth.isUserLoggedIn.next(true);
          if (this.router.url.includes('/register')) {
            this.router.navigate(['/']);
          }
        } else {
          this.message.msg = "Username or password are invalid!!";
          this.message.isError = true;
          this.message.color = 'danger';
          this.message.image = 'error.svg';
          setTimeout(() => {
            this.message.msg = '';
          }, 5000)
        }
      }, error: err =>{
        this.toaster.showError(err.error.message,"ServerError");
      }
    });
    }
  }

  formValidate() {
   Object.keys(this.loginForm.controls).forEach((field)=>{
     const control = this.loginForm.get(field);
     control?.markAsTouched({onlySelf:true});
   });
   return this.loginForm.valid;
  }

  get username(){
    return this.loginForm.get('username');
  }
  get mypassword(){
    return this.loginForm.get('password');
  }
}
