import { Component, OnInit } from '@angular/core';
import { ApplicationService } from 'src/app/services/application.service';
import { NotificationService } from 'src/app/services/notification.service';

@Component({
  selector: 'app-aboutus',
  templateUrl: './aboutus.component.html',
  styleUrls: ['./aboutus.component.css']
})
export class AboutusComponent implements OnInit {

  content = '<h1>Not Found</h1>';
  constructor(
    private appService:ApplicationService,
    private toaster:NotificationService
  ) { }

  ngOnInit(): void {
    this.getAboutUs();
  }

  getAboutUs(){
    this.appService.getAboutUs().subscribe({
      next: (res)=>{
        this.content = res.result.content;
      },
      error: (err)=>{
        this.toaster.showError(err.error.message,"ServerError");
      }
    });
  }

}
