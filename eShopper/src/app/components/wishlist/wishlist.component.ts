import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { UserAuthService } from 'src/app/services/user-auth.service';

@Component({
  selector: 'app-wishlist',
  templateUrl: './wishlist.component.html',
  styleUrls: ['./wishlist.component.css']
})
export class WishlistComponent implements OnInit {

  constructor(
    private userAuth:UserAuthService,
    private router:Router
  ) {
    userAuth.isUserLoggedIn.subscribe((res)=>{
      if(res===false){
        router.navigate(['/']);
      }
    });
  }

  ngOnInit(): void {
  }

}
