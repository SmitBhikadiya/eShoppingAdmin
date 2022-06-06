<?php
session_start();
require_once('./handler/aboutUsHandler.php');
$obj = new AboutusHandler();

// checking update request
$btn = "Submit";
$content = $obj->getContent();
if (count($content) > 0) {
    $result = $content;
    $btn = "Update";
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
    <title>eShopping - Admin</title>
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/admin-style.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <script src="//cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>
    <style>
        #cke_1_contents{
            min-height: 80vh !important;
        }
    </style>
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
                    <h2 class="mt-30 page-title">AboutUs</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">AboutUs</li>
                    </ol>
                </div>

               <div class="container-fluid">
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
                    <div class="col-lg-12 col-md-12">
                        <div class="card card-static-2 mb-30">
                            <div class="card-title-2">
                                <h4 style="width:100%;display: flex; justify-content: space-between;align-items: center;">
                                    <p><b>Banners</b></p>
                                </h4>
                            </div>
                            <div class="card-body-table px-3">
                                <form action="./handler/requestHandler.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="aboutId" value="<?= isset($result) ? $result["id"] : "" ?>">
                                    <textarea name="aboutus" id="editor">
                                        <?= isset($result) ? $result["content"] : "" ?>
                                    </textarea>
                                    <button type="submit" class="save-btn hover-btn mb-3 mt-1" name="<?= $btn ?>AboutUs" value="<?= $btn ?>AboutUs"><?= $btn ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
               </div>
            </main>
        </div>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/validation.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
</body>

</html>