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
					<h2 class="mt-30 page-title">Country</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item"><a href="add_city.php">Address</a></li>
						<li class="breadcrumb-item active">Add Country</li>
					</ol>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h4><b>Add Country</b></h4>
								</div>
								<div class="card-body-table px-3">
									<div class="news-content-right pd-20">
										<form id="formAddCountry" action="add_country.php">
											<div class="form-group">
												<label class="form-label">Country Name*</label>
												<input type="text" class="form-control" id="countryname" placeholder="Country name">
											</div>
											<button type="submit" class="save-btn hover-btn">Add Country</button>
										</form>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-lg-6 col-md-6">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h4><b>Country List</b></h4>
								</div>
								<div class="card-body-table px-3">
									<div class="table-responsive">
										<table class="table ucp-table table-hover">
											<thead>
												<tr>
													<th style="width:60px">ID</th>
													<th>Country</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>

												<tr>
													<td>1</td>
													<td>India</td>
													<td class="action-btns">
                                                        <a href="add_country.php?edit=1" class="edit-btn"><i class="fas fa-edit"></i></a>
														<a href="add_country.php?delete=1" class="edit-btn"><i class="fas fa-trash"></i></a>
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
	<script src="js/validation.js"></script>
</body>

</html>