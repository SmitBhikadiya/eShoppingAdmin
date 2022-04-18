import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AddressService } from './services/address.service';
import { CategoryService } from './services/category.service';
import { ProductService } from './services/product.service';
import { CustomerService } from './services/customer.service';
import { HeaderComponent } from './components/header/header.component';
import { FooterComponent } from './components/footer/footer.component';
import { HomeComponent } from './components/home/home.component';
import { ProductDetailesComponent } from './components/product-detailes/product-detailes.component';
import { ProductsComponent } from './components/products/products.component';
import { StrtoarrayPipe } from './pipes/strtoarray.pipe';
import { TitleCaptilizePipe } from './pipes/title-captilize.pipe';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    HomeComponent,
    ProductDetailesComponent,
    ProductsComponent,
    StrtoarrayPipe,
    TitleCaptilizePipe
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule
  ],
  providers: [
    AddressService,
    CategoryService,
    ProductService,
    CustomerService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
