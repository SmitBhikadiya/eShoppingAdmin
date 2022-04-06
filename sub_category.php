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


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Sub Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                        <button class="save-btn hover-btn" style="width: 100%;" type="submit">Add Sub Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php
            include_once("./includes/sidebar.php");
            ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h2 class="mt-30 page-title">Sub Categories</h2>
                    <ol class="breadcrumb mb-30">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sub Categories</li>
                    </ol>

                    <div class="row justify-content-between">

                        <div class="col-lg-12 col-md-12">
                            <div class="card card-static-2 mt-30 mb-30">
                                <div class="card-title-2">
                                    <h4 style="width:100%;display: flex; justify-content: space-between;align-items: center;">
                                        <p><b>Sub Categories</b></p>
                                        <p><button class="save-btn hover-btn" data-toggle="modal" data-target="#exampleModal">Add New</button></p>
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
                                                        <a data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;" class="edit-btn"><i class="fas fa-edit"></i></a>&nbsp;
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