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
					<h2 class="mt-30 page-title">Categories</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="category.php">Categories</a></li>
						<li class="breadcrumb-item active">Add Category</li>
					</ol>
					<div class="row">
						<div class="col-lg-10 col-md-10">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h4><b>Add Category</b></h4>
								</div>
								<div class="card-body-table px-3">
									<div class="news-content-right pd-20">
										<form id="formAddCategory" action="add_category.php">
											<div class="form-group">
												<label class="form-label">Name*</label>
												<input type="text" class="form-control" id="category" placeholder="Category Name">
											</div>
											<button type="submit" class="save-btn hover-btn">Add Category</button>
										</form>
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
	<script src="js/validation.js"></script>
</body>

</html>