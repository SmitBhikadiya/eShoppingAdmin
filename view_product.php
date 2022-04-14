<?php
session_start();
require_once("./handler/productHandler.php");

if (!isset($_GET["view"])) {
    $_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
    header("Location: ./products.php");
} else {
    $obj = new ProductHandler();
    $id = (int) $_GET["view"];
    $product = $obj->getProductById($id);
    if (count($product) < 1) {
        $_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
        header("Location: ./products.php");
    }
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
                    <h2 class="mt-30 page-title">Product View</h2>
                    <ol class="breadcrumb mb-30">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="products.php">Products</a></li>
                        <li class="breadcrumb-item active">Product View</li>
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
                        <div class="col-lg-12 col-md-12">
                            <div class="card card-static-2 mb-30">
                                <div class="card-body-table">
                                    <div class="shopowner-content-left text-center pd-20">

                                        <div class="row">
                                            <div class="shopowner-dts col-md-6 col-lg-6">
                                                <div class="d-flex justify-content-center my-3">
                                                    <?php
                                                    $images = explode(",", $product["productImages"]);
                                                    foreach ($images as $image) {
                                                    ?>
                                                        <div class="shop_img d-flex mx-1">
                                                            <img src="images/product/<?= $image ?>" alt="">
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="shopowner-dt-list">
                                                    <span class="left-dt">Product Name*</span>
                                                    <span class="right-dt"><?= $product["productName"] ?></span>
                                                </div>
                                                <div class="shopowner-dt-list">
                                                    <span class="left-dt">Product Description*</span>
                                                    <span class="right-dt"><?= $product["productDesc"] ?></span>
                                                </div>
                                                <div class="shopowner-dt-list">
                                                    <span class="left-dt">Price*</span>
                                                    <span class="right-dt">$<?= $product["productPrice"] ?></span>
                                                </div>
                                                <div class="shopowner-dt-list">
                                                    <span class="left-dt">Quantity*</span>
                                                    <span class="right-dt"><?= $product["totalQuantity"] ?></span>
                                                </div>
                                                <div class="shopowner-dt-list">
                                                    <span class="left-dt">Sizes*</span>
                                                    <span class="right-dt">
                                                        <?php
                                                        $sizes =  $obj->getSizeByIds("(" . $product["productSizeIds"] . ")");
                                                        foreach ($sizes as $size) {
                                                            echo strtoupper($size["size"]) . ", ";
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                                <div class="shopowner-dt-list">
                                                    <span class="left-dt">Colors*</span>
                                                    <span class="right-dt d-flex justify-content-end">
                                                        <?php
                                                            $colors =  $obj->getColorByIds("(" . $product["productColorIds"] . ")");
                                                            foreach ($colors as $color) { 
                                                        ?>
                                                            <div class="colorview mx-1" style="background-color: <?= $color["colorCode"] ?>;"></div>
                                                        <?php
                                                            }
                                                        ?>
                                                    </span>
                                                </div>
                                                <div class="shopowner-dt-list">
                                                    <span class="left-dt">Category*</span>
                                                    <span class="right-dt">
                                                        <?= $product["catName"] ?>
                                                    </span>
                                                </div>
                                                <div class="shopowner-dt-list">
                                                    <span class="left-dt">Sub Category*</span>
                                                    <span class="right-dt">
                                                        <?= $product["subCatName"] ?>
                                                    </span>
                                                </div>
                                                <div class="shopowner-dt-list">
                                                    <span class="left-dt">Modified Date*</span>
                                                    <span class="right-dt">
                                                        <?= $product["modifiedDate"] ?>
                                                    </span>
                                                </div>
                                                <div class="shopowner-dt-list">
                                                    <span class="left-dt">Created Date*</span>
                                                    <span class="right-dt">
                                                        <?= $product["createdDate"] ?>
                                                    </span>
                                                </div>
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
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>