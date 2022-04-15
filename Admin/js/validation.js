$(document).ready(function(){

    $(".deleteRow").on("click", function(e){
        if(!confirm("Are you sure you want to Delete?")){
            e.preventDefault();
        }
    })

    $("#formSignin").on("submit", function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        validateEmail("#email");
        validatePassword("#password");
        if(!window.isValid){
            e.preventDefault();
        }
    });

    $("#formAddCategory").on("submit", function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        isFieldEmpty("#category")
        if(!window.isValid){
            e.preventDefault();
        }
    });

    $("#formAddSubCategory").on("submit", function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        isFieldEmpty("#subcategory");
        if(!window.isValid){
            e.preventDefault();
        }
    });

    $("#formAddNewProduct").on("submit", function(e){
        let action = $("#pimages").data("action");
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        isFieldEmpty("#pname");
        isFieldEmpty("#pprice");
        isFieldEmpty("#pqty");
        isOptionSelected("#categtory");
        isOptionSelected("#subcategtory");
        isMulOptionSelected("#productcolor");
        isMulOptionSelected("#productsize");
        isFieldEmpty("#pdesc");
        isImagesSelected("#pimages",['png', 'jpg', 'jpeg'], action)
        if(!window.isValid){
            e.preventDefault();
        }
    });

    $("#formAddProductColor").on("submit", function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        isFieldEmpty("#addcolor");
        if(!window.isValid){
            e.preventDefault();
        }
    });

    $("#formAddProductSize").on("submit", function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        isFieldEmpty("#addsize");
        if(!window.isValid){
            e.preventDefault();
        }
    });

    $("#formAddCity").on("submit", function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        isFieldEmpty("#cityname");
        isOptionSelected("#countrylist");
        isOptionSelected("#statelist");
        if(!window.isValid){
            e.preventDefault();
        }
    });

    $("#formAddState").on("submit", function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        isFieldEmpty("#statename");
        if(!window.isValid){
            e.preventDefault();
        }
    });

    $("#formAddCountry").on("submit", function(e){
        window.isValid = true;
        $('.error').remove();
        $('.alert').remove();
        isFieldEmpty("#countryname");
        if(!window.isValid){
            e.preventDefault();
        }
    });

    function isOptionSelected(id){
        var value = $(id).val();
        if(value==0 || value==undefined || value==null){
            $(id).after("<span class='error'>*Select at least one option!!</span>");
            window.isValid = false;
            return;
        }
    }

    function isFieldEmpty(id){
        var val = $(id).val();
        if(val.length < 1){
            $(id).after("<span class='error'>*Field can't be empty</span>");
            window.isValid = false;
            return;
        }
    }

    function isMulOptionSelected(id){
        if($(id).val().length===0){
            $(id).after("<span class='error'>*must select one or more color from list</span>");
            window.isValid = false;
            return;
        }
    }

    function isImagesSelected(id, format, action){
        files_ = $(id).get(0).files;
        if(files_.length===0 && action!="Edit"){
            $(id).after("<span class='error'>*Please select product image</span>");
            window.isValid = false;
            return;
        }
        for(i=0;i<files_.length;i++){
            if(format.indexOf(files_[i].type.split('/')[1]) === -1){
                $(id).after("<span class='error'>*Only png, jpeg and jpg format are allowed</span>");
                window.isValid = false;
                return;
            }
        }
    }

    function validatePassword(id){
        password = $(id).val();
        var reg = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z\d@$!%*#?&]{6,14}$/;
        if(password.length < 1){
            $(id).after("<span class='error'>*"+id.replace("#", "")+" can't be empty</span>");
            window.isValid = false;
            return;
        }else{
            if(!reg.test(password)){
                $(id).after("<span class='error'>*At least one uppercase, lowercase, special char, numbers and 6 to 14 characters longer</span>");
                window.isValid = false;
                return;
            }
        }
    }

    function validateEmail(id){
        email = $(id).val();
        var reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if(email.length < 1){
            $(id).after("<span class='error'>*Email field cant be empty</span>");
            window.isValid = false;
            return;
        }else if(!reg.test(email)){
            $(id).after("<span class='error'>*Enter a valid email</span>");
            window.isValid = false;
            return;
        }
    }
});