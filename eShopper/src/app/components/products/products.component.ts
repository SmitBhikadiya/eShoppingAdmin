import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup } from '@angular/forms';
import { ActivatedRoute, NavigationEnd, Router } from '@angular/router';
import { IColor } from 'src/app/interfaces/color';
import { IProduct } from 'src/app/interfaces/prodduct';
import { ISize } from 'src/app/interfaces/size';
import { ISubCategory } from 'src/app/interfaces/subcategory';
import { CategoryService } from 'src/app/services/category.service';
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
  defaultLoadProduct:number = environment.DEFAULT_LOAD_PRODUCT;

  imageURL:string = environment.IMAGES_SERVER_URL;

  constructor(private builder:FormBuilder ,private productService:ProductService, private categoryService:CategoryService, private router:Router,private route:ActivatedRoute) {
    this.router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) {
        this.ngOnInit();
      }
    });
  }

  ngOnInit(): void {
    
    this.filterForm = this.builder.group({
      subcategories: this.builder.array([]),
      colors: [""],
      priceStart: ["0"],
      priceEnd: ["12000"],
      sizes: this.builder.array([])
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

  onCheckboxChange(e:any, controlname:string){
    const checkArray: FormArray = this.filterForm.get(controlname) as FormArray;
    if(e.target.checked){
      checkArray.push(new FormControl(e.target.value));
    }else{
      let i:number = 0;
      checkArray.controls.forEach((item:any)=>{
        if(item.value == e.target.value){
          checkArray.removeAt(i);
        }
        i++;
      });
    }
  }

  filterUpdate(){
    this.getProductsBy();
  }

  resetForm(){
    this.filterForm.reset();
    this.ngOnInit();
  }

  getProductsBy() : void{

    let cat = this.category;
    let subcat:string = this.subcategory;
    let load:number = this.defaultLoadProduct;
    let formvalues = this.filterForm.value;

    console.log(formvalues);
    
    if(cat==null){
      this.productService.getProducts(load, formvalues).subscribe((res)=>{
        this.products = res["result"];
        console.log(this.products);
      }, (err)=>{
        this.error=err;
      });
    }else if(subcat==null){
      this.productService.getProductsByCatName(load, cat, formvalues).subscribe((res)=>{
        this.products = res["result"];
        console.log(this.products);
      }, (err)=>{
        this.error=err;
      });
    }else{
      this.productService.getProductsBySubCatName(load, cat, subcat, formvalues).subscribe((res)=>{
        this.products = res["result"];
        console.log(this.products);
      }, (err)=>{
        this.error=err;
      });
    }
  }

  getSubCategories(){
    this.categoryService.getSubCategoryByCatName(this.category).subscribe((res)=>{
      this.subcategories = res["result"];
      //console.log(res);
    }, (err)=>{
      this.error = err;
    });
  }

  getColors(){
    this.productService.getColorsBy(this.category, this.subcategory).subscribe((res)=>{
      this.colors = res["result"];
      //console.log(this.colors);
    },(err)=>{
      this.error = err;      
    })
  }

  getSizes(){
    this.productService.getSizesBy(this.category, this.subcategory).subscribe((res)=>{
      this.sizes = res["result"];
      //console.log(this.colors);
    },(err)=>{
      this.error = err;      
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
