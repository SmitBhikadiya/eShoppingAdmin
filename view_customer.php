<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description-gambolthemes" content="">
	<meta name="author-gambolthemes" content="">
	<title>Gambo Supermarket Admin</title>
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
					<h2 class="mt-30 page-title">Customers</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="customers.php">Customers</a></li>
						<li class="breadcrumb-item active">Customer View</li>
					</ol>
					<div class="row">
						<div class="col-lg-5 col-md-5">
							<div class="card card-static-2 mb-30">
								<div class="card-body-table">
									<div class="shopowner-content-left text-center pd-20">
										<div class="customer_img">
											<img src="images/avatar/img-1.jpg" alt="">
										</div>
										<div class="shopowner-dt-left mt-4">
											<h4>Sam Curran</h4>
											<span>Customer</span>
										</div>
										<div class="shopowner-dts">
											<div class="shopowner-dt-list">
												<span class="left-dt">Full Name</span>
												<span class="right-dt">Sam Curran</span>
											</div>
											<div class="shopowner-dt-list">
												<span class="left-dt">Email</span>
												<span class="right-dt">sam@gmail.com</span>
											</div>
											<div class="shopowner-dt-list">
												<span class="left-dt">Phone</span>
												<span class="right-dt">+918437176189</span>
											</div>
											<div class="shopowner-dt-list">
												<span class="left-dt">Address</span>
												<span class="right-dt">Ludhiana, Punjab</span>
											</div>
										</div>
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
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="js/scripts.js"></script>
</body>

</html>