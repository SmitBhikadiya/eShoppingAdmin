<?php
    session_start();
    require_once("addressHandler.php");
    require_once("adminuserHandler.php");

    $address = new AddressHandler();
    $adminuser = new AdminUser();
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
    /*------------- Add Sub Category -------------*/
    /*------------- Update Category -------------*/
    /*------------- Update Sub Category -------------*/
    /*------------- Delete Category -------------*/
    /*------------- Delete Sub Category -------------*/

    /*####################### END ######################*/
    

    /*############# Request: CITY, STATE, COUNTRY #############*/

    /*------------- Add City -------------*/
    if (isset($_POST["AddCity"])) {
        $countryid = $_POST["country"];
        $stateid = $_POST["state"];
        $city = strtolower(trim($_POST["city"]));
        $error = $address->addCity($countryid, $stateid, $city);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"New City Added Successfully", "error"=>false];
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
            $_SESSION["result"] =["msg"=>"New State Added Successfully", "error"=>false];
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
            $_SESSION["result"] =["msg"=>"New Country Added Successfully", "error"=>false];
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
            $_SESSION["result"] =["msg"=>"City Updated Successfully", "error"=>false];
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
            $_SESSION["result"] =["msg"=>"State Updated Successfully", "error"=>false];
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
            $_SESSION["result"] =["msg"=>"Country Updated Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../countries.php");
    }

    /*------------- Delete City -------------*/
    if(isset($_GET["dCity"])){
        $id = (int) $_GET["dCity"];
        if($address->deleteCity($id)){
            $_SESSION["result"] =["msg"=>"City Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../cities.php");
    }

    /*------------- Delete State -------------*/
    if(isset($_GET["dState"])){
        $id = (int) $_GET["dState"];
        if($address->deleteState($id)){
            $_SESSION["result"] =["msg"=>"State Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../states.php");
    }

    /*------------- Delete Country -------------*/
    if(isset($_GET["dCountry"])){
        $id = (int) $_GET["dCountry"];
        if($address->deleteCountry($id)){
            $_SESSION["result"] =["msg"=>"Country Deleted Successfully", "error"=>false];
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


