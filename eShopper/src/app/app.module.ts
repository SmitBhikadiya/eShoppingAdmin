import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AddressService } from './services/address.service';
import { CategoryService } from './services/category.service';
import { ProductService } from './services/product.service';
import { HeaderComponent } from './components/header/header.component';
import { FooterComponent } from './components/footer/footer.component';
import { HomeComponent } from './components/home/home.component';
import { ProductDetailesComponent } from './components/product-detailes/product-detailes.component';
import { ProductsComponent } from './components/products/products.component';
import { StrtoarrayPipe } from './pipes/strtoarray.pipe';
import { TitleCaptilizePipe } from './pipes/title-captilize.pipe';
import { RegisterComponent } from './components/register/register.component';
import { ProfileComponent } from './components/profile/profile.component';
import { FilterStringPipe } from './pipes/filter-string.pipe';
import { UserAuthService } from './services/user-auth.service';
import { ErrorComponent } from './components/error/error.component';

import { CarouselModule } from 'ngx-owl-carousel-o';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AuthGuard } from './guards/auth.guard';
import { AuthInterceptorService } from './services/auth-interceptor.service';
import { AddToCartBtnComponent } from './components/add-to-cart-btn/add-to-cart-btn.component';
import { CartDetailesComponent } from './components/cart-detailes/cart-detailes.component';
import { CurrencyPipe } from '@angular/common';

// for toster message
import { ToastrModule } from 'ngx-toastr';
import { SetCurrPipe } from './pipes/set-curr.pipe';
import { OrderSuccessComponent } from './components/order-success/order-success.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    HomeComponent,
    ProductDetailesComponent,
    ProductsComponent,
    StrtoarrayPipe,
    TitleCaptilizePipe,
    RegisterComponent,
    ProfileComponent,
    FilterStringPipe,
    ErrorComponent,
    AddToCartBtnComponent,
    CartDetailesComponent,
    SetCurrPipe,
    OrderSuccessComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
    CarouselModule,
    BrowserAnimationsModule,
    ToastrModule.forRoot()
  ],
  providers: [
    AddressService,
    CategoryService,
    ProductService,
    UserAuthService,
    AuthGuard,
    CurrencyPipe,
    SetCurrPipe,
    {
      provide: HTTP_INTERCEPTORS,useClass: AuthInterceptorService, multi: true 
    },
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
