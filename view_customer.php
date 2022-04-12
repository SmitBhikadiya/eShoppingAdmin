<?php
session_start();
require_once("./handler/customerHandler.php");

if (!isset($_GET["view"])) {
    $_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
    header("Location: ./customers.php");
} else {
    $obj = new CustomerHandler();
    $id = (int) $_GET["view"];
    $cust = $obj->getCustomerById($id);
    if (count($cust) < 1) {
        $_SESSION["result"] = ["msg" => "Invalid Request OR Not found!!", "error" => true];
        header("Location: ./customers.php");
    }
}

$msg = '';
$error = false;
if (isset($_SESSION["result"])) {
    $error = $_SESSION["result"]["error"];
    $msg = $_SESSION["result"]["msg"];
    unset($_SESSION["result"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description-gambolthemes" content="">
    <meta name="author-gambolthemes" content="">
    <title>AP Mart - Admin</title>
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/admin-style.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>

<body class="sb-nav-fixed">
    <?php
    include_once("./includes/header.php");
    ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php
            include_once("./includes/sidebar.php");
            ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h2 class="mt-30 page-title">View Customer</h2>
                    <ol class="breadcrumb mb-30">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="customers.php">Customers</a></li>
                        <li class="breadcrumb-item active">View Customer</li>
                    </ol>

                    <?php
                    if ($msg != '') {
                    ?>
                        <div class="alert alert-<?= ($error) ? 'danger' : 'success' ?> alert-dismissible fade show" role="alert">
                            <?= $msg ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="card card-static-2 mb-30">
                                <div class="card-body-table">
                                    <div class="shopowner-content-left text-center pd-20">
                                        <div class="shop_img mb-3">
                                            <img src="images/avatar/img-1.jpg" alt="">
                                        </div>
                                        <div class="shopowner-dt-left">
                                            <h4>Customer View</h4>
                                        </div>
                                        <div class="shopowner-dts">
                                            <div class="shopowner-dt-list">
                                                <span class="left-dt">User Name</span>
                                                <span class="right-dt"><?=$cust["username"]?></span>
                                            </div>
                                            <div class="shopowner-dt-list">
                                                <span class="left-dt">Email</span>
                                                <span class="right-dt"><?=$cust["email"]?></span>
                                            </div>
                                            <div class="shopowner-dt-list">
                                                <span class="left-dt">First Name</span>
                                                <span class="right-dt"><?=$cust["firstname"]?></span>
                                            </div>
                                            <div class="shopowner-dt-list">
                                                <span class="left-dt">Last Name</span>
                                                <span class="right-dt"><?=$cust["lastname"]?></span>
                                            </div>
                                            <div class="shopowner-dt-list">
                                                <span class="left-dt">Gender</span>
                                                <span class="right-dt"><?=$cust["gender"]==0 ? "Male" : "Female"?></span>
                                            </div>
                                            <div class="shopowner-dt-list">
                                                <span class="left-dt">Mobile</span>
                                                <span class="right-dt"><?=$cust["mobile"]?></span>
                                            </div>
                                            <div class="shopowner-dt-list">
                                                <span class="left-dt">Phone</span>
                                                <span class="right-dt"><?=$cust["phone"]?></span>
                                            </div>
                                            <div class="shopowner-dt-list">
                                                <span class="left-dt">interestList</span>
                                                <span class="right-dt"><?=$cust["interestList"]?></span>
                                            </div>
                                            <div class="shopowner-dt-list">
                                                <span class="left-dt">modifiedDate</span>
                                                <span class="right-dt"><?=$cust["modifiedDate"]?></span>
                                            </div>
                                            <div class="shopowner-dt-list">
                                                <span class="left-dt">createdDate</span>
                                                <span class="right-dt"><?=$cust["createdDate"]?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php
            include_once("./includes/footer.php");
            ?>
        </div>
    </div>
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
<!-- Mirrored from gambolthemes.net/html-items/gambo_admin/edit_profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Feb 2021 16:39:42 GMT -->

</html>