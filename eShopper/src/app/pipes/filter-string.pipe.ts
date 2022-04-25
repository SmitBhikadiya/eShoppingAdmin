import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'filterString'
})
export class FilterStringPipe implements PipeTransform {

  transform(value:any): any {
    return (value==undefined || value==null) ? '' : value;
  }

}
