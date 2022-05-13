import { Component } from '@angular/core';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})

export class AppComponent {
  
  strikeCheckout:any = null;

  constructor() { }

  ngOnInit() {
    this.stripePaymentGateway();
  }
  
  checkout(amount:any) {
    const strikeCheckout = (<any>window).StripeCheckout.configure({
      key: `${environment.STRIPE_PUBLIC_KEY}`,
      locale: 'auto',
      token: function (stripeToken: any) {
        console.log(stripeToken)
        alert('Stripe token generated!');
      }
    });
  
    strikeCheckout.open({
      name: 'eShopper',
      description: 'Stripe Payment',
      amount: amount * 100
    });
  }
  
  stripePaymentGateway() {
    if(!window.document.getElementById('stripe-script')) {
      const scr = window.document.createElement("script");
      scr.id = "stripe-script";
      scr.type = "text/javascript";
      scr.src = "https://checkout.stripe.com/checkout.js";

      scr.onload = () => {
        this.strikeCheckout = (<any>window).StripeCheckout.configure({
          key: `${environment.STRIPE_PUBLIC_KEY}`,
          locale: 'auto',
          token: function (token: any) {
            console.log(token)
            alert('Payment via stripe successfull!');
          }
        });
      }   
      window.document.body.appendChild(scr);
    }
  }

}