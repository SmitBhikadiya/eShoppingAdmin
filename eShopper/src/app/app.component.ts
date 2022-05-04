import { Component, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { filter } from 'rxjs';
import { HeaderComponent } from './components/header/header.component';
import { RegisterComponent } from './components/register/register.component';
import { CustomValidation } from './customValidation';
import { IProduct } from './interfaces/product';
import { UserAuthService } from './services/user-auth.service';
declare let $: any;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {

  @ViewChild(HeaderComponent) headerCMP!: HeaderComponent;
  @ViewChild(RegisterComponent) registerCMP!: RegisterComponent;
  title = 'eShopping';
  products!: IProduct[];
  loginForm!: FormGroup;
  message: { msg: string, isError: boolean, color: string, image: string } = { msg: '', isError: false, color: 'success', image: 'success.svg' };
  validator = new CustomValidation();

  constructor(private userAuth: UserAuthService, private router: Router, private route:ActivatedRoute, private builder: FormBuilder) {
    this.router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.ngOnInit();
        if(router.url==='/cart'){
          this.headerCMP.isCartVisisble = false;
        }else{
          this.headerCMP.isCartVisisble = true;
        }
      }
    });
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
          let token = JSON.parse(this.userAuth.getToken());
          document.getElementById("Login-popup")?.click();
          this.headerCMP.isLoggin = true;
          this.headerCMP.username = token.user.username;
          if (this.router.url.includes('/register')) {
            this.router.navigate(['/']);
          } else {
           this.reloadCurrentRoute();
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

  reloadCurrentRoute() {
    const currentUrl = this.router.url;
    this.router.navigateByUrl('/', { skipLocationChange: true }).then(() => {
      this.router.navigate([currentUrl]);
    });
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
