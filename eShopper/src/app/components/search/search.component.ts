import { Component, OnInit, Renderer2 } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { NavigationEnd, Router } from '@angular/router';
import { ICategory } from 'src/app/interfaces/category';
import { IColor } from 'src/app/interfaces/color';
import { IProduct } from 'src/app/interfaces/product';
import { ISize } from 'src/app/interfaces/size';
import { ISubCategory } from 'src/app/interfaces/subcategory';
import { CategoryService } from 'src/app/services/category.service';
import { CurrencyService } from 'src/app/services/currency.service';
import { ProductService } from 'src/app/services/product.service';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit {

  category = '';
  subcategory!:any;
  products!:IProduct[];
  categories!:ICategory[];
  colors!:IColor[];
  sizes!:ISize[];
  search = '';
  error:string = '';
  filterForm!:FormGroup;
  selected:boolean = false;
  sortby:string = 'latest';
  f_catIds:number[] = [];
  f_sizeIds:number[] = [];
  currency = '';
  noImageURL = environment.IMAGES_SERVER_URL+"/noimage.jpg";
  defaultLoadProduct:number = environment.DEFAULT_LOAD_PRODUCT;
  imageURL:string = environment.IMAGES_SERVER_URL;

  constructor(
    private router:Router,
    private render:Renderer2,
    private builder:FormBuilder,
    private productService: ProductService,
    private categoryService:CategoryService,
    private currService: CurrencyService
  ) {
    
    this.router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.currency = currService.getCurrency();
        this.ngOnInit();
      }
    });
    
    productService.search.subscribe((res)=>{
      this.search = res;
      this.getProductsBySearch();
    });
    currService.currSubject.subscribe((curr)=>{
      this.currency = curr;
    });
  }

  ngOnInit(): void {

    console.log("Intial Method Called Of Search Component");
    
    this.filterForm = this.builder.group({
      categories: [''],
      colors: [""],
      priceStart: ["0"],
      priceEnd: ["12000"],
      sizes: ['']
    });

    this.getColors();
    this.getSizes();
    this.getCategories();
    this.getProductsBySearch();
  }

  getProductsBySearch(){
    const formvalues = this.filterForm.value;
    const load = this.defaultLoadProduct;
    const search = this.search; 
    this.productService.getProductsBySearch(load, formvalues, this.sortby, search).subscribe((res)=>{
      this.products = res["result"];
    }, (err)=>{
      this.error=err;
    });
  }

  getColors(){
    this.productService.getColorsByCat(this.category).subscribe((res)=>{
      this.colors = res["result"];
      console.log('colors',  this.colors);
    },(err)=>{
      this.error = err;      
    });
  }

  getCategories(){
    this.categoryService.getCategory().subscribe((res)=>{
      this.categories = res["result"];
    },(err)=>{
      this.error = err;      
    });
  }

  getSizes(){
    this.productService.getSizesByCat(this.category).subscribe((res)=>{
      this.sizes = res["result"];
    },(err)=>{
      this.error = err;      
    });
  }

  loadMoreProduct(load:number){
    this.defaultLoadProduct = load+2;
    this.getProductsBySearch();
  }

  trackByProduct(index:number, product:IProduct){
    return product.id;
  }

  sortProduct(sortby:string){
    this.sortby = sortby;
    this.getProductsBySearch();
  }

  priceChange(){
    this.getProductsBySearch();
  }

  radioChange(e:any){
    let labels = document.querySelectorAll(".colour_family_list label");
    labels.forEach(label => {
      this.render.removeClass(label, 'active');
    });
    this.render.addClass(e.target.parentNode, 'active');
    this.getProductsBySearch();
  }

  resetFormControl(controlName:string){
    switch(controlName){
      case 'categories':
        this.uncheckedInput('catcheck');
        this.filterForm.controls["categories"].setValue([]);
        break;
      case 'colors':
        let labels = document.querySelectorAll(".colour_family_list label");
        labels.forEach(label => {
          this.render.removeClass(label, 'active');
        });
        this.filterForm.controls["colors"].setValue("");
        break;
      case 'sizes':
        this.uncheckedInput('sizecheck');
        this.filterForm.controls["sizes"].patchValue([]);
        break;
    }
    this.getProductsBySearch();
  }

  uncheckedInput(className:string){
    var inputs = document.querySelectorAll(`.${className}`);
    for (var i = 0; i < inputs.length; i++) {
        (inputs[i] as HTMLInputElement).checked = false;
    }
  }

  onCheckboxChange(e:any, controlname:string){
    switch(controlname){
      case 'categories':
        if(e.target.checked){
          this.f_catIds.push(e.target.value);
        }else{
          let index = this.f_catIds.indexOf(e.target.value);
          this.f_catIds.splice(index,e.target.value);
        }
        this.filterForm.controls["categories"].setValue(this.f_catIds);
        break;
      case 'sizes':
        if(e.target.checked){
          this.f_sizeIds.push(e.target.value);
        }else{
          let index = this.f_sizeIds.indexOf(e.target.value);
          this.f_sizeIds.splice(index,e.target.value);
        }
        this.filterForm.controls["sizes"].setValue(this.f_sizeIds);
        break;
    }
    this.getProductsBySearch();
  }

}
