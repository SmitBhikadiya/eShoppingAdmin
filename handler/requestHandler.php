<?php
    session_start();
    require_once("addressHandler.php");
    require_once("adminuserHandler.php");
    require_once("categoryHandler.php");

    $address = new AddressHandler();
    $adminuser = new AdminUser();
    $category = new CategoryHandler();
    $error = '';
    $success = '';


    /*############# Request: ADMIN SIGNIN ############*/

    /*------------- Admin User Signin -------------*/
    if (isset($_POST["signin"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $error = $adminuser->signIn($email, $password);
        if ($error=='') {
            header("Location: ../index.php");
        }else{
            $_SESSION["error"] = $error;
            header("Location: ../signin.php");
        }
    }

    /*############# Request: CATEGORY, SUB CATEGORY #############*/

    /*------------- Add Category -------------*/
    if (isset($_POST["AddCategory"])) {
        $catname = strtolower(trim($_POST["catname"]));
        $catdesc = strtolower(trim($_POST["catdesc"]));
        $error = $category->addCategory($catname, $catdesc);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"New Category '$catname' Added Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../add_category.php");
    }
    /*------------- Add Sub Category -------------*/
    if (isset($_POST["AddSubCategory"])) {
        $catid = $_POST["category"];
        $catname = strtolower(trim($_POST["subcatname"]));
        $catdesc = strtolower(trim($_POST["subcatdesc"]));
        $error = $category->addSubCategory($catname, $catdesc, $catid);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"New Sub Category '$catname' Added Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../add_sub_category.php");
    }

    /*------------- Update Category -------------*/
    if(isset($_POST["EditCategory"])){
        $catid = $_POST["categoryid"];
        $catname = strtolower(trim($_POST["catname"]));
        $catdesc = strtolower(trim($_POST["catdesc"]));
        $error = $category->updateCategory($catid, $catname, $catdesc);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"Category '$catname' Updated Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../category.php");  
    }

    /*------------- Update Sub Category -------------*/
    if(isset($_POST["EditSubCategory"])){
        $subcatid = $_POST["subcatid"];
        $catid = $_POST["category"];
        $catname = strtolower(trim($_POST["subcatname"]));
        $catdesc = strtolower(trim($_POST["subcatdesc"]));
        $error = $category->updateSubCategory($subcatid, $catname, $catdesc, $catid);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"Sub Category '$catname' Updated Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../sub_category.php");   
    }

    /*------------- Delete Category -------------*/
    if(isset($_GET["dCategory"])){
        $id = (int) $_GET["dCategory"];
        if($category->deleteCategory($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../category.php");
    }


    /*------------- Delete Sub Category -------------*/
    if(isset($_GET["dSubCategory"])){
        $id = (int) $_GET["dSubCategory"];
        if($category->deleteSubCategory($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../sub_category.php");
    }

    /*####################### END ######################*/
    

    /*############# Request: CITY, STATE, COUNTRY #############*/

    /*------------- Add City -------------*/
    if (isset($_POST["AddCity"])) {
        $countryid = $_POST["country"];
        $stateid = $_POST["state"];
        $city = strtolower(trim($_POST["city"]));
        $error = $address->addCity($countryid, $stateid, $city);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"'$city' city Added Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../add_city.php");
    }

    /*------------- Add State -------------*/
    if (isset($_POST["AddState"])) {
        $countryid = $_POST["country"];
        $state = strtolower(trim($_POST["state"]));
        $error = $address->addState($countryid, $state);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"'$state' state Added Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../add_state.php");
    }

    /*------------- Add Country -------------*/
    if (isset($_POST["AddCountry"])) {
        $country = strtolower(trim($_POST["country"]));
        $error = $address->addCountry($country);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"'$country' country Added Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../add_country.php");
    }

    /*------------- Update City -------------*/
    if(isset($_POST["EditCity"])){
        $countryid = $_POST["country"];
        $stateid = $_POST["state"];
        $cityid = $_POST["cityid"];
        $city = strtolower(trim($_POST["city"]));
        $error = $address->updateCity($countryid, $stateid, $cityid, $city);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"'$city' city Updated Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../cities.php");
    }

    /*------------- Update State -------------*/
    if(isset($_POST["EditState"])){
        $countryid = $_POST["country"];
        $stateid = $_POST["stateid"];
        $state = strtolower(trim($_POST["state"]));
        $error = $address->updateState($countryid, $stateid, $state);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"'$state' state Updated Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../states.php");
    }

    /*------------- Update Country -------------*/
    if(isset($_POST["EditCountry"])){
        $country = strtolower(trim($_POST["country"]));
        $countryid = $_POST["countryid"];
        $error = $address->updateCountry($countryid, $country);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"'$country' country Updated Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../countries.php");
    }

    /*------------- Delete City -------------*/
    if(isset($_GET["dCity"])){
        $id = (int) $_GET["dCity"];
        if($address->deleteCity($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../cities.php");
    }

    /*------------- Delete State -------------*/
    if(isset($_GET["dState"])){
        $id = (int) $_GET["dState"];
        if($address->deleteState($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../states.php");
    }

    /*------------- Delete Country -------------*/
    if(isset($_GET["dCountry"])){
        $id = (int) $_GET["dCountry"];
        if($address->deleteCountry($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }  
        header("Location: ../countries.php");
    }

    /*------------- Get State List By Country Id -------------*/
    if(isset($_POST["countryid"])){
        $records = $address->getStatesByCountryId($_POST["countryid"]);
        echo json_encode(["states"=>$records]);
    }

    /*##################### END #####################*/


