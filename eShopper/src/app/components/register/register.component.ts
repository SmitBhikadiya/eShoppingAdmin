import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { UserAuthService } from 'src/app/services/user-auth.service';
import { CustomValidation } from 'src/app/customValidation';
import { Router } from '@angular/router';
declare let $:any;
@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

  registerForm!:FormGroup;
  isAnyError:boolean = false;
  isFormValid:boolean = false;
  isLoggedIn = false;
  message:string = '';
  validator = new CustomValidation();
  constructor(private builder:FormBuilder, private route:Router, private userauth:UserAuthService) {}

  ngOnInit(): void {
    this.registerForm = this.builder.group({
      username: ['',[Validators.required]],
      password: ['', [Validators.required, Validators.pattern('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,}$/')]],
      email: ['', [Validators.required, Validators.email]],
      firstname: ['', [Validators.required]],
      lastname: ['', [Validators.required]],
      mobile: ['', [Validators.required, Validators.pattern('/^[0-9]{12}$/')]],
      gender: ['', [Validators.required]],
      phone: ['', [Validators.required, Validators.pattern('/^[0-9]{6}$/')]]
    });
  }

  registerUser(){
    if(this.formValidate()){
      let userdata = new FormData(); 
        userdata.append('username', this.registerForm.get('username')?.value);
        userdata.append('firstname', this.registerForm.get('firstname')?.value);
        userdata.append('lastname', this.registerForm.get('lastname')?.value);
        userdata.append('email', this.registerForm.get('email')?.value);
        userdata.append('password', this.registerForm.get('password')?.value);
        userdata.append('gender', this.registerForm.get('gender')?.value);
        userdata.append('mobile', this.registerForm.get('mobile')?.value);
        userdata.append('phone', this.registerForm.get('phone')?.value);
        this.userauth.userRegister(userdata).subscribe((res)=>{
          if(res.error == ''){
            this.isAnyError = true;
            this.message = `${res.username} is registered successfully!!`;
            setTimeout(()=>{
              this.isAnyError = false;
              this.message = '';
            }, 5000);
          }
          this.registerForm.reset();
        });
    }
  }

  isUserNameExits(username:string){
    $(".spanError").remove();
    $(".userError").remove();
    this.userauth.isUsernameExits(username).subscribe((res)=>{
      if(res["result"].length == 0){
        $(".userError").remove();
      }else{
        $("#username").after("<span class='userError' style='color: red; margin-top: 4px;'> username is already exits!!</span>");
      }
    });
  }

  isEmailExits(email:string){
    $(".spanError").remove();
    $(".emailError").remove();
    this.userauth.isEmailExits(email).subscribe((res)=>{
      if(res["result"].length == 0){
        $(".emailError").remove();
      }else{
        $("#email").after("<span class='emailError' style='color: red; margin-top: 4px;'> email is already exits!!</span>");
      }
    });
  }

  formValidate(){
    $(".spanError").remove();
    this.validator.isFieldEmpty('#username');
    this.validator.isFieldEmpty('#firstname');
    this.validator.isFieldEmpty('#lastname');
    this.validator.isNumberValid("#mobile",/^[\d]{10,12}$/, '10-12')
    this.validator.isNumberValid("#phone",/^[\d]{6,8}$/, '6-8')
    this.validator.isPasswordValid('#password');
    this.validator.isEmailValid("#email");
    this.validator.isRadioSelected("#gender", "gender");
    this.validator.isFieldChecked("#privacy");
    if($("#formregister").find('.spanError').length==0 && $("#formregister").find(".emailError").length==0 && $("#formregister").find(".userError").length==0){
      return true;
    }else{
      return false;
    }
  }

  resetForm(){
    $(".spanError").remove();
    $(".userError").remove();
    $(".emailError").remove();
    $("#privacy").prop("checked",false);
    this.registerForm.reset();
  }

  get username(){
    return this.registerForm.get("username")?.value;
  }

  get email(){
    return this.registerForm.get("email")?.value;
  }

}
