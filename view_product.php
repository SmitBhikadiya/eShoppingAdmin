<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description-gambolthemes" content="">
	<meta name="author-gambolthemes" content="">
	<title>AP MART - Admin</title>
	<link href="css/styles.css" rel="stylesheet">
	<link href="css/my.css" rel="stylesheet">
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
					<h2 class="mt-30 page-title">Shops</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="shops.php">Shops</a></li>
						<li class="breadcrumb-item active">Shop view</li>
					</ol>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card card-static-2 mb-30">
								<div class="card-body-table">
									<div class="shopowner-content-left text-center pd-20">
										<div class="shop_img">
											<img src="images/product/img-1.jpg" alt="">
										</div>
										<div class="row">
											<div class="col-md-3 col-lg-3"></div>
											<div class="shopowner-dts col-md-6 col-lg-6">
												<div class="shopowner-dt-list">
													<span class="left-dt">Name*</span>
													<span class="right-dt">KOBO</span>
												</div>
												<div class="shopowner-dt-list">
													<span class="left-dt">Category*</span>
													<span class="right-dt">KOBO</span>
												</div>
												<div class="shopowner-dt-list">
													<span class="left-dt">Price*</span>
													<span class="right-dt">$15</span>
												</div>
												<div class="shopowner-dt-list">
													<span class="left-dt">Discount Price*</span>
													<span class="right-dt">$15</span>
												</div>
												<div class="shopowner-dt-list">
													<span class="left-dt">Status*</span>
													<span class="right-dt">Available (in stock)</span>
												</div>
												<div class="col-md-3 col-lg-3"></div>
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
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="js/scripts.js"></script>
</body>

</html>