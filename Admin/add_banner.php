<?php
session_start();
require("./handler/bannerHandler.php");
$obj = new BannerHandler();

// checking update request
$states = [];
$btn = "Add";
if (isset($_GET["edit"])) {
    $result = $obj->getBannerById($_GET["edit"]);
    if (count($result) < 1) {
        $_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
        header("Location: ./banners.php");
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
                    <h2 class="mt-30 page-title"><?= $btn ?> Banner</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="banners.php">Home Banners</a></li>
                        <li class="breadcrumb-item active"><?= $btn ?> Banner</li>
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
                                        <p><b><?= $btn ?> Banner</b></p>
                                    </h4>
                                </div>
                                <div class="card-body-table px-3">
                                    <form id="formAddBanner" action="./handler/requestHandler.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="bannerId" value="<?= isset($result) ? $result["id"] : "" ?>">
                                        <div class="form-group">
                                            <label class="form-label">Banner Name*</label>
                                            <input type="text" class="form-control" name="bannerName" value="<?= isset($result) ? $result["bannerName"] : "" ?>" id="bannername" placeholder="Banner Name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Banner Name*</label>
                                            <textarea class="form-control" name="bannerDesc" rows="3" id="bannerdesc" placeholder="Banner Description"><?= isset($result) ? $result["bannerDesc"] : "" ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Banner Image*</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="hidden" name="oldimage" id="oldimages" value="<?= isset($result) ? $result["bannerImageURL"] : "" ?>">
                                                    <input type="file" class="custom-file-input" name="file" id="bimages" accept=".jpg, .jpeg, .png" aria-describedby="inputGroupFileAddon04" data-action="<?= $btn ?>">
                                                    <label class="custom-file-label" for="bimages">Add Banner Image</label>
                                                </div>
                                            </div>
                                            <ul class="add-produc-imgs">
                                                <?php
                                                if (isset($result)) {
                                                    if ($result["bannerImageURL"] != '') {
                                                        $image = $result["bannerImageURL"];
                                                ?>
                                                        <li>
                                                            <div class="add-cate-img-1">
                                                                <img width='70' height='70' style="margin-bottom: 9px;" src="./images/banners/<?= $image ?>" alt="" />
                                                            </div>
                                                        </li>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <li class="errorImg">
                                                        <div class="add-cate-img-1">
                                                            <img width='70' height='70' style="border: 1px solid red;" src="./images/noimage.jpg" title="No image availabel!!" />
                                                        </div>
                                                    </li>
                                                <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <button type="submit" class="save-btn hover-btn mb-3" name="<?= $btn ?>Banner" value="<?= $btn ?>Banner"><?= $btn ?> Banner</button>
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
    <script>
        $("#bimages").on("change", function(e) {
            files_ = $(this).get(0).files;
            var html = '';
            var relPath = '';
            let action = $("#bimages").data("action");
            if (files_.length === 0) {
                html += ``;
            }
            for (i = 0; i < files_.length; i++) {
                $(".errorImg").remove();
                relPath = (URL || webkitURL).createObjectURL(files_[i]);
                html += `<li>
						<div class="add-cate-img-1">
							<img width='70' height='70' style='margin-bottom:9px' src="${relPath}" alt="" />
							<a href="#" style="cursor: pointer;" class="edit-btn deleteRow"><i class="fas"></i></a>
						</div>
					</li>`;
            }
            $(".add-produc-imgs").html(html);
        });
    </script>
</body>

</html>