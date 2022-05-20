<?php
session_start();
require_once("addressHandler.php");
require_once("adminuserHandler.php");
require_once("categoryHandler.php");
require_once("productHandler.php");
require_once("customerHandler.php");
require_once("orderHandler.php");
require_once("taxHandler.php");
require_once("couponHandler.php");
require_once("bannerHandler.php");
require_once("testimonialHandler.php");

$addressH = new AddressHandler();
$adminuserH = new AdminUser();
$categoryH = new CategoryHandler();
$productH = new ProductHandler();
$customerH = new CustomerHandler();
$orderH = new OrderHandler();
$taxH = new TaxHandler();
$couponH = new CouponHandler();
$bannerH = new BannerHandler();
$testiH = new TestimonialHandler();
$error = '';
$success = '';

if(isset($_FILES["file"]["name"]) && isset($_POST["prdid"])){
    // upload files to local directory
    $prdid = (int) $_POST["prdid"];
    $targetDir = "../images/product/";
    $files = $_FILES["file"];
    $image = "product_" . time() . rand(0, 1000) . '.png';
    $target = $targetDir . $image;
    $error = '';
    if (move_uploaded_file($files["tmp_name"], $target)) {
        $product = $productH->getProductById($prdid);
        $images = explode(",",$product["productImages"]);
        array_push($images, $image);
        $images = trim(implode(",", $images), ",");
        $error = $productH->updateProductImages($prdid, $images);
    }else{
        $error = "Error while file is uploading!!";
    }
    echo json_encode(["error"=>$error, "image"=>$image, "prdid"=>$prdid]);
    exit();
}

