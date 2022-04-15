import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'imageURLFilter'
})
export class ImageURLFilterPipe implements PipeTransform {

  transform(value:string) : any{
    return value.split(",");
  }

}
