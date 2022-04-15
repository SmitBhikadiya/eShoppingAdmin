<?php
session_start();
require("./handler/categoryHandler.php");
$obj = new CategoryHandler();

// checking update request
$btn = "Add";
if (isset($_GET["edit"])) {
    $result = $obj->getCatById($_GET["edit"]);
    if (count($result) < 1) {
        $_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
        header("Location: ./category.php");
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
                    <h2 class="mt-30 page-title"><?= $btn ?> Category</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="category.php">Category</a></li>
                        <li class="breadcrumb-item active"><?= $btn ?> Category</li>
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
                            <div class="card card-static-2 mt-30 mb-30">
                                <div class="card-title-2">
                                    <h4 style="width:100%;display: flex; justify-content: space-between;align-items: center;">
                                        <p><b><?= $btn ?> Category</b></p>
                                    </h4>
                                </div>
                                <div class="card-body-table px-3">
                                    <form id="formAddCategory" action="./handler/requestHandler.php" method="POST">
                                        <input type="hidden" name="categoryid" value="<?= isset($result) ? $result["id"] : "" ?>">
                                        <div class="form-group">
                                            <label class="form-label">Name*</label>
                                            <input type="text" class="form-control" id="category" name="catname" placeholder="Category Name" value="<?= (isset($result)) ? $result["catName"] : "" ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Description*</label>
                                            <textarea id="description" name="catdesc" class="form-control" rows="3" placeholder="Enter a description"><?= (isset($result)) ? $result["catDesc"] : "" ?></textarea>
                                        </div>
                                        <button type="submit" name="<?= $btn ?>Category" value="<?= $btn ?>Category" class="save-btn hover-btn mb-3"><?= $btn ?> Category</button>
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