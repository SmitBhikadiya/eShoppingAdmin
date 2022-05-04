import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CartDetailesComponent } from './components/cart-detailes/cart-detailes.component';
import { ErrorComponent } from './components/error/error.component';
import { HomeComponent } from './components/home/home.component';
import { ProductDetailesComponent } from './components/product-detailes/product-detailes.component';
import { ProductsComponent } from './components/products/products.component';
import { ProfileComponent } from './components/profile/profile.component';
import { RegisterComponent } from './components/register/register.component';
import { AuthGuard } from './guards/auth.guard';

const routes: Routes = [
  {
    path:'',
    component:HomeComponent
  },
  {
    path:'register',
    component:RegisterComponent
  },
  {
    path:'profile',
    component:ProfileComponent,
    canActivate: [AuthGuard]
  },
  {
    path:'product',
    redirectTo: '',
    pathMatch: 'full'
  },
  {
    path:'productInfo/:id',
    component: ProductDetailesComponent
  },
  {
    path: 'product/:category',
    component:ProductsComponent
  },
  {
    path: 'product/:category/:subcategory',
    component:ProductsComponent
  },
  {
    path: 'cart',
    component: CartDetailesComponent,
    canActivate: [AuthGuard]
  },{
    path: '**',
    component:ErrorComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
