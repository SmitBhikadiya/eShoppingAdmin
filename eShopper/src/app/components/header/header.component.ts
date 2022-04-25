import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { ICategory } from 'src/app/interfaces/category';
import { ISubCategory } from 'src/app/interfaces/subcategory';
import { CategoryService } from 'src/app/services/category.service';
import { UserAuthService } from 'src/app/services/user-auth.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {
  
  categories!:ICategory[];
  subcategories!:ISubCategory[];
  error!:string;
  username:string | null = '';
  isLoggin:boolean = false;

  constructor(private catService:CategoryService, private userAuth:UserAuthService) { 
    this.isLoggin = userAuth.isLoggedIn();
  }

  ngOnInit(): void {
    this.getCategory();
    this.username = this.userAuth.getToken();
  }

  userLogout(){
    this.userAuth.deleteToken();
  }

  getCategory(){
    this.catService.getCategory().subscribe((res)=>{
      this.categories = res["result"];
    },
    (err)=>{
      this.error = err;
    });
  }

  getSubCategory(id:number){
    this.catService.getSubCategoryByCatId(id).subscribe((res)=>{
      this.subcategories = res["result"];
    },
    (err)=>{
      this.error = err;
    });
  }
}
