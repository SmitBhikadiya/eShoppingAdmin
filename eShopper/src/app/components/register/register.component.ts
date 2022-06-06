import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { UserAuthService } from 'src/app/services/user-auth.service';
import { CustomValidation } from 'src/app/customValidation';
import { Router } from '@angular/router';
import { NotificationService } from 'src/app/services/notification.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { environment } from 'src/environments/environment';
declare let $: any;
@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

  registerForm!: FormGroup;
  isFormValid: boolean = false;
  isLoggedIn = false;
  triggerError = false;
  noImg:string = environment.IMAGES_SERVER_URL+"/noimage.jpg";
  imageSrc:string = this.noImg;
  validator = new CustomValidation();
  constructor(
    private builder: FormBuilder,
    private route: Router,
    private userauth: UserAuthService,
    private toaster: NotificationService,
    private spinnerService: NgxSpinnerService
  ) { }

  ngOnInit(): void {
    this.registerForm = this.builder.group({
      username: ['', [Validators.required]],
      password: ['', [Validators.required, Validators.pattern(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/)]],
      email: ['', [Validators.required, Validators.email]],
      firstname: ['', [Validators.required]],
      lastname: ['', [Validators.required]],
      mobile: ['', [Validators.required, Validators.pattern(/^[\d]{10,12}$/)]],
      gender: ['', [Validators.required]],
      phone: ['', [Validators.required, Validators.pattern(/^[\d]{6,8}$/)]],
      policy: [false, [Validators.requiredTrue]],
      profile: ['', [Validators.required]]
    });
  }

  onChangeFile(e:any){
    if(e.target.files.length > 0){
      const file = e.target.files[0];
      const reader:any = new FileReader();
      reader.onload = (e:any) => {
        this.imageSrc = e.target.result;
      };
      reader.readAsDataURL(file);
      this.registerForm.patchValue({
        profile: file
      });
    }else{
      this.registerForm.patchValue({
        profile: ''
      });
      this.imageSrc = this.noImg;
    }
  }

  registerUser() {
    this.triggerError = true;
    this.spinnerService.show("register");
    if (this.formValidate()) {
      this.triggerError = false;
      let userdata = new FormData();
      userdata.append('username', this.registerForm.get('username')?.value);
      userdata.append('firstname', this.registerForm.get('firstname')?.value);
      userdata.append('lastname', this.registerForm.get('lastname')?.value);
      userdata.append('email', this.registerForm.get('email')?.value);
      userdata.append('password', this.registerForm.get('password')?.value);
      userdata.append('gender', this.registerForm.get('gender')?.value);
      userdata.append('mobile', this.registerForm.get('mobile')?.value);
      userdata.append('phone', this.registerForm.get('phone')?.value);
      userdata.append('profile', this.registerForm.get('profile')?.value);
      this.userauth.userRegister(userdata).subscribe({
        next: (res) => {
          if (res.error == '') {
            this.toaster.showSuccess(`${res.username} is registered successfully!!`);
          } else {
            this.toaster.showError(res.error);
          }
          this.registerForm.reset();
          this.spinnerService.hide("register");
        },
        error: (err) => {
          this.toaster.showError(err.error.message,"ServerError");
          this.spinnerService.hide("register");
        }
      });
    } else {
      this.spinnerService.hide("register");
    }
  }

  toggleEye(event: Event, loginpass: HTMLInputElement) {
    const inputElem = loginpass;
    const imgElem = <HTMLElement>event.target;
    if (inputElem.getAttribute('type') == 'password') {
      inputElem.setAttribute('type', 'text');
      imgElem.setAttribute('src', '../../../assets/images/eye-solid.svg');
    } else {
      inputElem.setAttribute('type', 'password');
      imgElem.setAttribute('src', '../../../assets/images/eye-slash-solid.svg');
    }
  }

  isUserNameExits(username: string) {
    $(".userError").remove();
    this.userauth.isUsernameExits(username).subscribe({
      next: (res) => {
        if (res["result"].length == 0) {
          $(".userError").remove();
        } else {
          $("#username").after("<span class='userError' style='color: red; margin-top: 4px;'> username is already exits!!</span>");
        }
      },
      error: (err) => {
        this.toaster.showError(err, "ServerError");
      }
    });
  }

  isEmailExits(email: string) {
    $(".emailError").remove();
    this.userauth.isEmailExits(email).subscribe({
      next: (res) => {
        if (res["result"].length == 0) {
          $(".emailError").remove();
        } else {
          $("#email").after("<span class='emailError' style='color: red; margin-top: 4px;'> email is already exits!!</span>");
        }
      }, error: (err) => {
        this.toaster.showError(err.error.message,"ServerError");
      }
    });
  }

  formValidate() {
    Object.keys(this.registerForm.controls).forEach(field => {
      const control = this.registerForm.get(field);
      control?.markAsTouched({ onlySelf: true });
    });
    return this.registerForm.valid;
  }

  resetForm() {
    $(".userError").remove();
    $(".emailError").remove();
    this.triggerError = false;
    this.registerForm.reset();
  }

  get newpassword() { return this.registerForm.controls['password'] }
  get profile() { return this.registerForm.controls['profile'] }
  get firstname() { return this.registerForm.controls['firstname'] }
  get lastname() { return this.registerForm.controls['lastname'] }
  get mobile() { return this.registerForm.controls['mobile'] }
  get gender() { return this.registerForm.controls['gender'] }
  get phone() { return this.registerForm.controls['phone'] }
  get username() { return this.registerForm.controls["username"]; }
  get email() { return this.registerForm.controls["email"]; }
  get policy() { return this.registerForm.controls["policy"]; }

}
