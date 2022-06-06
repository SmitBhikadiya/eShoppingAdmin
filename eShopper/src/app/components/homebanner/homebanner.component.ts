import { Component, Input, OnDestroy, OnInit, ViewChild } from '@angular/core';
import { NgImageSliderComponent } from 'ng-image-slider';
import { CarouselComponent, OwlOptions } from 'ngx-owl-carousel-o';
import { OwlDOMData } from 'ngx-owl-carousel-o/lib/models/owlDOM-data.model';
import { CarouselService, Width } from 'ngx-owl-carousel-o/lib/services/carousel.service';
import { ApplicationService } from 'src/app/services/application.service';
import { NotificationService } from 'src/app/services/notification.service';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-homebanner',
  templateUrl: './homebanner.component.html',
  styleUrls: ['./homebanner.component.css']
})
export class HomebannerComponent implements OnInit, OnDestroy { 
  
  bannerImageURLs = [];
  testimonialData = null;
  bannerwidth = window.innerWidth;
  customOptions1!:OwlOptions;
  @ViewChild('synk1') carousel!: CarouselComponent;
  //@ViewChild('slider') slider!:NgImageSliderComponent;

  constructor(
    private appService:ApplicationService,
    private toaster:NotificationService
  ) { 
    window.addEventListener('resize', this.changeWidth);
  }

  ngOnDestroy() {
    console.log("Home Banner Removed");
  }

  ngOnInit() {
    this.getBanners();
  }

  setOption(){
    this.customOptions1 = {
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
      lazyLoad: true,
      navText: ['', ''],
      nav: false,
      responsive: {
        0: {
          items: 1
        }
      }
    }
  }

  changeWidth = (e:any)=>{
    this.bannerwidth = window.innerWidth;
    const anyService = this.carousel as any;
    const carouselService = anyService.carouselService as CarouselService;
    carouselService._options.center = true;
    carouselService.setCarouselWidth(window.innerWidth+1);
    carouselService.refresh();
    carouselService.update();
  }

  getBanners(){
    this.appService.getBanners().subscribe({
      next: (res) =>{
        const result = res.result;
        if(result.length > 0){
          this.bannerImageURLs = result.map((banner:any) => { 
            return `${environment.IMAGES_SERVER_URL}/banners/${banner['bannerImageURL']}`;
            // return {
            //   image: `${environment.IMAGES_SERVER_URL}/banners/${banner['bannerImageURL']}`,
            //   thumbImage: `${environment.IMAGES_SERVER_URL}/banners/${banner['bannerImageURL']}`,
            //   alt: 'banner',
            // }
          });
          this.setOption();
        }
        // this.slider.infinite = true;
        // this.slider.autoSlide = 1;
        // this.slider.animationSpeed = 1;
        // this.slider.imagePopup = false;
        // this.slider.showArrow = true;
        // //this.slider.lazyLoading = true;
        // this.slider.imageMargin = 0;
        // this.slider.slideImage = 1;
        // this.slider.imageSize = {
        //   width: `${window.innerWidth}px`,
        //   height: '500px',
        //   space: 0
        // }
      },
      error: (err) =>{
        this.toaster.showError(err.error.message,"ServerError");
      }
    });
  }

  // slideImage(){
  //     this.slider.next();
  // }
}
