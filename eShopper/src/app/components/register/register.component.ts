import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { UserAuthService } from 'src/app/services/user-auth.service';
declare var $:any;

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

  registerForm!:FormGroup;
  isAnyError:boolean = false;
  isFormValid:boolean = false;
  message:string = '';
  constructor(private builder:FormBuilder, private userauth:UserAuthService) { }

  ngOnInit(): void {
    this.registerForm = this.builder.group({
      username: ['',[Validators.required]],
      password: ['', [Validators.required, Validators.pattern('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,}$/')]],
      email: ['', [Validators.required, Validators.email]],
      firstname: ['', [Validators.required]],
      lastname: ['', [Validators.required]],
      mobile: ['', [Validators.required, Validators.pattern('/^[0-9]{12}$/')]],
      gender: ['0', [Validators.required]],
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
        console.log(userdata);
        // this.userauth.userRegister(userdata).subscribe((res)=>{
        //   if(res.error == ''){
        //     this.isAnyError = true;
        //     this.message = `${res.username} is registered successfully!!`;
        //     setTimeout(()=>{
        //       this.isAnyError = false;
        //       this.message = '';
        //     }, 5000);
        //   }
        //   this.registerForm.reset();
        // });
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
    this.isFieldEmpty('#username');
    this.isFieldEmpty('#firstname');
    this.isFieldEmpty('#lastname');
    this.isNumberValid("#mobile",/^[\d]{10,12}$/, '10-12')
    this.isNumberValid("#phone",/^[\d]{6,8}$/, '6-8')
    this.isPasswordValid('#password');
    this.isEmailValid("#email");
    this.isFieldChecked("#privacy");
    if($("#formregister").find('.spanError').length==0 && $("#formregister").find(".custom_error").length==0){
      return true;
    }else{
      return false;
    }
  }

  isFieldChecked(id:string){
    let is = $(id).is(":checked");
    if(!is){
      $(id).parent().after("<span class='spanError'>* Privacy and policy must be selected!!</span>");
    }
  }

  isNumberValid(id:string, reg:RegExp, range:string){
    let value = $(id).val();
    if(value.length == 0){
      $(id).after("<span class='spanError'>* field can't be empty!!</span>");
    }else if(!reg.test(value)){
      $(id).after("<span class='spanError'>*Mobile must be "+range+" charcters long</span>");
    }
  }

  isFieldEmpty(id:string){
    let value = $(id).val();
    if(value.length == 0){
      $(id).after("<span class='spanError'>* field can't be empty!!</span>");
    }
  }

  isPasswordValid(id:string){
    var reg = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/;
    let value = $(id).val();
    if(value.length == 0){
      $(id).after("<span class='spanError'>* field can't be empty!!</span>");
    }else if(!reg.test(value)){
      $(id).after("<span class='spanError'>*At least one uppercase, lowercase, special char, numbers and 6 to 14 characters longer</span>");
    }
  }

  isEmailValid(id:string){
    var reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    let value = $(id).val();
    if(value.length == 0){
      $(id).after("<span class='spanError'>* field can't be empty!!</span>");
    }else if(!reg.test(value)){
      $(id).after("<span class='spanError'>*Enter a valid email!!</span>");
    }
  }

  get username(){
    return this.registerForm.get("username")?.value;
  }

  get email(){
    return this.registerForm.get("email")?.value;
  }

}
