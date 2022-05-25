import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { CustomValidation } from 'src/app/customValidation';
import { NotificationService } from 'src/app/services/notification.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
declare let $:any;

@Component({
  selector: 'app-forgotpassword',
  templateUrl: './forgotpassword.component.html',
  styleUrls: ['./forgotpassword.component.css']
})
export class ForgotpasswordComponent implements OnInit, OnDestroy {

  generateOTPForm!: FormGroup;
  validateOTPForm!:FormGroup;
  validator = new CustomValidation();
  isLoggin: boolean = false;
  email = '';
  otpVerify = false;
  spinnerDisplay = false;

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

    this.generateOTPForm = this.builder.group({
      email: ['', [Validators.required, Validators.email]],
    });

    this.setOTPForm(this.email, '', '', '', 'Verify');
  }

  setOTPForm(email:string, otp:string, newpassword:string, repassword:string, btn:string){
    this.validateOTPForm = this.builder.group({
      email: [email, [Validators.required]],
      otp: [otp, [Validators.required, Validators.min(6)]],
      newpassword: [newpassword, [Validators.required, Validators.min(6), Validators.max(16)]],
      repassword: [repassword, [Validators.required, Validators.min(6), Validators.max(16)]],
      btn: [btn]
    });
  }

  validateOTP(){
    $("#otp").css("pointer-events", "auto");
    const email = this.validateOTPForm.controls['email'].value;
    const otp = this.validateOTPForm.controls['otp'].value;
    const newpassword = this.validateOTPForm.controls['newpassword'].value;
    const repassword = this.validateOTPForm.controls['repassword'].value;
    if( this.validateOTPVerifyForm() && otp!='' && email!='' && !this.otpVerify && newpassword=='' && repassword==''){
      this.userAuth.verifyOTP(otp, email).subscribe({
        next: (res) => {
          if(res.error == ''){
            this.otpVerify = true;
            $("#otp").css("pointer-events", "none");
            this.setOTPForm(this.email, otp, '', '', 'Submit');
          }else{
            this.otpVerify = false;
            $("#otp").css("pointer-events", "auto");
            this.toaster.showError(res.error);
          }
        }, 
        error: (err) => {
          this.otpVerify = false;
        }
      });
    }else if( this.validatePassowrdUpdateForm() && otp!='' && email!='' && this.otpVerify && newpassword!='' && repassword!=''){
      this.userAuth.updatePasswordByOTP(otp, email, newpassword, repassword).subscribe({
        next: (res)=>{
          if(res.error==''){
            this.setAllDefault();
            $("#newpassword-popup").modal("hide");
            $("#Login-popup").modal("show");
            this.toaster.showSuccess("Password has been changed successfully!!!");
          }else{
            this.toaster.showError(res.error);
          }
        },
        error: (err)=>{
          this.toaster.showError(err,"ServerError");
        }
      });
    }
  }

  generateOTP(){
   this.clearOTPInterval();
   this.otpVerify = false;
   this.validateOTPForm.reset();
   $("#btn_otpgenerator").css('pointer-events', 'none');
   $("#otp").css('pointer-events', 'auto');
   let email = this.generateOTPForm.controls['email'].value;
    if(this.validateGenerateOTPForm()){
      this.userAuth.forgotPassword(email).subscribe({
        next: (res)=>{
         if(res.error==''){
           this.email = email;
           this.setTimer(res.expiry);
           this.setOTPForm(this.email, '', '', '', 'Verify');
           $("#forgotpassword-popup").modal('hide');
           $("#newpassword-popup").modal('show');
           $("#btn_otpgenerator").css('pointer-events', 'auto');
           this.toaster.showSuccess("OTP has been send to your mail successfully!!");
         }else{
           this.email = '';
           this.toaster.showError(res.error);
           $("#btn_otpgenerator").css('pointer-events', 'auto');
         }
        },
        error: (err)=>{
         this.email = '';
         this.toaster.showError(err, 'ServerError');
         $("#btn_otpgenerator").css('pointer-events', 'auto');
        }
      });
    }
  }

  otpExpiryInterval:any;

  setTimer(expiry:string){
    const exp_time = new Date(expiry);
    
    this.otpExpiryInterval = setInterval(()=>{
      let curr_time = new Date();
      let exp_time_in_seconds = exp_time.getTime()/1000;
      let curr_time_in_seconds = curr_time.getTime()/1000;
      let diff_in_seconds = parseInt((exp_time_in_seconds-curr_time_in_seconds).toString());
     if(diff_in_seconds > 0){
        $("#expiryIn").html( ("0"+parseInt((diff_in_seconds/60).toString())).slice(-2) + ':' + ("0"+parseInt((diff_in_seconds%60).toString())).slice(-2) );
      }else{
        this.toaster.showWarning("OTP has been expired!!!");
        $("#newpassword-popup").modal("hide");
        $("#forgotpassword-popup").modal("show");
        this.setAllDefault();
      }
    }, 1000);
  }

  clearOTPInterval(){
    clearInterval(this.otpExpiryInterval);
  }

  setAllDefault(){
    this.generateOTPForm.reset();
    this.validateOTPForm.reset();
    this.email = '';
    this.otpVerify = false;
    this.spinnerDisplay = false;
    this.clearOTPInterval();
    $("#btn_otpgenerator").css('pointer-events', 'auto');
    $("#otp").css('pointer-events', 'auto');
  }

  validateGenerateOTPForm(){
    $(".spanError").remove();
    this.validator.isEmailValid("#otpemail");
    if ($("#generateOTPForm").find('.spanError').length == 0) {
      return true;
    } else {
      return false;
    }
  }

  validateOTPVerifyForm(){
    $(".spanError").remove();
    this.validator.isNumberValid("#otp", /^[0-9]{6}$/);
    if ($("#validateOTPForm").find('.spanError').length == 0) {
      return true;
    } else {
      return false;
    }
  }

  validatePassowrdUpdateForm(){
    $(".spanError").remove();
    this.validator.isNumberValid("#otp", /^[0-9]{6}$/);
    this.validator.isPasswordValid("#otpnewpassword");
    this.validator.isPasswordValid("#otprepassword");
    this.validator.isPasswordMatched("#otpnewpassword", "#otprepassword");
    if ($("#validateOTPForm").find('.spanError').length == 0) {
      return true;
    } else {
      return false;
    }
  }

  ngOnDestroy() : void{
    //console.log("Ng Destroy Called");
    this.setAllDefault();
  }

}
