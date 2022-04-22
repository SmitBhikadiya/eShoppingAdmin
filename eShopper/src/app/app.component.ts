import { Component, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { NavigationEnd, Router } from '@angular/router';
import { HeaderComponent } from './components/header/header.component';
import { RegisterComponent } from './components/register/register.component';
import { CustomValidation } from './customValidation';
import { IProduct } from './interfaces/product';
import { UserAuthService } from './services/user-auth.service';
declare let $:any;
 
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  
  @ViewChild(HeaderComponent) headerCMP!:HeaderComponent;
  @ViewChild(RegisterComponent) registerCMP!:RegisterComponent;
  title = 'eShopping';
  products!:IProduct[];
  loginForm!:FormGroup;
  message: {msg:string, isError:boolean, color:string, image:string} = {msg:'', isError:false, color:'success', image:'success.svg'};
  validator = new CustomValidation();

  constructor(private userAuth:UserAuthService, private router:Router, private builder:FormBuilder){
    router.events.subscribe((ev)=>{
      if(ev instanceof NavigationEnd){
        // when navigation changed
      }
    })
  }
  
  ngOnInit() {
    this.loginForm = this.builder.group({
      username:['', Validators.required],
      password:['', Validators.maxLength(8)]
    });
  }

  userLogin(){
    var formData:any = new FormData();
    formData.append('username',this.loginForm.get('username')?.value);
    formData.append('password',this.loginForm.get('password')?.value);
    if(this.formValidate()){
      this.userAuth.userLogin(formData).subscribe(res=>{
        if(res.length!=0){
          document.getElementById("Login-popup")?.click();
          this.headerCMP.isLoggin = true;
          this.headerCMP.username = res[0]["username"];
          if(this.router.url.includes('/register')){
            this.router.navigate(['/']);
          }
        }else{
          this.message.msg = "Invalid username or password!!!";
          this.message.isError = true;
          this.message.color = 'danger';
          this.message.image = 'error.svg';
          setTimeout(()=>{
            this.message.msg = '';
          },5000)
        }
      });
    }
  }

  formValidate(){
    $(".spanError").remove();
    this.validator.isFieldEmpty("#loginuser");
    this.validator.isPasswordValid("#loginpass");
    if($("#loginform").find('.spanError').length==0){
      return true;
    }else{
      return false;
    }
  }

}
