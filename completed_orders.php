<?php
session_start();
require("./handler/orderHandler.php");
$obj = new OrderHandler();
$orders = $obj->getOrdersHistory();
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
    <title>eShopping Admin</title>
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
                    <h2 class="mt-30 page-title">Completed Orders</h2>

                    <ol class="breadcrumb mb-30">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Completed Orders</li>
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

                    <div class="row justify-content-center">

                        <div class="col-lg-12 col-md-12">
                            <div class="card card-static-2 mb-30">
                                <div class="card-title-2">
                                    <h4><b>All Completed Orders</b></h4>
                                </div>
                                <div class="card-body-table px-3">
                                    <div class="table-responsive">
                                        <table class="table ucp-table table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width:120px">Order ID</th>
                                                    <th style="width:100px">Client Name</th>
                                                    <th style="width:400px">Address</th>
                                                    <th style="width:100px">Order Date</th>
                                                    <th style="width:100px">Modified Date</th>
                                                    <th style="width:80px">Total</th>
                                                    <th style="width:80px">Order Status</th>
                                                    <th style="width:80px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (count($orders) > 0) {
                                                    $srno = 1;
                                                    foreach ($orders as $order) {
                                                ?>
                                                        <tr>
                                                            <td><?=$order["id"]?></td>
                                                            <td>
                                                            <a href="view_customer.php?view=<?=$order["userId"]?>" target="_blank"><?=$order["username"]?></a>
                                                            </td>
                                                            <td><?=$order["streetName"].", ".$order["city"].", ".$order["state"]?></td>
                                                            <td>
                                                                <span class="delivery-time"><?=$order["createdDate"]?></span>
                                                            </td>
                                                            <td>
                                                                <span class="delivery-time"><?=$order["modifiedDate"]?></span>
                                                            </td>
                                                            <td>$<?=$order["totalPrice"]?></td>
                                                            <td><?=($order["orderStatus"]==1)? "Completed" : "Cancelled"?></td>
                                                            <td class="action-btns">
                                                            <a href="view_order.php?view=<?=$order["id"]?>" class="view-shop-btn" title="View"><i class="fas fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan=7>No Record Found!!</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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