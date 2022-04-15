<?php
session_start();
require("./handler/orderHandler.php");
$obj = new OrderHandler();
$orders = $obj->getRecentOrders(5);
$totalPending = $obj->TotalPending();
$totalCompleted = $obj->TotalCompleted();
$totalCancelled = $obj->TotalCancelled();
$msg = '';
$error = false;
if (isset($_SESSION["result"])) {
	$error = $_SESSION["result"]["error"];
	$msg = $_SESSION["result"]["msg"];
	unset($_SESSION["result"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description-APthemes" content="AP MARTAP MART">
	<meta name="author-APthemes" content="AP MART">
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
					<h2 class="mt-30 page-title">Dashboard</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
					<div class="row d-flex justify-content-around">
						<div class="col-xl-3 col-md-6">
							<div class="dashboard-report-card purple">
								<div class="card-content">
									<span class="card-title">Order Pending</span>
									<span class="card-count"><?= $totalPending ?></span>
								</div>
								<div class="card-media">
									<i class="fab fa-rev"></i>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-md-6">
							<div class="dashboard-report-card success">
								<div class="card-content">
									<span class="card-title">ORDER Delivered</span>
									<span class="card-count"><?= $totalCompleted ?></span>
								</div>
								<div class="card-media">
									<i class="fas fa-check"></i>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-md-6">
							<div class="dashboard-report-card red">
								<div class="card-content">
									<span class="card-title">Order Cancel</span>
									<span class="card-count"><?= $totalCancelled ?></span>
								</div>
								<div class="card-media">
									<i class="far fa-times-circle"></i>
								</div>
							</div>
						</div>



						<div class="col-xl-12 col-md-12">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h4><b>Recent Orders</b></h4>
									<a href="orders.php" class="view-btn hover-btn">View All</a>
								</div>
								<div class="card-body-table px-3">
									<div class="table-responsive">
										<table class="table ucp-table table-hover">
											<thead>
											<tr>
													<th style="width:120px">SrNo.</th>
													<th style="width:100px">Client Name</th>
													<th style="width:400px">Address</th>
													<th style="width:100px">Order Date</th>
													<th style="width:100px">Order Status</th>
													<th style="width:100px">Total Quantity</th>
													<th style="width:80px">Total Bill</th>
													<th style="width:100px">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (count($orders) > 0) {
													$srno = 1;
													foreach ($orders as $order) {
												?>
														<tr>
															<td><?= $srno++ ?></td>
															<td>
																<a href="view_customer.php?view=<?= $order["userId"] ?>" target="_blank"><?= $order["username"] ?></a>
															</td>
															<td><?= $order["streetName"] . ", " . $order["city"] . ", " . $order["state"] ?></td>
															<td>
																<span class="delivery-time"><?= $order["createdDate"] ?></span>
															</td>
															<td>
																<?php
																	switch($order["orderStatus"]){
																		case 0:
																			echo "Pending";
																			break;
																		case 1;
																			echo "Delivered";
																			break;
																		case 2;
																			echo "Cancelled";
																			break;
																	}
																?>
															</td>
															<td><?= $order["totalQuantity"] ?></td>
															<td><?= $order["totalPrice"] ?></td>
															<td class="action-btns">
                                                                <a href="view_order.php?view=<?=$order["id"]?>" class="view-shop-btn" title="View"><i class="fas fa-eye"></i></a>
                                                            </td>
														</tr>
												<?php
													}
												} else {
													echo "<tr><td colspan=7>No Record Found!!</td></tr>";
												}
												?>
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
	<script src="vendor/chart/highcharts.js"></script>
	<script src="vendor/chart/exporting.js"></script>
	<script src="vendor/chart/export-data.js"></script>
	<script src="vendor/chart/accessibility.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/chart.js"></script>
</body>

</html>