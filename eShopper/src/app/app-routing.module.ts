import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AboutusComponent } from './components/aboutus/aboutus.component';
import { CartDetailesComponent } from './components/cart-detailes/cart-detailes.component';
import { ContactusComponent } from './components/contactus/contactus.component';
import { CouponsComponent } from './components/coupons/coupons.component';
import { ErrorComponent } from './components/error/error.component';
import { HomeComponent } from './components/home/home.component';
import { OrderDetailsComponent } from './components/order-details/order-details.component';
import { OrdersComponent } from './components/orders/orders.component';
import { PaymentSuccessComponent } from './components/payment-success/payment-success.component';
import { ProductDetailesComponent } from './components/product-detailes/product-detailes.component';
import { ProductsComponent } from './components/products/products.component';
import { ProfileComponent } from './components/profile/profile.component';
import { RegisterComponent } from './components/register/register.component';
import { SearchComponent } from './components/search/search.component';
import { WishlistComponent } from './components/wishlist/wishlist.component';
import { AuthGuard } from './guards/auth.guard';

const routes: Routes = [
  { path:'', pathMatch: 'full', component:HomeComponent },
  { path:'search', component: SearchComponent },
  { path:'register', component:RegisterComponent },
  { path:'profile', component:ProfileComponent, canActivate: [AuthGuard] },
  { path:'product', redirectTo: '', pathMatch: 'full' },
  { path:'productInfo/:id', pathMatch: 'full', component: ProductDetailesComponent },
  { path: 'product/:category', pathMatch: 'full', component:ProductsComponent },
  { path: 'product/:category/:subcategory', pathMatch: 'full', component:ProductsComponent },
  { path: 'orders', component: OrdersComponent, canActivate: [AuthGuard] },
  { path: 'orders/view/:ordId', component: OrderDetailsComponent, canActivate: [AuthGuard] },
  { path: 'coupons', component: CouponsComponent },
  { path: 'aboutus', component: AboutusComponent },
  { path: 'contactus', component: ContactusComponent },
  { path: 'wishlist', component:WishlistComponent, canActivate: [AuthGuard] },
  { path: 'cart', component: CartDetailesComponent, canActivate: [AuthGuard] },
  { path: 'cart/:payment/:ordId/:userId', pathMatch: 'full', component: PaymentSuccessComponent, canActivate: [AuthGuard] },
  { path: 'cart/:payment/:ordId/:userId/:couponId', pathMatch: 'full', component: PaymentSuccessComponent, canActivate: [AuthGuard] },
  { path: '**', component:ErrorComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
