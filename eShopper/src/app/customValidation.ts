declare let $: any;

export class CustomValidation {
  isFieldChecked(id: string) {
    let is = $(id).is(":checked");
    if (!is) {
      $(id).parent().after("<span class='spanError'>*Privacy and policy must be selected!!</span>");
    }
  }

  isNumberValid(id: string, reg: RegExp, range: string) {
    let value = $(id).val();
    if (value.length == 0) {
      $(id).after("<span class='spanError'>*Field can't be empty!!</span>");
    } else if (!reg.test(value)) {
      $(id).after("<span class='spanError'>*Mobile must be " + range + " charcters long</span>");
    }
  }

  isTypeNumberFieldValid(id: string, min:number, max:number, fieldName:string){
    let num = $(id).val();
    if(num < min && num > max){
      $(id).after(`<span class='spanError'>*${fieldName} must have range between ${min} to ${max} </span>`);
    }
  }

  isFieldEmpty(id: string) {
    let value = $(id).val();
    if (value.length == 0) {
      $(id).after("<span class='spanError'>*Field can't be empty!!</span>");
    }
  }

  isPasswordValid(id: string) {
    var reg = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/;
    let value = $(id).val();
    if (value.length == 0) {
      $(id).after("<span class='spanError'>*Field can't be empty!!</span>");
    } else if (!reg.test(value)) {
      $(id).after("<span class='spanError'>*At least one uppercase, lowercase, special char, numbers and 6 to 14 characters longer</span>");
    }
  }

  isRadioSelected(id: string, name: string, msg='') {
    var gender = document.querySelectorAll("input[name=" + name + "]:checked");
    if (!gender.length) {
      if(msg==''){
        msg = 'Please select a gender!!!';
      }
      $(id).after(`<span class='spanError'>*${msg}!!</span>`);
    }
  }

  isFieldSelected(id:string, fieldName:string){
    var value = $(id).val();
    if(value==0 || value==undefined || value==''){
      $(id).after("<span class='spanError'>*"+fieldName+" must be selected!!</span>");
    }
  }

  isEmailValid(id: string) {
    var reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    let value = $(id).val();
    if (value.length == 0) {
      $(id).after("<span class='spanError'>*Field can't be empty!!</span>");
    } else if (!reg.test(value)) {
      $(id).after("<span class='spanError'>*Enter a valid email!!</span>");
    }
  }
}