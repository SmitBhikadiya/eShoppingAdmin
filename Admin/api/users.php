<?php

session_start();
require_once("../handler/customerHandler.php");
require_once("verifyToken.php");
$obj = new CustomerHandler();


if(isset($_POST["id"])){
    $userid = $_POST["id"];
    $username = trim($_POST["username"]);
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $gender = trim($_POST["gender"]);
    $mobile = trim($_POST["mobile"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $oldprofile = trim($_POST['oldprofile']);
    $image = '';

    if(isset($_FILES['newprofile']) && isset($_FILES['newprofile']['tmp_name'])){
        $targetDir = "../images/profile/";
        $files = $_FILES["newprofile"];
        $image = "profile_" . time() . rand(0, 1000) . '.png';
        $target = $targetDir . $image;
        $error = '';
        if (!move_uploaded_file($files["tmp_name"], $target)) {
            $error = "Error while file is uploading!!";
            $image = $oldprofile;
        }else{
            if($oldprofile!='' && $oldprofile!=null){
                if(is_file($targetDir.$oldprofile)){
                    unlink($targetDir.$oldprofile);
                }
            }
        }
    }else{
        $image = $oldprofile;
    }
    $error = '';
    $error = $obj->updateUser($userid, $username, $firstname, $lastname, $gender, $mobile, $phone, $email, $image);
    
    if(isset($_POST["bstreetname"]) && $_POST["bstreetname"]!=''){
        $type = 0;
        $street = $_POST["bstreetname"];
        $country = $_POST["bcountry"];
        $state = $_POST["bstate"];
        $city = $_POST["bcity"];
        $error = $obj->updateAddress($userid, $type, $street, $country, $state, $city);
    }
    if(isset($_POST["sstreetname"]) && $_POST["sstreetname"]!=''){
        $type = 1;
        $street = $_POST["sstreetname"];
        $country = $_POST["scountry"];
        $state = $_POST["sstate"];
        $city = $_POST["scity"];
        $error = $obj->updateAddress($userid, $type, $street, $country, $state, $city);
    }

    $userdetailes = ["user"=>[], "billing"=>[], "shipping"=>[]];
    if($error==''){
        $userdetailes = $obj->getUserDetailesByUsername($username);
    }
    echo json_encode(["result"=>$userdetailes, "error"=>$error]);
    exit();
}

if(isset($_GET["username"])){
    $res = $obj->getUserDetailesByUsername(trim(strtolower($_GET["username"])));
    echo json_encode(["result"=>$res]);
    exit();
}

if(isset($_GET["email"])){
    $res = $obj->getUserByEmail(trim(strtolower($_GET["email"])));
    echo json_encode(["result"=>$res]);
    exit();
}

if(isset($_POST["username"]) && isset($_POST["password"])){
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $gender = trim($_POST["gender"]);
    $mobile = trim($_POST["mobile"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $res = $obj->userRegister($username, $password, $firstname, $lastname, $gender, $mobile, $phone, $email, $image='');
    echo json_encode($res);
}else{
    echo json_encode("somthing went wrong");
}


?>