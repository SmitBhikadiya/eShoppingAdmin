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
					<h2 class="mt-30 page-title">Customers</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Customers</li>
					</ol>
					<nav class="navbar navbar-light  justify-content-end">
						<form class="form-inline">
							<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
							<button class="status-btn hover-btn my-2 my-sm-0" type="submit">Search</button>
						</form>
					</nav>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h4><b>All Customers<b></h4>
								</div>
								<div class="card-body-table px-3">
									<div class="table-responsive">
										<table class="table ucp-table table-hover">
											<thead>
												<tr>
													<th style="width:60px">ID</th>
													<th>UserName</th>
													<th>FirstName</th>
													<th>LastName</th>
													<th>Gender</th>
													<th>Email</th>
													<th>Mobile No.</th>
													<th>Phone</th>
													<!-- <th>Action</th> -->
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td><a href="view_customer.php?id=1">Sam123</a></td>
													<td>Sam</td>
													<td>Curran</td>
													<td>Male</td>
													<td>sam@gmail.com</td>
													<td>+911234567890</td>
													<td>-</td>

													<!-- <td class="action-btns">
															<a href="view_customer.html" class="view-shop-btn" title="View"><i class="fas fa-eye"></i></a>
															
															<a href="#" class="delete-btn" title="Edit"><i class="fas fa-trash-alt"></i></a>
														</td> -->
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
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="js/scripts.js"></script>
</body>
<!-- Mirrored from gambolthemes.net/html-items/gambo_admin/customers.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Feb 2021 16:40:30 GMT -->

</html>