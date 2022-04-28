import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'strtoarray'
})
export class StrtoarrayPipe implements PipeTransform {

  transform(value:string, param:string) : any{
    if(value==''){
      return [''];
    }
    return value.split(param);
  }

}
