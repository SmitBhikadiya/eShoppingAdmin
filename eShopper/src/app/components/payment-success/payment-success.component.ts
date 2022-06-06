import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { CartService } from 'src/app/services/cart.service';
import { NotificationService } from 'src/app/services/notification.service';
import { OrdersService } from 'src/app/services/orders.service';
import { UserAuthService } from 'src/app/services/user-auth.service';

@Component({
  selector: 'app-payment-success',
  templateUrl: './payment-success.component.html',
  styleUrls: ['./payment-success.component.css']
})
export class PaymentSuccessComponent implements OnInit {

  userId!:any;
  couponId!:any;
  orderId!:any;
  isSuccess = false;

  constructor(
    private router:Router,
    private activatedRoute: ActivatedRoute,
    private orderService: OrdersService,
    private toaster:NotificationService,
    private userAuth:UserAuthService,
    private spinnerService:NgxSpinnerService,
    private cartService: CartService
  ) {

    userAuth.isUserLoggedIn.subscribe((res)=>{
      if(res===false){
        router.navigate(['/']);
      }
    });

    let data = this.userAuth.getToken();
    if(data!=null){
      data = JSON.parse(data);
      this.userId = data.user.id;
    }

    activatedRoute.params.subscribe((param)=>{
      if(param && this.userId && param["payment"]=='success'){
        spinnerService.show("payment");
        this.orderId = param["ordId"].split('_')[1];
        this.userId = param["userId"].split('_')[1];
        if(activatedRoute.snapshot.paramMap.has('couponId')){
          this.couponId = param["couponId"].split('_')[1];
        }
        this.checkOrderAvailablity();
        this.isSuccess = true;
      }else if(param && param["payment"]=='cancelled'){
        spinnerService.show("payment");
        this.orderId = param["ordId"].split('_')[1];
        this.removeOrderIfPaymentNotDone();
        this.isSuccess = false;
      }else{
        toaster.showWarning("Invalid Request!!!");
        router.navigate(['/']);
      }
    });

  }

  ngOnInit(): void {
  }

  checkOrderAvailablity(){
    this.orderService.getOrderById(this.orderId, this.userId).subscribe({
      next: (res) => {
        console.log(123,res, res.result.length===undefined, res.result.payment=='0');
        if(res.result.length===undefined && res.result.payment=='0'){
          this.updatePaymentStatus();
        }else{
          this.spinnerService.hide("payment");
        }
      },
      error: (err) => {
        this.toaster.showError(err.error.message,"ServerError");
        this.spinnerService.hide("payment");
      }
    });
  }

  removeOrderIfPaymentNotDone(){
    this.orderService.removeOrderIfPaymentNotDone(this.orderId, this.userId, 0).subscribe({
      next: (res) => {
        if(res.error == ''){
          this.toaster.showWarning("Order Payment Cancelled!!!");
        }else{
          this.toaster.showError(res.error);
        }
        this.spinnerService.hide("payment");
      },
      error: (err) => {
        this.toaster.showError(err.error.message,"ServerError");
        this.spinnerService.hide("payment");
      }
    });
  }

  updatePaymentStatus(){
    this.orderService.setPaymentDone(this.orderId, this.userId, this.couponId).subscribe({
      next: (res) => {
        if(res.error == ''){
          this.toaster.showSuccess("Payment Done Successfully!!!");
          this.clearCart();
        }else{
          this.spinnerService.hide("payment");
        }
      },
      error: (err) => {
        this.spinnerService.hide("payment");
        this.toaster.showError(err.error.message,"ServerError");
      }
    });
  }

  clearCart() {
    this.cartService.removeAllItemFromCart(this.userId).subscribe({
      next: (res) => {
        if (res.error != '') {
          this.toaster.showError(res.error);
        }
        this.spinnerService.hide("payment");
      },
      error: (err) => {
        this.toaster.showError(err.error.message,"ServerError");
        this.spinnerService.hide("payment");
      }
    });
  }

}
