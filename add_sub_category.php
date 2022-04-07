<?php
    session_start();
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
                    <h2 class="mt-30 page-title">Add Sub Category</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="sub_category.php">Sub Category</a></li>
                        <li class="breadcrumb-item active">Add Sub Category</li>
                    </ol>
                    <div class="row justify-content-between">
                        <div class="col-lg-5 col-md-5">
                            <div class="card card-static-2 mt-30 mb-30">
                                <div class="card-title-2">
                                    <h4 style="width:100%;display: flex; justify-content: space-between;align-items: center;">
                                        <p><b>Add Sub Category</b></p>
                                    </h4>
                                </div>
                                <div class="card-body-table px-3">
                                    <form id="formAddSubCategory" action="add_sub_category.php">
                                        <div class="form-group">
                                            <label class="form-label">Category*</label>
                                            <select id="category" name="category" class="form-control">
                                                <option value="1">Men</option>
                                                <option value="2">Women</option>
                                                <option value="3">Kids</option>
                                                <option value="3">Accessories</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Name*</label>
                                            <input type="text" class="form-control" id="subcategory" placeholder="Sub Category Name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Description*</label>
                                            <textarea class="form-control" id="description" rows="3" placeholder="Enter sub category description"></textarea>
                                        </div>
                                        <button class="save-btn hover-btn mb-3" type="submit">Add Sub Category</button>
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