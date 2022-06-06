import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { CustomValidation } from 'src/app/customValidation';
import { NotificationService } from 'src/app/services/notification.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
declare let $: any;

@Component({
  selector: 'app-changepassword',
  templateUrl: './changepassword.component.html',
  styleUrls: ['./changepassword.component.css']
})
export class ChangepasswordComponent implements OnInit {

  changePasswordForm!: FormGroup;
  validator = new CustomValidation();
  isLoggin: boolean = false;
  triggerError = false;
  @ViewChild('changepasswordPopup') changePsw!:ElementRef;

  constructor(
    private userAuth: UserAuthService,
    private toaster: NotificationService,
    private router: Router,
    private spinnerService: NgxSpinnerService,
    private builder: FormBuilder) {

    this.isLoggin = userAuth.isLoggedIn();

    userAuth.isUserLoggedIn.subscribe((res) => {
      this.isLoggin = res;
    });

  }

  ngOnInit() {
    this.changePasswordForm = this.builder.group({
      oldpassword: ['', [Validators.required, Validators.pattern(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/)]],
      newpassword: ['', [Validators.required, Validators.pattern(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/)]],
      repassword: ['', [Validators.required, Validators.pattern(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/)]]
    });
  }

  changePassword() {
    if (this.isLoggin) {
      this.triggerError = true;
      this.spinnerService.show("change");
      const token = JSON.parse(this.userAuth.getToken());
      if (this.isFormValidate()) {
          this.triggerError = false;
          const userId = token.user.id;
          const oldpsw = this.changePasswordForm.controls['oldpassword'].value;
          const newpsw = this.changePasswordForm.controls['newpassword'].value;
          const repsw = this.changePasswordForm.controls['repassword'].value;
          this.userAuth.changePassword(userId, oldpsw, newpsw, repsw).subscribe({
            next: (res) => {
              const error = res.error;
              this.changePasswordForm.reset();
              if (error == '') {
                this.userAuth.logout();
                this.changePsw.nativeElement.click();
                this.toaster.showSuccess("Password is changed Successfully!!", "Password");
              } else {
                this.toaster.showError(error, "Password");
              }
              this.spinnerService.hide("change");
            },
            error: (err) => {
              this.toaster.showError(err.error.message, "ServerError");
              this.spinnerService.hide("change");
            }
          });
      }else{
        this.spinnerService.hide("change");
      }
    }else{
      this.toaster.showWarning("You are not login!! do login first!!!");
      this.spinnerService.hide("change");
    }
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

  isFormValidate() {
    Object.keys(this.changePasswordForm.controls).forEach(field => {
      const control = this.changePasswordForm.get(field);
      control?.markAsTouched({ onlySelf: true });  
    });
    return this.changePasswordForm.valid;
  }

  get oldpassword(){
    return this.changePasswordForm.controls['oldpassword'];
  }

  get newpassword(){
    return this.changePasswordForm.controls['newpassword'];
  }

  get repassword(){
    return this.changePasswordForm.controls['repassword'];
  }

}
