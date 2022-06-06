import { Component, OnInit, Renderer2 } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { IColor } from 'src/app/interfaces/color';
import { IProduct } from 'src/app/interfaces/product';
import { ISize } from 'src/app/interfaces/size';
import { ISubCategory } from 'src/app/interfaces/subcategory';
import { CategoryService } from 'src/app/services/category.service';
import { CurrencyService } from 'src/app/services/currency.service';
import { NotificationService } from 'src/app/services/notification.service';
import { ProductService } from 'src/app/services/product.service';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.css']
})
export class ProductsComponent implements OnInit {

  category!:any;
  subcategory!:any;
  products!:IProduct[];
  subcategories!:ISubCategory[];
  colors!:IColor[];
  sizes!:ISize[];
  error:string = '';
  filterForm!:FormGroup;
  selected:boolean = false;
  sortby:string = 'latest';
  f_subcatIds:number[] = [];
  f_sizeIds:number[] = [];
  currency = '';
  noImageURL = environment.IMAGES_SERVER_URL+"/noimage.jpg";
  defaultLoadProduct:number = environment.DEFAULT_LOAD_PRODUCT;

  imageURL:string = environment.IMAGES_SERVER_URL;

  constructor(
    private render:Renderer2,
    private builder:FormBuilder,
    private productService:ProductService, 
    private categoryService:CategoryService, 
    private router:Router,private route:ActivatedRoute,
    private toaster:NotificationService,
    private currService:CurrencyService) {
    this.router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.currency = currService.getCurrency();
        this.ngOnInit();
      }
    });

    currService.currSubject.subscribe((curr)=>{
      this.currency = curr;
    });
  }

  ngOnInit(): void {
    
    this.filterForm = this.builder.group({
      subcategories: [''],
      colors: [""],
      priceStart: ["0"],
      priceEnd: ["12000"],
      sizes: ['']
    });

    this.route.paramMap.subscribe((params)=>{
      this.category = params.get("category");
      this.subcategory = params.get("subcategory");
    });

    this.getProductsBy();
    this.getSubCategories();
    this.getColors();
    this.getSizes();

  }

  radioChange(e:any){
    let labels = document.querySelectorAll(".colour_family_list label");
    labels.forEach(label => {
      this.render.removeClass(label, 'active');
    });
    this.render.addClass(e.target.parentNode, 'active');
    this.getProductsBy();
  }

  priceChange(){
    this.getProductsBy();
  }

  onCheckboxChange(e:any, controlname:string){
    switch(controlname){
      case 'subcategories':
        if(e.target.checked){
          this.f_subcatIds.push(e.target.value);
        }else{
          let index = this.f_subcatIds.indexOf(e.target.value);
          this.f_subcatIds.splice(index,e.target.value);
        }
        this.filterForm.controls["subcategories"].setValue(this.f_subcatIds);
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
    this.getProductsBy();
  }

  sortProduct(sortby:string){
    this.sortby = sortby;
    this.getProductsBy();
  }

  resetFormControl(controlName:string){
    switch(controlName){
      case 'subcategories':
        this.uncheckedInput('subcatcheck');
        this.filterForm.controls["subcategories"].setValue([]);
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
    this.getProductsBy();
  }

  uncheckedInput(className:string){
    var inputs = document.querySelectorAll(`.${className}`);
    for (var i = 0; i < inputs.length; i++) {
        (inputs[i] as HTMLInputElement).checked = false;
    }
  }

  getProductsBy() : void{

    let cat = this.category;
    let subcat:string = this.subcategory;
    let load:number = this.defaultLoadProduct;
    let formvalues = this.filterForm.value;
    
    if(cat==null){
      this.productService.getProducts(load, formvalues, this.sortby).subscribe((res)=>{
        this.products = res["result"];
      }, (err)=>{
        this.toaster.showError(err.error.message,"ServerError");
      });
    }else if(subcat==null){
      this.productService.getProductsByCatName(load, cat, formvalues, this.sortby).subscribe((res)=>{
        this.products = res["result"];
      }, (err)=>{
        this.toaster.showError(err.error.message,"ServerError");
      });
    }else{
      this.productService.getProductsBySubCatName(load, cat, subcat, formvalues, this.sortby).subscribe((res)=>{
        this.products = res["result"];
      }, (err)=>{
        this.toaster.showError(err.error.message,"ServerError");
      });
    }
  }

  getSubCategories(){
    this.categoryService.getSubCategoryByCatName(this.category).subscribe((res)=>{
      this.subcategories = res["result"];
    }, (err)=>{
      this.toaster.showError(err.error.message,"ServerError");
    });
  }

  getColors(){
    this.productService.getColorsBy(this.category, this.subcategory).subscribe((res)=>{
      this.colors = res["result"];
    },(err)=>{
      this.toaster.showError(err.error.message,"ServerError");    
    })
  }

  getSizes(){
    this.productService.getSizesBy(this.category, this.subcategory).subscribe((res)=>{
      this.sizes = res["result"];
    },(err)=>{
      this.toaster.showError(err.error.message,"ServerError");    
    })
  }

  loadMoreProduct(load:number){
    this.defaultLoadProduct = load+2;
    this.getProductsBy();
  }

  trackByProduct(index:number, product:IProduct){
    return product.id;
  }
}
