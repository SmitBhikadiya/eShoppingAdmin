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
					<h2 class="mt-30 page-title">Orders</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="pending_orders.php">Orders</a></li>
						<li class="breadcrumb-item active">Order View</li>
					</ol>
					<div class="row">
						<div class="col-xl-12 col-md-12">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h2 class="title1458">Invoice</h2>
									<span class="order-id">Order #ORDR-123456</span>
								</div>
								<div class="invoice-content">
									<div class="row">
										<div class="col-lg-6 col-sm-6">
											<div class="ordr-date">
												<b>Order Date :</b> 29 May 2020
											</div>
											<div class="ordr-date">
												<b>Client Name :</b> Sam Curran
											</div>
											<div class="ordr-date">
												<b>Client No :</b> 9067117191
											</div>
										</div>
										<div class="col-lg-6 col-sm-6">
											<div class="ordr-date right-text">
												<b>Order Address :</b><br>
												#0000, St No. 8,<br>
												Shahid Karnail Singh Nagar,<br>
												MBD Mall,<br>
												Frozpur road,<br>
												Ludhiana,<br>
												141001<br>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="card card-static-2 mb-30 mt-30">
												<div class="card-title-2">
													<h4><b>Order List</b></h4>
												</div>
												<div class="card-body-table">
													<div class="table-responsive">
														<table class="table ucp-table table-hover">
															<thead>
																<tr>
																	<th style="width:130px">#</th>
																	<th>Item</th>
																	<th>Item Color</th>
																	<th>Item Size</th>
																	<th style="width:150px" class="text-center">Price</th>
																	<th style="width:150px" class="text-center">Qty</th>
																	<th style="width:100px" class="text-center">Total</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>1</td>
																	<td>
																		<a href="#">Men T-shirt</a>
																	</td>
																	<td>Green</td>
																	<td>XL</td>
																	<td class="text-center">$15</td>
																	<td class="text-center">1</td>
																	<td class="text-center">$15</td>
																</tr>
																<tr>
																	<td>2</td>
																	<td><a href="#">Men Jeans</a></td>
																	<td>Black</td>
																	<td>L</td>
																	<td class="text-center">$12</td>
																	<td class="text-center">1</td>
																	<td class="text-center">$12</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-7"></div>
										<div class="col-lg-5">
											<div class="order-total-dt">
												<div class="order-total-left-text">
													Sub Total
												</div>
												<div class="order-total-right-text">
													$27
												</div>
											</div>
											<div class="order-total-dt">
												<div class="order-total-left-text">
													Delivery Fees
												</div>
												<div class="order-total-right-text">
													$0
												</div>
											</div>
											<div class="order-total-dt">
												<div class="order-total-left-text fsz-18">
													Total Amount
												</div>
												<div class="order-total-right-text fsz-18">
													$27
												</div>
											</div>
										</div>
										<div class="col-lg-7"></div>
										<div class="col-lg-5">
										<div class="select-status">
												<label for="status">Status*</label>
												<div class="input-group">
													<select id="status" name="status" class="custom-select">
														<option value="1">Completed</option>
														<option value="2">Cancelled</option>
													</select>
													<div class="input-group-append">
														<button class="status-btn hover-btn" type="submit">Submit</button>
													</div>
												</div>
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