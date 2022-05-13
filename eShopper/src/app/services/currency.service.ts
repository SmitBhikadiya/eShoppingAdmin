import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CurrencyService {

  currency = '';
  currSubject = new Subject<any>();
  constructor() { }

  changeCurrency(curr:string){
    this.currency = curr;
    this.currSubject.next(curr);
  }

  getCurrency(){
    return this.currency;
  }
}
