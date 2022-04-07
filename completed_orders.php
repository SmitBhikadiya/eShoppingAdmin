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
                                                    <th style="width:80px">Total</th>
                                                    <th style="width:80px">Completed Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>ORDER12345</td>
                                                    <td>
                                                        <a href="#" target="_blank">Sam</a>
                                                    </td>
                                                    <td>#0000, St No. 8, Shahid Karnail Singh Nagar, MBD Mall, Frozpur road, Ludhiana, 141001</td>
                                                    <td>
                                                        <span class="delivery-time">15/06/2020</span>
                                                    </td>

                                                    <td>$90</td>
                                                    <td>02/03/2022 10:55</td>
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

</html>