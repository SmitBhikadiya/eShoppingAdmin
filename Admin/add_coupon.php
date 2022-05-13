<?php
session_start();
require("./handler/couponHandler.php");
$obj = new CouponHandler();

// checking update request
$btn = "Add";
if (isset($_GET["edit"])) {
    $result = $obj->getCouponById($_GET["edit"]);
    if (count($result) < 1) {
        $_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
        header("Location: ./coupons.php");
    }
    $btn = "Edit";
}

// for error or success message
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
    <title>eShopper - Admin</title>
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
                    <h2 class="mt-30 page-title"><?= $btn ?> Coupon</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="coupons.php">Coupons</a></li>
                        <li class="breadcrumb-item active"><?= $btn ?> Coupon</li>
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

                    <div class="row justify-content-between">
                        <div class="col-lg-5 col-md-5">
                            <div class="card card-static-2 mb-30">
                                <div class="card-title-2">
                                    <h4 style="width:100%;display: flex; justify-content: space-between;align-items: center;">
                                        <p><b><?= $btn ?> Coupon</b></p>
                                    </h4>
                                </div>
                                <div class="card-body-table px-3">
                                    <form id="formAddCoupon" action="./handler/requestHandler.php" method="POST">
                                        <input type="hidden" name="couponId" value="<?= isset($result) ? $result["id"] : "" ?>">
                                        <div class="form-group">
                                            <label class="form-label">Coupon Code*</label>
                                            <input type="text" class="form-control" name="couponCode" id="couponCode" placeholder="Coupon Code" value="<?= isset($result) ? $result["couponCode"] : "" ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Coupon Expiry*</label>
                                            <input type="datetime-local" class="form-control" name="couponExpiryDate" id="couponExpiry" placeholder="Coupon Expiry" value="<?= isset($result) ? str_replace(" ", "T", $result["couponExpiry"]) : "" ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Discount Amount*</label>
                                            <input type="number" class="form-control" name="discountAmount" id="discountAmount" placeholder="Discount Amount" value="<?= isset($result) ? $result["discountAmount"] : "" ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Min Amount In Cart*</label>
                                            <input type="number" class="form-control" name="requireAmountForApplicable" id="requireAmountForApplicable" placeholder="Minimum Amount In Cart" value="<?= isset($result) ? $result["requireAmountForApplicable"] : "" ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Maximum Total Usage*</label>
                                            <input type="number" class="form-control" name="maximumTotalUsage" id="maximumTotalUsage" placeholder="Maximum Total Usage" value="<?= isset($result) ? $result["maximumTotalUsage"] : "" ?>">
                                        </div>
                                        <button type="submit" name="<?= $btn ?>Coupon" value="<?= $btn ?>Coupon" class="save-btn hover-btn mb-3"><?= $btn ?> Coupon</button>
                                    </form>
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
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/validation.js"></script>
</body>

</html>