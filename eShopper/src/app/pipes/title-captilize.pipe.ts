import { Pipe, PipeTransform } from '@angular/core';
import { first } from 'rxjs';

@Pipe({
  name: 'titleCaptilize'
})
export class TitleCaptilizePipe implements PipeTransform {

  transform(value: string): unknown {
    let first = value.substring(0,1).toUpperCase();
    return first+value.substring(1);
  }

}