/*------------- Admin Signin -------------*/
if (isset($_POST["signin"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $error = $adminuserH->signIn($email, $password);
    if ($error == '') {
        header("Location: ../index.php");
    } else {
        $_SESSION["error"] = $error;
        header("Location: ../signin.php");
    }
}

/*------------- For changing Order status -------------*/
if (isset($_POST["orderStatus"])) {
    $status = (int) $_POST["status"];
    $id = (int) $_POST["ordid"];
    if (in_array($status, [1, 2])) {
        $orderH->updateStatus($status, $id);
        $msg = "Order " . (($status == 1) ? "completed" : "cancelled") . " successfully!!!";
        $_SESSION["result"] = ["msg" => $msg, "error" => false];
        header("Location: ../completed_orders.php");
    } else {
        $_SESSION["result"] = ["msg" => "Invalid Request!!!", "error" => true];
        header("Location: ../view_order.php");
    }
}

/*--------------- Add Testimonial ---------------*/
if(isset($_POST["AddTestimonial"])){
    $reviewer = $_POST['reviewer'];
    $profession = $_POST['profession'];
    $review = $_POST['review'];
    $files = $_FILES["file"];
    $reviewerImageURL = '';

    // upload files to local directory
    $targetDir = "../images/testimonials/";
    if($files["name"] != ''){
        $imgname = "testi_" . time() . rand(0, 1000) . '.png';
        $target = $targetDir . $imgname;
        if (move_uploaded_file($files["tmp_name"], $target)) {
            $reviewerImageURL = $imgname;
        }
    }

    $error = $testiH->addTestimonial($reviewer,$profession, $reviewerImageURL, $review);

    if ($error == "") {
        $_SESSION["result"] = ["msg" => "New Testimonial Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../testimonials.php");
}

/*--------------- Update Testimonial ---------------*/
if(isset($_POST["EditTestimonial"])){
    $testiId = $_POST["testiId"];
    $reviewer = $_POST['reviewer'];
    $profession = $_POST['profession'];
    $review = $_POST['review'];

    $oldfile = $_POST["oldimage"];
    $files = $_FILES["file"];
    $reviewerImageURL = '';

    // remove oldimages if new images are selected
    $targetDir = "../images/testimonials/";
    if ($files["name"] != '') {
        $imgname = "testi_" . time() . rand(0, 1000) . '.png';
        $target = $targetDir . $imgname;
        if (move_uploaded_file($files["tmp_name"], $target)) {
            $reviewerImageURL = $imgname;
        }
    } else {
        $reviewerImageURL = $oldfile;
    }

    $error = $testiH->updateTestimonial($testiId, $reviewer, $profession, $reviewerImageURL, $review);

    if ($error == "") {
        $_SESSION["result"] = ["msg" => "Testimonial Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../testimonials.php");
}
/*--------------- Delete Testimonial ---------------*/
if(isset($_GET["dTestimonial"])){
    $id = (int) $_GET["dTestimonial"];
    if ($testiH->deleteTestimonial($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../testimonials.php");
}

//
if(isset($_GET["dReview"])){
    $id = (int) $_GET["dReview"];
    if ($productH->deleteReview($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../product_review.php");
}


/*--------------- Add Banner ---------------*/
if(isset($_POST["AddBanner"])){
    $bannerName = $_POST["bannerName"];
    $bannerDesc = $_POST["bannerDesc"];
    $files = $_FILES["file"];
    $bannerImageURL = '';

    // upload files to local directory
    $targetDir = "../images/banners/";
    if($files["name"] != ''){
        $imgname = "banner_" . time() . rand(0, 1000) . '.png';
        $target = $targetDir . $imgname;
        if (move_uploaded_file($files["tmp_name"], $target)) {
            $bannerImageURL = $imgname;
        }
    }

    $error = $bannerH->addBanner($bannerName, $bannerDesc, $bannerImageURL);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "New Banner ('$bannerName') Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../banners.php");
}

/*--------------- Update Banner ---------------*/
if(isset($_POST["EditBanner"])){
    $bannerId = $_POST["bannerId"];
    $bannerName = $_POST["bannerName"];
    $bannerDesc = $_POST["bannerDesc"];
    $oldfile = $_POST["oldimage"];
    $files = $_FILES["file"];
    $bannerImageURL = '';

    // remove oldimages if new images are selected
    $targetDir = "../images/banners/";
    if ($files["name"] != '') {
        $imgname = "banner_" . time() . rand(0, 1000) . '.png';
        $target = $targetDir . $imgname;
        if (move_uploaded_file($files["tmp_name"], $target)) {
            $bannerImageURL = $imgname;
        }
    } else {
        $bannerImageURL = $oldfile;
    }
    
    $error = $bannerH->updateBanner($bannerId, $bannerName, $bannerDesc, $bannerImageURL);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "Banner ('$bannerName') Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../banners.php");
}

/*--------------- Delete Banner ---------------*/
if (isset($_GET["dBanner"])) {
    $id = (int) $_GET["dBanner"];
    if ($bannerH->deleteBanner($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../banners.php");
}

/*------------- Delete Customer -------------*/
if (isset($_GET["dCustomer"])) {
    $id = (int) $_GET["dCustomer"];
    if ($customerH->deleteCustomer($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../customers.php");
}

/*------------- Delete Customer Address -------------*/
if (isset($_GET["dUserAddress"])) {
    $id = (int) $_GET["dUserAddress"];
    if ($customerH->deleteUserAddress($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../user_address.php");
}

/*------------- Add Tax -------------*/
if(isset($_POST["AddTax"])){
    $tax = $_POST["tax"];
    $countryId = $_POST["country"];
    $stateId = $_POST["state"];
    $error = $taxH->addTax($tax, $stateId, $countryId);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "New Tax ('$tax') Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../service_tax.php");
}

/*------------- Update Tax -------------*/
if(isset($_POST["EditTax"])){
    $taxId = (int) $_POST["taxId"];
    $tax = $_POST["tax"];
    $countryId = $_POST["country"];
    $stateId = $_POST["state"];
    $error = $taxH->updateTax($taxId, $tax, $stateId, $countryId);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../service_tax.php");
}

/*------------- Delete Tax -------------*/
if(isset($_GET["dTax"])){
    $id = (int) $_GET["dTax"];
    if ($taxH->deleteTaxRecords($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../service_tax.php");
}

/*------------- Add Coupen -------------*/
if(isset($_POST["AddCoupon"])){
    $couponCode = $_POST["couponCode"];
    $couponExpiryDate = explode("T",$_POST["couponExpiryDate"]);
    $discount_amount = $_POST["discountAmount"];
    $requireAmountForApplicable = $_POST["requireAmountForApplicable"];
    $maximumTotalUsage = $_POST["maximumTotalUsage"];
    $expTime = $couponExpiryDate[0] ." ". $couponExpiryDate[1];

    $error = $couponH->addCoupon($couponCode, $expTime, $requireAmountForApplicable, $maximumTotalUsage, $discount_amount);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "New Coupon ('$couponCode') Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../coupons.php");

    //echo $couponCode, " ", $expTime, " ",$discount_amount," ", $requireAmountForApplicable," ", $maximumTotalUsage;
    //exit();
}

if(isset($_POST["EditCoupon"])){
    $id = $_POST["couponId"];
    $couponCode = $_POST["couponCode"];
    $couponExpiryDate = explode("T",$_POST["couponExpiryDate"]);
    $discount_amount = $_POST["discountAmount"];
    $requireAmountForApplicable = $_POST["requireAmountForApplicable"];
    $maximumTotalUsage = $_POST["maximumTotalUsage"];
    $expTime = $couponExpiryDate[0] ." ". $couponExpiryDate[1];

    $error = $couponH->updateCoupon($id, $couponCode, $expTime, $requireAmountForApplicable, $maximumTotalUsage, $discount_amount);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "Coupon ('$couponCode') updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../coupons.php");

    //echo $couponCode, " ", $expTime, " ",$discount_amount," ", $requireAmountForApplicable," ", $maximumTotalUsage;
    //exit();
}

/*------------- Delete Product -------------*/
if (isset($_GET["dCoupon"])) {
    $id = (int) $_GET["dCoupon"];
    if ($couponH->deleteCoupon($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../coupons.php");
}


/*------------- Add Product -------------*/
if (isset($_POST["AddProduct"])) {
    $name = strtolower(trim($_POST["name"]));
    $desc = strtolower(trim($_POST["desc"]));
    $catid = $_POST["category"];
    $subcatid = $_POST["subcategory"];
    $price = $_POST["price"];
    $qty = $_POST["qty"];
    $colorids = $_POST["colors"];
    $sizeids = $_POST["sizes"];
    $sku = $_POST["sku"];
    $files = $_FILES["file"];
    $images = [];
    $trending = isset($_POST["trending"]) ? 1 : 0;

    // upload files to local directory
    $targetDir = "../images/product/";
    for ($i = 0; $i < count($files["name"]); $i++) {
        $imgname = "product_" . time() . rand(0, 1000) . '.png';
        $target = $targetDir . $imgname;
        if (move_uploaded_file($files["tmp_name"][$i], $target)) {
            array_push($images, $imgname);
        }
    }

    $error = $productH->addProduct($name, $desc, $catid, $subcatid, $price, $qty, $colorids, $sizeids, $images, $trending, $sku);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "New Product '$name' Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }

    header("Location: ../products.php");
}

/*------------- Add Color -------------*/
if (isset($_POST["AddColor"])) {
    $color = strtolower(trim($_POST["color"]));
    $value = strtolower(trim($_POST["value"]));
    $error = $productH->addColor($color, $value);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "New Color '$color' Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../product_color.php");
}

/*------------- Add Size -------------*/
if (isset($_POST["AddSize"])) {
    $size = strtolower(trim($_POST["size"]));
    $error = $productH->addSize($size);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "New Size '$size' Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../product_size.php");
}

/*------------- Update Product -------------*/
if (isset($_POST["EditProduct"])) {
    $name = strtolower(trim($_POST["name"]));
    $desc = strtolower(trim($_POST["desc"]));
    $catid = $_POST["category"];
    $subcatid = $_POST["subcategory"];
    $price = $_POST["price"];
    $qty = $_POST["qty"];
    $colorids = $_POST["colors"];
    $sizeids = $_POST["sizes"];
    $files = $_FILES["file"];
    $sku = $_POST["sku"];
    $oldfiles = $_POST["oldimages"];
    $prdid = $_POST["productid"];
    $images = [];
    $targetDir = "../images/product/";
    $trending = isset($_POST["trending"]) ? 1 : 0;

    // remove oldimages if new images are selected
    if ($files["name"][0] != "") {
        // upload files to local directory
        for ($i = 0; $i < count($files["name"]); $i++) {
            $imgname = "product_" . time() . rand(0, 1000) . '.png';
            $target = $targetDir . $imgname;
            if (move_uploaded_file($files["tmp_name"][$i], $target)) {
                array_push($images, $imgname);
            }
        }
        $images = array_merge($images, explode(",", $oldfiles));
    } else {
        $images = explode(",", $oldfiles);
    }

    $error = $productH->updateProduct($prdid, $name, $desc, $catid, $subcatid, $price, $qty, $colorids, $sizeids, $images, $trending, $sku);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "Product '$name' Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }

    header("Location: ../products.php");
}

/*------------- Update Color -------------*/
if (isset($_POST["EditColor"])) {
    $colorid = (int) $_POST["colorid"];
    $color = strtolower(trim($_POST["color"]));
    $value = strtolower(trim($_POST["value"]));
    $error = $productH->updateColor($colorid, $color, $value);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../product_color.php");
}

/*------------- Edit Size -------------*/
if (isset($_POST["EditSize"])) {
    $sizeid = (int) $_POST["sizeid"];
    $size = strtolower(trim($_POST["size"]));
    $error = $productH->updateSize($sizeid, $size);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../product_size.php");
}

/*------------- Delete Product -------------*/
if (isset($_GET["dProduct"])) {
    $id = (int) $_GET["dProduct"];
    if ($productH->deleteProduct($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../products.php");
}

/*------------- Delete Color -------------*/
if (isset($_GET["dColor"])) {
    $id = (int) $_GET["dColor"];
    if ($productH->deleteColor($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../product_color.php");
}

/*------------- Delete Size -------------*/
if (isset($_GET["dSize"])) {
    $id = (int) $_GET["dSize"];
    if ($productH->deleteSize($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../product_size.php");
}

/*------------- Add Category -------------*/
if (isset($_POST["AddCategory"])) {
    $catname = strtolower(trim($_POST["catname"]));
    $catdesc = strtolower(trim($_POST["catdesc"]));
    $error = $categoryH->addCategory($catname, $catdesc);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "New Category '$catname' Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../category.php");
}

/*------------- Add Sub Category -------------*/
if (isset($_POST["AddSubCategory"])) {
    $catid = $_POST["category"];
    $catname = strtolower(trim($_POST["subcatname"]));
    $catdesc = strtolower(trim($_POST["subcatdesc"]));
    $error = $categoryH->addSubCategory($catname, $catdesc, $catid);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "New Sub Category '$catname' Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../sub_category.php");
}

/*------------- Update Category -------------*/
if (isset($_POST["EditCategory"])) {
    $catid = $_POST["categoryid"];
    $catname = strtolower(trim($_POST["catname"]));
    $catdesc = strtolower(trim($_POST["catdesc"]));
    $error = $categoryH->updateCategory($catid, $catname, $catdesc);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "Category '$catname' Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../category.php");
}

/*------------- Update Sub Category -------------*/
if (isset($_POST["EditSubCategory"])) {
    $subcatid = $_POST["subcatid"];
    $catid = $_POST["category"];
    $catname = strtolower(trim($_POST["subcatname"]));
    $catdesc = strtolower(trim($_POST["subcatdesc"]));
    $error = $categoryH->updateSubCategory($subcatid, $catname, $catdesc, $catid);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "Sub Category '$catname' Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../sub_category.php");
}

/*------------- Delete Category -------------*/
if (isset($_GET["dCategory"])) {
    $id = (int) $_GET["dCategory"];
    if ($categoryH->deleteCategory($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../category.php");
}

/*------------- Delete Sub Category -------------*/
if (isset($_GET["dSubCategory"])) {
    $id = (int) $_GET["dSubCategory"];
    if ($categoryH->deleteSubCategory($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../sub_category.php");
}

/*------------- Get Sub Category List By category Id -------------*/
if (isset($_POST["categoryId"])) {
    $records = $categoryH->getSubCategoryByCategoryId($_POST["categoryId"]);
    echo json_encode(["categories" => $records]);
}

/*------------- Add City -------------*/
if (isset($_POST["AddCity"])) {
    $countryid = $_POST["country"];
    $stateid = $_POST["state"];
    $city = strtolower(trim($_POST["city"]));
    $error = $addressH->addCity($countryid, $stateid, $city);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "'$city' city Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../cities.php");
}

/*------------- Add State -------------*/
if (isset($_POST["AddState"])) {
    $countryid = $_POST["country"];
    $state = strtolower(trim($_POST["state"]));
    $error = $addressH->addState($countryid, $state);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "'$state' state Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../states.php");
}

/*------------- Add Country -------------*/
if (isset($_POST["AddCountry"])) {
    $country = strtolower(trim($_POST["country"]));
    $error = $addressH->addCountry($country);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "'$country' country Added Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../countries.php");
}

/*------------- Update City -------------*/
if (isset($_POST["EditCity"])) {
    $countryid = $_POST["country"];
    $stateid = $_POST["state"];
    $cityid = $_POST["cityid"];
    $city = strtolower(trim($_POST["city"]));
    $error = $addressH->updateCity($countryid, $stateid, $cityid, $city);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "'$city' city Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../cities.php");
}

/*------------- Update State -------------*/
if (isset($_POST["EditState"])) {
    $countryid = $_POST["country"];
    $stateid = $_POST["stateid"];
    $state = strtolower(trim($_POST["state"]));
    $error = $addressH->updateState($countryid, $stateid, $state);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "'$state' state Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../states.php");
}

/*------------- Update Country -------------*/
if (isset($_POST["EditCountry"])) {
    $country = strtolower(trim($_POST["country"]));
    $countryid = $_POST["countryid"];
    $error = $addressH->updateCountry($countryid, $country);
    if ($error == "") {
        $_SESSION["result"] = ["msg" => "'$country' country Updated Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => $error, "error" => true];
    }
    header("Location: ../countries.php");
}

/*------------- Delete City -------------*/
if (isset($_GET["dCity"])) {
    $id = (int) $_GET["dCity"];
    if ($addressH->deleteCity($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../cities.php");
}

/*------------- Delete State -------------*/
if (isset($_GET["dState"])) {
    $id = (int) $_GET["dState"];
    if ($addressH->deleteState($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../states.php");
}

/*------------- Delete Country -------------*/
if (isset($_GET["dCountry"])) {
    $id = (int) $_GET["dCountry"];
    if ($addressH->deleteCountry($id)) {
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    } else {
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../countries.php");
}

/*------ Get State List By Country Id -------*/
if (isset($_POST["countryid"])) {
    $records = $addressH->getStatesByCountryId($_POST["countryid"]);
    echo json_encode(["states" => $records]);
}

/*----------- Delete Image -------------*/
if(isset($_GET["dImage"]) && isset($_GET["prdId"])){
    $image = $_GET["dImage"];
    $prdid = $_GET["prdId"];
    $targetDir = "../images/product/";
    $product = $productH->getProductById($prdid);
    $images = explode(",",$product["productImages"]);
    $images = array_diff($images, [$image]);
    $images = implode(",", $images);
    $error = $productH->updateProductImages($prdid, $images);
    if($error==''){
        unlink($targetDir . $image);
        $_SESSION["result"] = ["msg" => "Deleted Successfully", "error" => false];
    }else{
        $_SESSION["result"] = ["msg" => "Somthing went wrong!!!", "error" => true];
    }
    header("Location: ../../add_product.php?edit=$prdid"); 
}