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
                    <h2 class="mt-30 page-title">Sub Category</h2>
                    <ol class="breadcrumb mb-30">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sub Category</li>
                    </ol>

                    <div class="row justify-content-between">

                        <div class="col-lg-12 col-md-12">
                            <div class="card card-static-2 mt-30 mb-30">
                                <div class="card-title-2">
                                    <h4 style="width:100%;display: flex; justify-content: space-between;align-items: center;">
                                        <p><b>Sub Category</b></p>
                                        <p><a href="add_sub_category.php" class="add-btn hover-btn">Add New</a></p>
                                    </h4>
                                </div>
                                <div class="card-body-table px-3">
                                    <div class="table-responsive">
                                        <table class="table ucp-table table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width:60px">ID</th>
                                                    <th>Sub Category</th>
                                                    <th>Description</th>
                                                    <th>Category</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td>2</td>
                                                    <td>Tshirts</td>
                                                    <td>Build using Special Fabric, 99% dustproof</td>
                                                    <td>Men</td>
                                                    <td class="action-btns">
                                                        <a href="add_sub_category.php" style="cursor: pointer;" class="edit-btn"><i class="fas fa-edit"></i></a>&nbsp;
                                                        <a style="cursor: pointer;" class="edit-btn"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
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
<!-- Mirrored from gambolthemes.net/html-items/gambo_admin/category.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Feb 2021 16:40:06 GMT -->

</html>