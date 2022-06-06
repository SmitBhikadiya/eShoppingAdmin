import { Component, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ICategory } from 'src/app/interfaces/category';
import { ISubCategory } from 'src/app/interfaces/subcategory';
import { CartService } from 'src/app/services/cart.service';
import { CategoryService } from 'src/app/services/category.service';
import { CurrencyService } from 'src/app/services/currency.service';
import { NotificationService } from 'src/app/services/notification.service';
import { ProductService } from 'src/app/services/product.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
import { environment } from 'src/environments/environment';
declare let $: any;

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit, OnDestroy {

  categories!: ICategory[];
  subcategories!: ISubCategory[];
  error!: string;
  username: any = '';
  noImg:string = environment.IMAGES_SERVER_URL+"/noimage.jpg";
  profileImg:string = this.noImg;
  isLoggin: boolean = false;
  cartItems = null;
  isCartVisisble: boolean = true;
  subTotal: any;
  currency = 'inr';
  toggleCart = false;
  imgServerURL = environment.IMAGES_SERVER_URL;

  constructor(
    private cartService: CartService,  
    private catService: CategoryService, 
    private toast: NotificationService, 
    private userAuth: UserAuthService,
    private currService:CurrencyService,
    private productService:ProductService,
    private router:Router
    ) 
    {
      currService.currSubject.subscribe((curr)=>{
        this.currency = curr;
      });

      userAuth.userData.subscribe((userData)=>{
        const user = userData;
        if(user.profile_image=='' || user.profile_image==undefined){
          this.profileImg = this.noImg
        }else{
          this.profileImg = environment.IMAGES_SERVER_URL+"/profile/"+user.profile_image;
        }
        this.username = user.username;
      });

      userAuth.isUserLoggedIn.subscribe((res)=>{
        if(res){
          const token = userAuth.getToken();
          if(token){
            const data = JSON.parse(token).user;
            this.username = data.username;
            this.isLoggin = true;
          }else{
            this.username = '';
            this.isLoggin = false;
          }
        }else{
          this.username = '';
          this.isLoggin = false;
        }
      })
    }
  ngOnDestroy() {
    document.removeEventListener('click', this.listenCartPopup);
  }

  ngOnInit(): void {

    this.cartService.cartItemSubject.subscribe(data => {
      this.cartItems = data.cartItems;
      this.subTotal = data.subTotal;
    });

    this.getCategory();
    this.isLoggin = this.userAuth.isLoggedIn();
    if (this.isLoggin) {
      const user = JSON.parse(this.userAuth.getToken()).user;
      this.username = user.username;
      if(user.profile_image!=''){
        this.profileImg = environment.IMAGES_SERVER_URL+"/profile/"+user.profile_image;
      }
    } else {
      this.cartItems = null;
    }

    document.addEventListener('click', this.listenCartPopup);
  }

  currencyChange(event:Event, val:string){
    const anchor  = <HTMLElement>event.target;
    const anchors = document.querySelectorAll(".dropdown-content.currency a");
    anchors.forEach((anchor)=>{
      anchor.classList.remove("active");
    });
    anchor.classList.add("active");
    if(val==='' || val==='inr'){
      this.currService.changeCurrency('inr');
    }else if(val==='usd'){
      this.currService.changeCurrency('usd');
    }else if(val==='eur'){
      this.currService.changeCurrency('eur');
    }
  }

  userLogout() {
    this.userAuth.logout();
    this.isLoggin = false;
  }

  getCategory() {
    this.catService.getCategory().subscribe((res) => {
      this.categories = res["result"];
    },
      (err) => {
        this.toast.showError("Error: "+err);
      });
  }

  getSubCategory(id: number) {
    this.catService.getSubCategoryByCatId(id).subscribe((res) => {
      this.subcategories = res["result"];
    },
      (err) => {
        this.toast.showError("Error: "+err);
      });
  }

  getCartItems() {
    const data = JSON.parse(this.userAuth.getToken());
    if(!this.toggleCart){
      if(data!=null){
        this.cartService.getCartItems(data.user.id).subscribe((res) => {
          this.cartItems = res["result"];        
          this.subTotal = this.cartService.getSubTotal();
          if (this.cartItems == '') {
            this.cartItems = null;
            this.subTotal = 0;
          }
          this.toggleCart = !this.toggleCart;
        }, (err) => {
          this.toast.showError("Error: "+err);
        });
      }else{
        $("#Login-popup").modal("show");
      }
    }else{
      this.toggleCart = false;
    }
  }

  removeItemFromCart(cartId: any) {
    this.cartService.removeItemFromCart(cartId).subscribe((res) => {
      if (res.error == '') {
        this.toast.showSuccess("Item Removed Successfully!!!");
        this.getCartItems();
      }else{
        this.toast.showError(res.error);
      }
    }, (err) => {
      this.toast.showError("Error: "+err);
    });
  }

  searchGlobal(search:HTMLInputElement){
    this.router.navigate(['search']);
    this.productService.search.next(search.value);
  }

  listenCartPopup = (e:any)=>{
    if(this.toggleCart){
      this.toggleCart = false;
    }
  }
}
