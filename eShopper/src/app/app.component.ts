import { CurrencyPipe } from '@angular/common';
import { Component, OnDestroy, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { filter } from 'rxjs';
import { HeaderComponent } from './components/header/header.component';
import { RegisterComponent } from './components/register/register.component';
import { CustomValidation } from './customValidation';
import { IProduct } from './interfaces/product';
import { CartService } from './services/cart.service';
import { UserAuthService } from './services/user-auth.service';
declare let $: any;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit, OnDestroy {

  constructor( ) {
  }

  ngOnDestroy() {
    document.removeEventListener('click', this.listenSearchBox);
  }

  ngOnInit() {
    document.addEventListener('click', this.listenSearchBox);
  }

  listenSearchBox(e:any){
    const search = <HTMLElement>document.querySelector(".search-link");
    const myclosest = e.target.closest(".search-link ");
    if(myclosest==null && search.classList.contains('active')){
      search.classList.remove('active');
    }
  }

}
