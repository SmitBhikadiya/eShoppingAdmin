import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { CustomValidation } from 'src/app/customValidation';
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

  constructor(
    private userAuth: UserAuthService, 
    private router: Router,
    private builder: FormBuilder) {
  }

  ngOnInit() {
    this.loginForm = this.builder.group({
      username: ['', Validators.required],
      password: ['', Validators.maxLength(8)]
    });    
  }

  userLogin() {
    var formData: any = new FormData();
    formData.append('username', this.loginForm.get('username')?.value);
    formData.append('password', this.loginForm.get('password')?.value);
    if (this.formValidate()) {
      this.userAuth.userLogin(formData).subscribe(res => {
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
      });
    }
  }

  formValidate() {
    $(".spanError").remove();
    this.validator.isFieldEmpty("#loginuser");
    this.validator.isPasswordValid("#loginpass");
    if ($("#loginform").find('.spanError').length == 0) {
      return true;
    } else {
      return false;
    }
  }
}
