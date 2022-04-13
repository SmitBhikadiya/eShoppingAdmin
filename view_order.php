<?php
session_start();
require("./handler/orderHandler.php");

if (!isset($_GET["view"])) {
	$_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
	header("Location: ./pending_orders.php");
} else {
	$obj = new OrderHandler();
	$id = (int) $_GET["view"];
	$order = $obj->getOrderById($id);
	if (count($order) < 1) {
		$_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
		header("Location: ./pending_orders.php");
	}
}

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
					<h2 class="mt-30 page-title">Order View</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="pending_orders.php">Orders</a></li>
						<li class="breadcrumb-item active">Order View</li>
					</ol>

					<?php
					if ($msg != '') {
					?>
						<div class="alert alert-<?= ($error) ? 'danger' : 'success' ?> alert-dismissible fade show" role="alert">
							<?= $msg ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
					<?php
					}
					?>

					<div class="row">
						<div class="col-xl-12 col-md-12">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h2 class="title1458">Invoice</h2>
									<span class="order-id">Order: <?= $order["id"] ?></span>
								</div>
								<div class="invoice-content">
									<div class="row">
										<div class="col-lg-6 col-sm-6">
											<div class="ordr-date">
												<b>Order Date :</b> <?= date('d, M yy', strtotime($order["createdDate"])) ?> <br>
												<b>Client Name :</b> <?= $order["username"] ?> <br>
												<b>Client Mobile :</b> <?= $order["mobile"] ?> <br>
											</div>
										</div>
										<div class="col-lg-6 col-sm-6">
											<div class="ordr-date right-text">
												<b>Order Address :</b><br>
												<?= $order["streetName"] ?>,<br>
												<?= $order["city"] ?>,<br>
												<?= $order["state"] ?><br>
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
																	<th style="width:150px" class="text-center">Unit Price</th>
																	<th style="width:150px" class="text-center">Qty</th>
																	<th style="width:100px" class="text-center">Total</th>
																</tr>
															</thead>
															<tbody>
																<?php

																$productlist = $obj->getOrderListByOrderId($id);
																if (count($productlist) > 0) {
																	$srno = 1;
																	foreach ($productlist as $prd) {
																?>
																		<tr>
																			<td><?= $srno++ ?></td>
																			<td>
																				<a href="./view_product.php?view=<?= $prd["productId"] ?>"><?= $prd["productName"] ?></a>
																			</td>
																			<td><?= $prd["productColor"] ?></td>
																			<td><?= strtoupper($prd["productSize"]) ?></td>
																			<td class="text-center">$<?= $prd["unitPrice"] ?></td>
																			<td class="text-center"><?= $prd["qunatity"] ?></td>
																			<td class="text-center">$<?= ($prd["unitPrice"] * $prd["qunatity"]) ?></td>
																		</tr>
																<?php
																	}
																} else {
																	echo "<tr><td colspan=6>No Record Found!!</td></tr>";
																}
																?>
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
													$<?= $order["totalPrice"] ?>
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
													$<?= $order["totalPrice"] ?>
												</div>
											</div>
										</div>
										<div class="col-lg-7"></div>
										<div class="col-lg-5">
											<?php
												if($order["orderStatus"]==0){
											?>
											<form action="./handler/requestHandler.php" method="POST">
												<input type="hidden" name="ordid" value="<?=$order["id"]?>">
												<div class="select-status">
													<label for="status">Status*</label>
													<div class="input-group">
														<select id="status" name="status" class="custom-select">
															<option value="1">Completed</option>
															<option value="2">Cancelled</option>
														</select>
														<div class="input-group-append">
															<button class="status-btn hover-btn" type="submit" name="orderStatus" value="orderStatus">Submit</button>
														</div>
													</div>
												</div>
											</form>
											<?php
												}
											?>
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