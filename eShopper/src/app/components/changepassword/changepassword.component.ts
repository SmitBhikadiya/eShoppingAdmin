import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
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

  constructor(
    private userAuth: UserAuthService,
    private toaster: NotificationService,
    private router: Router,
    private builder: FormBuilder) {

    this.isLoggin = userAuth.isLoggedIn();

    userAuth.isUserLoggedIn.subscribe((res) => {
      this.isLoggin = res;
    });

  }

  ngOnInit() {
    this.changePasswordForm = this.builder.group({
      oldpassword: ['', [Validators.min(6), Validators.max(14)]],
      newpassword: ['', [Validators.min(6), Validators.max(14)]],
      repassword: ['', [Validators.min(6), Validators.max(14)]]
    });
  }

  changePassword() {
    if (this.isLoggin) {
      const token = JSON.parse(this.userAuth.getToken());
      if (this.isFormValidate() && this.changePasswordForm.valid) {
          const userId = token.user.id;
          const oldpsw = this.changePasswordForm.controls['oldpassword'].value;
          const newpsw = this.changePasswordForm.controls['newpassword'].value;
          const repsw = this.changePasswordForm.controls['repassword'].value;
          //console.log(userId, oldpsw, newpsw, repsw);
          this.userAuth.changePassword(userId, oldpsw, newpsw, repsw).subscribe({
            next: (res) => {
              console.log(res);
              
              const error = res.error;
              this.changePasswordForm.reset();
              if (error == '') {
                this.toaster.showSuccess("Password is changed Successfully!!", "Password");
              } else {
                this.toaster.showError(error, "Password");
              }
            },
            error: (err) => {
              this.toaster.showError(err['error'], "ServerError");
            }
          });
      }
    }
  }

  isFormValidate() {
    $(".spanError").remove();
    this.validator.isPasswordValid("#loginpass_old");
    this.validator.isPasswordValid("#loginpass_new");
    this.validator.isPasswordValid("#loginpass_re");
    this.validator.isPasswordMatched("#loginpass_new", "#loginpass_re");
    if ($("#changePasswordForm").find('.spanError').length == 0) {
      return true;
    } else {
      return false;
    }
  }

}
