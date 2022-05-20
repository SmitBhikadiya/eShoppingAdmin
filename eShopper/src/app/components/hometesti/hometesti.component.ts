import { Component, OnInit } from '@angular/core';
import { OwlOptions } from 'ngx-owl-carousel-o';
import { ApplicationService } from 'src/app/services/application.service';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-hometesti',
  templateUrl: './hometesti.component.html',
  styleUrls: ['./hometesti.component.css']
})
export class HometestiComponent implements OnInit {

  testimonialData = null; 
  
  customOptions1: OwlOptions = {
    loop: true,
    center: true,
    autoWidth: true,
    autoHeight:true,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: true,
    navSpeed: 700,
    autoplay: true,
    dots: true,
    dotsData: true,
    navText: ['', ''],
    nav: false,
    responsive: {
      0: {
        items: 1
      },
      400: {
        items: 1
      },
      740: {
        items: 1
      },
      940: {
        items: 1
      }
    }
  }

  constructor(
    private appService:ApplicationService
  ) { }

  ngOnInit(): void {
    this.getTestimonials();
  }

  getTestimonials(){
    this.appService.getTestimonials().subscribe({
      next: (res) =>{
        const result = res.result;
        if(result.length > 0){
          this.testimonialData = result.map((data:any)=>{
            return {
              ...data,
              reviewerImage: `${environment.IMAGES_SERVER_URL}/testimonials/${data.reviewerImage}`
            }
          });
        }
        console.log(this.testimonialData);
      },
      error: (err) =>{
        console.log(123,err);
      }
    });
  }

}
