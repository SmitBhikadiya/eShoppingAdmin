<?php
session_start();
require("./handler/testimonialHandler.php");
$obj = new TestimonialHandler();

// checking update request
$btn = "Add";
if (isset($_GET["edit"])) {
    $result = $obj->getTestimonialById($_GET["edit"]);
    if (count($result) < 1) {
        $_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
        header("Location: ./testimonials.php");
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
                    <h2 class="mt-30 page-title"><?= $btn ?> Testimonial</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="testimonials.php">Testimonial</a></li>
                        <li class="breadcrumb-item active"><?= $btn ?> Testimonial</li>
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
                                        <p><b><?= $btn ?> Testimonial</b></p>
                                    </h4>
                                </div>
                                <div class="card-body-table px-3">
                                    <form action="./handler/requestHandler.php" id="formAddTestimonial" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="testiId" value="<?= isset($result) ? $result["id"] : '' ?>">
                                        <div class="card-body-table px-3">
                                            <div class="news-content-right pd-20">
                                                <div class="form-group">
                                                    <label class="form-label">Reviewer Name*</label>
                                                    <input type="text" id="addReviewer" name="reviewer" class="form-control" placeholder="Reviewer Name" value="<?= isset($result) ? $result["reviewerName"] : "" ?>" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Reviewer Profession*</label>
                                                    <input type="text" id="addProfession" class="form-control" name="profession" placeholder="Reviewer Profession" value="<?= isset($result) ? $result["reviewerProfession"] : "" ?>" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Review*</label>
                                                    <textarea name="review" id="review" class="form-control" placeholder="Review" rows="3"><?= isset($result) ? $result["review"] : "" ?></textarea>
                                                </div>
                                                <div class="form-group">
                                            <label class="form-label">Reviewer Image*</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="hidden" name="oldimage" id="oldimages" value="<?= isset($result) ? $result["reviewerImage"] : "" ?>">
                                                    <input type="file" class="custom-file-input" name="file" id="rimages" accept=".jpg, .jpeg, .png" aria-describedby="inputGroupFileAddon04" data-action="<?= $btn ?>">
                                                    <label class="custom-file-label" for="rimages">Add Banner Image</label>
                                                </div>
                                            </div>
                                            <ul class="add-produc-imgs">
                                                <?php
                                                if (isset($result)) {
                                                    if ($result["reviewerImage"] != '') {
                                                        $image = $result["reviewerImage"];
                                                ?>
                                                        <li>
                                                            <div class="add-cate-img-1">
                                                                <img width='70' height='70' style="margin-bottom: 9px;" src="./images/testimonials/<?= $image ?>" alt="" />
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
                                                <button class="save-btn hover-btn mb-3" type="submit" name="<?= $btn ?>Testimonial" value="<?= $btn ?>Testimonial">
                                                    <?= $btn ?> Testimonial
                                                </button>
                                            </div>
                                        </div>
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
        $("#rimages").on("change", function(e) {
            files_ = $(this).get(0).files;
            var html = '';
            var relPath = '';
            let action = $("#rimages").data("action");
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