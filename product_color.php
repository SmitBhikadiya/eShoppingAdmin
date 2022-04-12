<?php
session_start();
require("./handler/productHandler.php");
$obj = new ProductHandler();
$colors = $obj->getColors();
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
                    <h2 class="mt-30 page-title">Product Colors</h2>
                    <ol class="breadcrumb mb-30">
                        <li class="breadcrumb-item">
                            <a href="index.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Product Color</li>
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
                            <div class="card card-static-2 mt-30 mb-30">
                                <div class="card-title-2">
                                    <h4 style="width:100%;display: flex; justify-content: space-between;align-items: center;">
                                        <p><b>All Colors</b></p>
                                        <p><a href="add_color.php" class="add-btn hover-btn">Add Color</a></p>
                                    </h4>
                                </div>
                                <div class="card-body-table px-3">
                                    <div class="table-responsive">
                                        <table class="table ucp-table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Name</th>
                                                    <th>Value</th>
                                                    <th>Created Date</th>
                                                    <th>Updated Date</th>
                                                    <th>View</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (count($colors) > 0) {
                                                    $srno = 1;
                                                    foreach ($colors as $color) {
                                                ?>
                                                        <tr>
                                                            <th><?= $srno++ ?></th>
                                                            <td><?= $color["colorName"] ?></td>
                                                            <td><?= $color["colorCode"] ?></td>
                                                            <td><?= $color["createdDate"] ?></td>
                                                            <td><?= $color["modifiedDate"] ?></td>
                                                            <td>
                                                                <div class="colorview" style="background-color: <?= $color["colorCode"] ?>;"></div>
                                                            </td>
                                                            <td class="action-btns">
                                                                <a href="add_color.php?edit=<?= $color["id"] ?>" style="cursor: pointer;" class="edit-btn"><i class="fas fa-edit"></i></a>&nbsp;
                                                                <a href="./handler/requestHandler.php?dColor=<?= $color["id"] ?>" style="cursor: pointer;" class="edit-btn deleteRow"><i class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan=6>No Record Found!!</td></tr>";
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
    <script src="js/validation.js"></script>
</body>

</html>