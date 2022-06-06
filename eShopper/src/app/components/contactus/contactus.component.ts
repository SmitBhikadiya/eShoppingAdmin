import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ApplicationService } from 'src/app/services/application.service';
import { NotificationService } from 'src/app/services/notification.service';

@Component({
  selector: 'app-contactus',
  templateUrl: './contactus.component.html',
  styleUrls: ['./contactus.component.css']
})
export class ContactusComponent implements OnInit {

  triggerError = false;
  contactForm!:FormGroup;
  loading = 'clickable';
  constructor(
    private builder:FormBuilder,
    private appService:ApplicationService,
    private toaster:NotificationService
  ) { }

  ngOnInit(): void {
    this.contactForm = this.builder.group({
      name: ['', [Validators.required]],
      email: ['', [Validators.required, Validators.email]],
      subject: ['', [Validators.required]],
      message: ['', [Validators.required]]
    });
  }

  contactUs(){
    this.triggerError = true;
    if(this.isContactUsValid()){
      this.triggerError = false;
      console.log(this.contactForm.value); 
      this.loading = 'notclickable';     
      this.appService.contactUs(this.name?.value, this.subject?.value, this.email?.value, this.message?.value).subscribe({
        next: (res) => {
          this.loading = 'clickable';
          console.log(res);
          if(res.error==''){
            this.toaster.showSuccess("Your request has been submitted successfully!!");
            this.contactForm.reset();
          }else{
            this.toaster.showError(res.error.message, "ServerError");
          }
        },
        error: (err) => {
          this.loading = 'clickable';
          this.toaster.showError(err.error.message,"ServerError");
        }
      });
    }
  }

  isContactUsValid(){
    Object.keys(this.contactForm.controls).forEach(field => {
      const control = this.contactForm.get(field);
      control?.markAsTouched({ onlySelf: true });  
    });
    return this.contactForm.valid;
  }

  get name(){
    return this.contactForm.get('name');
  }
  get email(){
    return this.contactForm.get('email');
  }
  get subject(){
    return this.contactForm.get('subject');
  }
  get message(){
    return this.contactForm.get('message');
  }

}
