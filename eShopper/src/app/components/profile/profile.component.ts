import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { CustomValidation } from 'src/app/customValidation';
import { ICity } from 'src/app/interfaces/city';
import { ICountry } from 'src/app/interfaces/country';
import { IState } from 'src/app/interfaces/state';
import { IUser } from 'src/app/interfaces/user';
import { AddressService } from 'src/app/services/address.service';
import { UserAuthService } from 'src/app/services/user-auth.service';
declare let $: any;

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {

  billing!: any;
  shipping!: any;
  tempShipping!: any;
  shipDisabled = false;
  loaded!: Promise<Boolean>;
  message: { msg: string, isError: boolean, color: string, image: string } = { msg: '', isError: false, color: 'success', image: 'success.svg' };
  user!: IUser;
  bcities!: ICity[];
  scities!: ICity[];
  bstates!: IState[];
  sstates!: IState[];
  countries!: ICountry[];
  profileForm!: FormGroup;
  validator = new CustomValidation();
  constructor(
    private userAuth: UserAuthService,
    private router:Router, 
    private builder: FormBuilder, 
    private addressService: AddressService
  ) {
    userAuth.isUserLoggedIn.subscribe((res)=>{
      if(res===false){
        router.navigate(['/']);
      }
    });
  }

  ngOnInit(): void {
    this.profileForm = this.builder.group({
      id: [''],
      username: [''],
      email: [''],
      gender: [''],
      firstname: [''],
      lastname: [''],
      mobile: [''],
      phone: [''],
      shipping: this.builder.group({
        streetname: [''],
        country: [0],
        state: [0],
        city: [0]
      }),
      billing: this.builder.group({
        streetname: [''],
        country: [0],
        state: [0],
        city: [0]
      })
    });
    this.getUserDetailes();
    this.getCountries();
  }

  profileUpdate() {
    if (this.isProfileFormValidate()) {
      let formData = new FormData();
      formData.append("id", this.profileForm.controls["id"].value);
      formData.append("username", this.profileForm.controls["username"].value);
      formData.append("email", this.profileForm.controls["email"].value);
      formData.append("firstname", this.profileForm.controls["firstname"].value);
      formData.append("lastname", this.profileForm.controls["lastname"].value);
      formData.append("mobile", this.profileForm.controls["mobile"].value);
      formData.append("gender", this.profileForm.controls["gender"].value);
      formData.append("phone", this.profileForm.controls["phone"].value);
      formData.append("bstreetname", this.profileForm.get(["billing", "streetname"])?.value);
      formData.append("bcountry", this.profileForm.get(["billing", "country"])?.value);
      formData.append("bstate", this.profileForm.get(["billing", "state"])?.value);
      formData.append("bcity", this.profileForm.get(["billing", "city"])?.value);
      formData.append("sstreetname", this.profileForm.get(["shipping", "streetname"])?.value);
      formData.append("scountry", this.profileForm.get(["shipping", "country"])?.value);
      formData.append("sstate", this.profileForm.get(["shipping", "state"])?.value);
      formData.append("scity", this.profileForm.get(["shipping", "city"])?.value);
      this.userAuth.updateProfile(formData).subscribe((res) => {
        if (res["error"] == '') {
          this.message.msg = "Profile Updated Successfully";
          this.message.isError = false;
          this.message.color = 'success';
          this.message.image = 'success.svg';
          this.updateUserToken(res["result"]);
        } else {
          this.message.msg = res["error"];
          this.message.isError = true;
          this.message.color = 'danger';
          this.message.image = 'error.svg';
        }
        setTimeout(() => {
          this.message.msg = '';
        }, 5000)
      });
    }
  }

  updateUserToken(userdetailes:any){
    let token = JSON.parse(this.userAuth.getToken());
    let userToken = token.user;
    let user = userdetailes["user"];
    userToken.username = user["username"];
    userToken.gender = user["gender"];
    userToken.email = user["email"];
    userToken.firstname = user["firstname"];
    userToken.lastname = user["lastname"];
    userToken.mobile = user["mobile"];
    userToken.phone = user["phone"];
    token.user = userToken;
    this.userAuth.setToken(JSON.stringify(token));
  }

  sameasbilling(e: any) {
    if (this.checkBillingFormValidate()) {
      this.shipDisabled = !this.shipDisabled;
      if (e.target.checked) {
        this.getAndSetShippingAsBilling();
      }
    }
  }

  checksameasbilling() {
    $("#sameasbilling").prop("checked", false);
  }

  getAndSetShippingAsBilling() {
    this.scities = this.bcities;
    this.sstates = this.bstates;
    let street = this.profileForm.get(["billing", "streetname"])?.value;
    let country = this.profileForm.get(["billing", "country"])?.value;
    let state = this.profileForm.get(["billing", "state"])?.value;
    let city = this.profileForm.get(["billing", "city"])?.value;
    this.profileForm.get(["shipping", "streetname"])?.setValue(street);
    this.profileForm.get(["shipping", "country"])?.setValue(country);
    this.profileForm.get(["shipping", "state"])?.setValue(state);
    this.profileForm.get(["shipping", "city"])?.setValue(city);
  }

  getUserDetailes() {
    const token = JSON.parse(this.userAuth.getToken());
    this.userAuth.getUserDetailesByUsername(token.user.username).subscribe((res) => {
      console.log(res["result"]);
      this.user = res["result"].user;
      this.billing = res["result"].billing;
      this.shipping = res["result"].shipping;
      this.setDefaultResponce();
      this.loaded = Promise.resolve(true);
    });
  }

  setDefaultResponce() {
    this.profileForm.controls["id"].setValue(this.user.id);
    this.profileForm.controls["username"].setValue(this.user.username);
    this.profileForm.controls["email"].setValue(this.user.email);
    this.profileForm.controls["gender"].setValue(this.user.gender);
    this.profileForm.controls["firstname"].setValue(this.user.firstname);
    this.profileForm.controls["lastname"].setValue(this.user.lastname);
    this.profileForm.controls["phone"].setValue(this.user.phone);
    this.profileForm.controls["mobile"].setValue(this.user.mobile);
    if (Object.entries(this.billing).length != 0) {
      this.getStatesByCountryId(this.billing.countryId, 0);
      this.getCitiesByStateId(this.billing.stateId, 0);
      this.profileForm.get(['billing', 'streetname'])?.setValue(this.billing.streetname);
      this.profileForm.get(['billing', 'country'])?.setValue(this.billing.countryId);
      this.profileForm.get(['billing', 'state'])?.setValue(this.billing.stateId);
      this.profileForm.get(['billing', 'city'])?.setValue(this.billing.cityId);
    }
    if (Object.entries(this.shipping).length != 0) {
      this.getStatesByCountryId(this.shipping.countryId, 1);
      this.getCitiesByStateId(this.shipping.stateId, 1);
      this.profileForm.get(['shipping', 'streetname'])?.setValue(this.shipping.streetname);
      this.profileForm.get(['shipping', 'country'])?.setValue(this.shipping.countryId);
      this.profileForm.get(['shipping', 'state'])?.setValue(this.shipping.stateId);
      this.profileForm.get(['shipping', 'city'])?.setValue(this.shipping.cityId);
    }
  }

  getCountries() {
    this.addressService.getCountry().subscribe((res) => {
      this.countries = res["result"];
    });
  }

  countryChange(e: any, type: number) {
    this.getStatesByCountryId(e.target.value, type);
    if (type == 0) {
      this.profileForm.get(['billing', 'state'])?.setValue(0);
      this.profileForm.get(['billing', 'city'])?.setValue(0);
    } else if (type == 1) {
      this.profileForm.get(['shipping', 'state'])?.setValue(0);
      this.profileForm.get(['shipping', 'city'])?.setValue(0);
    }
  }

  stateChange(e: any, type: number) {
    this.getCitiesByStateId(e.target.value, type);
  }

  getStatesByCountryId(id: number, type: number) {
    this.addressService.getStatesByCountryId(id).subscribe((res) => {
      if (type == 0) {
        this.bstates = res["result"];
        this.bcities = [];
      } else {
        this.sstates = res["result"];
        this.scities = [];
      }
      console.log(res["result"]);
    });
  }

  getCitiesByStateId(id: number, type: number) {
    this.addressService.getCitiesByStateId(id).subscribe((res) => {
      if (type == 0) {
        this.bcities = res["result"];
      } else {
        this.scities = res["result"];
      }
      console.log(res["result"]);
    });
  }

  checkBillingFormValidate() {
    $(".billing-address-block .spanError").remove();
    this.validator.isFieldEmpty("#bstreetname");
    this.validator.isFieldSelected("#bcountry", "country");
    this.validator.isFieldSelected("#bstate", "state");
    this.validator.isFieldSelected("#bcity", "city");
    if ($(".billing-address-block").find('.spanError').length == 0) {
      return true;
    } else {
      return false;
    }
  }

  checkShippingFormValidate() {
    $(".shipping-address-block .spanError").remove();
    this.validator.isFieldEmpty("#sstreetname");
    this.validator.isFieldSelected("#scountry", "country");
    this.validator.isFieldSelected("#sstate", "state");
    this.validator.isFieldSelected("#scity", "city");
    if ($(".shipping-address-block").find('.spanError').length == 0) {
      return true;
    } else {
      return false;
    }
  }

  isProfileFormValidate() {
    let isValid = true;
    $(".profileDiv .spanError").remove();
    this.message.msg = '';
    isValid = this.checkBillingFormValidate();
    isValid = this.checkShippingFormValidate();
    this.validator.isFieldEmpty("#username");
    this.validator.isRadioSelected("#gender", "gender");
    this.validator.isEmailValid("#email");
    this.validator.isFieldEmpty('#firstname');
    this.validator.isFieldEmpty('#lastname');
    this.validator.isNumberValid("#mobile", /^[\d]{10,12}$/, '10-12')
    this.validator.isNumberValid("#phone", /^[\d]{6,8}$/, '6-8')
    if ($("#profileform").find(".spanError").length != 0) {
      isValid = false;
    }
    return isValid;
  }

}
