import { Component, OnInit } from '@angular/core';
import { NavigationEnd, Router } from '@angular/router';
import { CurrencyService } from 'src/app/services/currency.service';
import { OrdersService } from 'src/app/services/orders.service';
import { UserAuthService } from 'src/app/services/user-auth.service';

@Component({
  selector: 'app-orders',
  templateUrl: './orders.component.html',
  styleUrls: ['./orders.component.css']
})
export class OrdersComponent implements OnInit {

  userId!:any;
  orderData:any = [];
  currency = 'inr';
  filter = 'all';
  search = '';

  constructor(
    private userAuth:UserAuthService,
    private orderService:OrdersService,
    private currService:CurrencyService,
    private router: Router
  ) {

    router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.currency = currService.getCurrency();
      }
    });

    currService.currSubject.subscribe((curr) => {
      this.currency = curr;
    });

    userAuth.isUserLoggedIn.subscribe((res)=>{
      if(res===false){
        router.navigate(['/']);
      }
    });
  }

  ngOnInit(): void {
    const token = JSON.parse(this.userAuth.getToken());
    this.userId = token.user.id;
    this.getOrderDetailes();
  }

  filterBy(e:HTMLSelectElement){
    this.filter = e.value;
    this.getOrderDetailes();
  }

  searchBy(e:HTMLInputElement){
    this.search = e.value;
    this.getOrderDetailes(); 
  }

  getOrderDetailes(){
    this.orderService.getAllOrder(this.userId, this.filter, this.search).subscribe({
      next: (res) => {
        const result = res.result;
        if(result.length >= 0){
          this.orderData = result;
        } 
      },
      error: (err) => {
        console.log(err.error);
      }
    });
  }

}
