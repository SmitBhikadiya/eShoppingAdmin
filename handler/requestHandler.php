<?php
    session_start();
    require_once("addressHandler.php");
    require_once("adminuserHandler.php");
    require_once("categoryHandler.php");
    require_once("productHandler.php");
    require_once("customerHandler.php");
    require_once("orderHandler.php");

    $addressH = new AddressHandler();
    $adminuserH = new AdminUser();
    $categoryH = new CategoryHandler();
    $productH = new ProductHandler();
    $customerH = new CustomerHandler();
    $orderH = new OrderHandler();
    $error = '';
    $success = '';


    /*************** Request: Admin ***************/
    if (isset($_POST["signin"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $error = $adminuserH->signIn($email, $password);
        if ($error=='') {
            header("Location: ../index.php");
        }else{
            $_SESSION["error"] = $error;
            header("Location: ../signin.php");
        }
    }
    /********************* END **********************/

    /*************** Request: Admin ***************/
    if (isset($_POST["orderStatus"])){
        $status = (int) $_POST["status"];
        $id = (int) $_POST["ordid"];
        if(in_array($status, [1,2])){
            $orderH->updateStatus($status, $id);
            $msg = "Order ".(($status==1) ? "completed" : "cancelled")." successfully!!!";
            $_SESSION["result"] =["msg"=>$msg, "error"=>false];
            header("Location: ../completed_orders.php");
        }else{
            $_SESSION["result"] =["msg"=>"Invalid Request!!!", "error"=>true];
            header("Location: ../view_order.php");
        }
    }
    /******************** END ********************/

    /*************** Request: Customer ***************/
    if(isset($_GET["dCustomer"])){
        $id = (int) $_GET["dCustomer"];
        if($customerH->deleteCustomer($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../customers.php");
    }
    /********************** END **********************/


    /************ Request: Product,Color,Size *************/
    if(isset($_POST["AddProduct"])){
        $name = strtolower(trim($_POST["name"]));
        $desc = strtolower(trim($_POST["desc"]));
        $catid = $_POST["category"];
        $subcatid = $_POST["subcategory"];
        $price = $_POST["price"];
        $qty = $_POST["qty"];
        $colorids = $_POST["colors"];
        $sizeids = $_POST["sizes"];
        $files = $_FILES["file"];
        $images = []; 
        
        // upload files to local directory
        $targetDir = "../images/product/";
        for($i=0; $i<count($files["name"]); $i++){
            $imgname = "product_".time().rand(0,1000).'.png';
            $target = $targetDir.$imgname;
            if(move_uploaded_file($files["tmp_name"][$i], $target)){
                array_push($images, $imgname);
            }
        }

        $error = $productH->addProduct($name, $desc, $catid, $subcatid,$price, $qty, $colorids, $sizeids, $images);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"New Product '$name' Added Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }

        header("Location: ../products.php");
    }
    if(isset($_POST["AddColor"])){
        $color = strtolower(trim($_POST["color"]));
        $value = strtolower(trim($_POST["value"]));
        $error = $productH->addColor($color, $value);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"New Color '$color' Added Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../product_color.php");
    }
    if(isset($_POST["AddSize"])){
        $size = strtolower(trim($_POST["size"]));
        $error = $productH->addSize($size);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"New Size '$size' Added Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../product_size.php");
    }

    if(isset($_POST["EditProduct"])){
        $name = strtolower(trim($_POST["name"]));
        $desc = strtolower(trim($_POST["desc"]));
        $catid = $_POST["category"];
        $subcatid = $_POST["subcategory"];
        $price = $_POST["price"];
        $qty = $_POST["qty"];
        $colorids = $_POST["colors"];
        $sizeids = $_POST["sizes"];
        $files = $_FILES["file"];
        $oldfiles = $_POST["oldimages"];
        $prdid = $_POST["productid"];
        $images = [];
        $targetDir = "../images/product/";

        // remove oldimages if new images are selected
        if($files["name"][0] != ""){
            foreach(explode(",", $oldfiles) as $image){
                unlink($targetDir.$image);
            }
            // upload files to local directory
            for($i=0; $i<count($files["name"]); $i++){
                $imgname = "product_".time().rand(0,1000).'.png';
                $target = $targetDir.$imgname;
                if(move_uploaded_file($files["tmp_name"][$i], $target)){
                    array_push($images, $imgname);
                }
            }
        }else{
            $images = explode(",", $oldfiles);
        }

        $error = $productH->updateProduct($prdid, $name, $desc, $catid, $subcatid,$price, $qty, $colorids, $sizeids, $images);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"Product '$name' Updated Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }

        header("Location: ../products.php");

    }
    if(isset($_POST["EditColor"])){
        $colorid = (int) $_POST["colorid"];
        $color = strtolower(trim($_POST["color"]));
        $value = strtolower(trim($_POST["value"]));
        $error = $productH->updateColor($colorid, $color, $value);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"Updated Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../product_color.php");  
    }
    if(isset($_POST["EditSize"])){
        $sizeid = (int) $_POST["sizeid"];
        $size = strtolower(trim($_POST["size"]));
        $error = $productH->updateSize($sizeid, $size);
        if ($error == "") {
            $_SESSION["result"] =["msg"=>"Updated Successfully", "error"=>false];
        } else {
            $_SESSION["result"] = ["msg"=>$error, "error"=>true];
        }
        header("Location: ../product_size.php");  
    }

    if(isset($_GET["dProduct"])){
        $id = (int) $_GET["dProduct"];
        if($productH->deleteProduct($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../products.php");
    }
    if(isset($_GET["dColor"])){
        $id = (int) $_GET["dColor"];
        if($productH->deleteColor($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../product_color.php");
    }
    if(isset($_GET["dSize"])){
        $id = (int) $_GET["dSize"];
        if($productH->deleteSize($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../product_size.php");
    }

    /********* Request: CATEGORY, SUB CATEGORY **********/

    /*------------- Add Category -------------*/
    if (isset($_POST["AddCategory"])) {
        $catname = strtolower(trim($_POST["catname"]));
        $catdesc = strtolower(trim($_POST["catdesc"]));
        $error = $categoryH->addCategory($catname, $catdesc);
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
        $error = $categoryH->addSubCategory($catname, $catdesc, $catid);
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
        $error = $categoryH->updateCategory($catid, $catname, $catdesc);
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
        $error = $categoryH->updateSubCategory($subcatid, $catname, $catdesc, $catid);
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
        if($categoryH->deleteCategory($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../category.php");
    }


    /*------------- Delete Sub Category -------------*/
    if(isset($_GET["dSubCategory"])){
        $id = (int) $_GET["dSubCategory"];
        if($categoryH->deleteSubCategory($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../sub_category.php");
    }

    /*------------- Get Sub Category List By category Id -------------*/
    if(isset($_POST["categoryId"])){
        $records = $categoryH->getSubCategoryByCategoryId($_POST["categoryId"]);
        echo json_encode(["categories"=>$records]);
    }

    /********************* END **********************/
    

    /*********** Request: CITY, STATE, COUNTRY ***********/

    /*------------- Add City -------------*/
    if (isset($_POST["AddCity"])) {
        $countryid = $_POST["country"];
        $stateid = $_POST["state"];
        $city = strtolower(trim($_POST["city"]));
        $error = $addressH->addCity($countryid, $stateid, $city);
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
        $error = $addressH->addState($countryid, $state);
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
        $error = $addressH->addCountry($country);
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
        $error = $addressH->updateCity($countryid, $stateid, $cityid, $city);
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
        $error = $addressH->updateState($countryid, $stateid, $state);
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
        $error = $addressH->updateCountry($countryid, $country);
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
        if($addressH->deleteCity($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../cities.php");
    }

    /*------------- Delete State -------------*/
    if(isset($_GET["dState"])){
        $id = (int) $_GET["dState"];
        if($addressH->deleteState($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }
        header("Location: ../states.php");
    }

    /*------------- Delete Country -------------*/
    if(isset($_GET["dCountry"])){
        $id = (int) $_GET["dCountry"];
        if($addressH->deleteCountry($id)){
            $_SESSION["result"] =["msg"=>"Deleted Successfully", "error"=>false];
        }else{
            $_SESSION["result"] =["msg"=>"Somthing went wrong!!!", "error"=>true];
        }  
        header("Location: ../countries.php");
    }

    /*------------- Get State List By Country Id -------------*/
    if(isset($_POST["countryid"])){
        $records = $addressH->getStatesByCountryId($_POST["countryid"]);
        echo json_encode(["states"=>$records]);
    }

    /******************** END ********************/


