import { Component, OnInit } from '@angular/core';
import { OwlOptions } from 'ngx-owl-carousel-o';
import { ApplicationService } from 'src/app/services/application.service';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-homebanner',
  templateUrl: './homebanner.component.html',
  styleUrls: ['./homebanner.component.css']
})
export class HomebannerComponent implements OnInit { 
  
  bannerImageURLs = null;
  testimonialData = null;

  customOptions1: OwlOptions = {
    loop: true,
    center: true,
    autoWidth: true,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: true,
    navSpeed: 700,
    autoplay:true,
    dots: false,
    dotsData: false,
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
    this.getBanners();
  }

  
  getBanners(){
    this.appService.getBanners().subscribe({
      next: (res) =>{
        const result = res.result;
        console.log(result.length);
        if(result.length > 0){
          this.bannerImageURLs = result.map((banner:any) => { return `${environment.IMAGES_SERVER_URL}/banners/${banner['bannerImageURL']}` });
        }
        //this.getTestimonials();
        console.log(this.bannerImageURLs); 
      },
      error: (err) =>{
        console.log(123,err);
      }
    });
  }
}
