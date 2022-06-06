import { Component, OnInit } from '@angular/core';
import { UserAuthService } from 'src/app/services/user-auth.service';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.css']
})
export class FooterComponent implements OnInit {

  isLoggin = false;
  constructor(
    private userAuth:UserAuthService
  ) { 
    userAuth.isUserLoggedIn.subscribe((res)=>{
      this.isLoggin = res;
    });
  }

  ngOnInit(): void {
    this.isLoggin = this.userAuth.isLoggedIn();
  }

}
