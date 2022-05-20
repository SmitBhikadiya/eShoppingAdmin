import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, NavigationEnd, Route, Router } from '@angular/router';
import { CurrencyService } from 'src/app/services/currency.service';
import { OrdersService } from 'src/app/services/orders.service';
import { UserAuthService } from 'src/app/services/user-auth.service';

declare let html2pdf:any;

@Component({
  selector: 'app-order-details',
  templateUrl: './order-details.component.html',
  styleUrls: ['./order-details.component.css']
})
export class OrderDetailsComponent implements OnInit {

  currency = 'inr';
  orderId!:any;
  userId!:any;
  orderData!:any;

  constructor(
    private userAuth:UserAuthService,
    private orderService:OrdersService,
    private currService:CurrencyService,
    private router: Router,
    private activatedRoute:ActivatedRoute,
  ) {

    router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.currency = currService.getCurrency();
      }
    });

    activatedRoute.params.subscribe((param)=>{
        this.orderId = param['ordId'];
    })

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
    this.getOrderDetailsBy();
  }

  getOrderDetailsBy(){
    if(this.orderId!=undefined){
      this.orderService.getOrderDetailsBy(this.orderId, this.userId).subscribe({
        next:(res) => {
          console.log(res);
          
          const data = res.result;
          if(data.orderListData.length>0){
            this.orderData = data;
          }else{
            this.router.navigate(['orders']);
          }
        },
        error: (err) => {
          console.log(err,err.error);
        }
      });
    }
  };

  downloadInvoice(){
    const invoice = <HTMLImageElement>document.getElementById("invoice");
    var opt = {
      margin: 1,
      filename: 'invoice.pdf',
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2 },
      jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
  };
  html2pdf().from(invoice).set(opt).save();  
  }

}
