import { Injectable } from '@angular/core';
import { ToastrService } from 'ngx-toastr';

@Injectable({
  providedIn: 'root'
})
export class NotificationService {

  constructor(private toast:ToastrService) { }

  showSuccess(msg:string, title:string=''){
    this.toast.success(msg, title, { timeOut:3000, closeButton:true, positionClass: 'toast-top-center'  });
  }

  showError(msg:string, title:string=''){
    this.toast.error(msg, title, { timeOut:2000, closeButton:true, positionClass: 'toast-top-center' });
  }
}
