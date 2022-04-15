import { Component, OnInit } from '@angular/core';
import { ICategory } from 'src/app/interfaces/category';
import { ISubCategory } from 'src/app/interfaces/subcategory';
import { CategoryService } from 'src/app/services/category.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  categories!:ICategory[];
  subcategories!:ISubCategory[];
  error!:string;

  constructor(private catService:CategoryService) { }

  ngOnInit(): void {
    this.getCategory();
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
