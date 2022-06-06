import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { CustomValidation } from 'src/app/customValidation';
import { NewsletterService } from 'src/app/services/newsletter.service';
import { NotificationService } from 'src/app/services/notification.service';
declare let $:any;

@Component({
  selector: 'app-newsletter',
  templateUrl: './newsletter.component.html',
  styleUrls: ['./newsletter.component.css']
})
export class NewsletterComponent implements OnInit {

  newsletterForm!:FormGroup;

  constructor(
    private builder:FormBuilder,
    private newsService: NewsletterService,
    private toaster:NotificationService
  ) { }

  ngOnInit(): void {
    this.newsletterForm = this.builder.group({
      email: ['', [Validators.required,Validators.email]]
    });
  }

  subscribeNewsletter(){
    const id = "#newsletter_email";
    this.isEmailValid(id);
    if($("#newsletterForm").find('.spanError').length==0 && this.newsletterForm.valid){
      const email = this.newsletterForm.controls['email'].value;
      this.newsService.subscribeNewsletter(email).subscribe({
        next:(res)=>{
          if(res.error==''){
            $(id).parent().find('label').after('<p class="thankyou-msg">Thank you for your subscription.</p>');
          }else{
            this.toaster.showError(res.error);
          }
        },
        error: (err)=>{
          $(id).parent().find('.thankyou-msg').remove();
          this.toaster.showError(err.error.message,"ServerError");
        }
      });
    }
  }

  isEmailValid(id:string){
    $(id).parent().find('.thankyou-msg').remove();
    var reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    let value = $(id).val();
    if (value.length == 0) {
      $(id).parent().find('label').after("<span class='thankyou-msg spanError' style='margin-top:-24px;'>*Email can't be empty!!</span>");
    } else if (!reg.test(value)) {
      $(id).parent().find('label').after("<span class='thankyou-msg spanError' style='margin-top:-24px;'>*Enter a valid email!!</span>");
    }
  }


}
