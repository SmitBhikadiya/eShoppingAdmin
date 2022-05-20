import { CurrencyPipe } from '@angular/common';
import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'setCurr'
})
export class SetCurrPipe implements PipeTransform {

  constructor(
    private currPipe:CurrencyPipe
  ){}

  transform(value: string, curr: string): unknown {
    curr = curr.toUpperCase();
    let val = Number(value);
    if(curr==='USD'){
      return this.currPipe.transform(val/77, 'USD');
    }else if(curr==='EUR'){
      return this.currPipe.transform(val/81, 'EUR');
    }else{
      return this.currPipe.transform(val, 'INR');
    }
  }

}
