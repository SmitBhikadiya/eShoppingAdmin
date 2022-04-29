import { HttpResponse } from '@angular/common/http';
import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { NavigationEnd, Router } from '@angular/router';
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

  categories!: ICategory[];
  subcategories!: ISubCategory[];
  error!: string;
  username: any = '';
  isLoggin: boolean = false;

  constructor(private catService: CategoryService, private router: Router, private userAuth: UserAuthService) { }

  ngOnInit(): void {
    this.getCategory();
    this.isLoggin = this.userAuth.isLoggedIn();
    if(this.isLoggin){
      this.username = JSON.parse(this.userAuth.getToken()).user.username;
    }
  }

  userLogout() {
    this.userAuth.logout();
    this.isLoggin = false;
  }

  getCategory() {
    this.catService.getCategory().subscribe((res) => {
      this.categories = res["result"];
    },
      (err) => {
        this.error = err;
      });
  }

  getSubCategory(id: number) {
    this.catService.getSubCategoryByCatId(id).subscribe((res) => {
      this.subcategories = res["result"];
    },
      (err) => {
        this.error = err;
      });
  }
}
