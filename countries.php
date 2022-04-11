<?php
session_start();
require("./handler/addressHandler.php");
$address = new AddressHandler();
$countries = $address->getCountries();
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
					<h2 class="mt-30 page-title">Country</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Country</li>
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
						<div class="col-lg-12 col-md-12">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h4 style="width:100%;display: flex; justify-content: space-between;align-items: center;">
										<p><b>Country List</b></p>
										<p><a href="add_country.php" class="add-btn hover-btn">Add Country</a></p>
									</h4>
								</div>
								<div class="card-body-table px-3">
									<div class="table-responsive">
										<table class="table ucp-table table-hover">
											<thead>
												<tr>
													<th style="width:60px">ID</th>
													<th>Country</th>
													<th>Created Date</th>
													<th>Modified Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (count($countries) > 0) {
													$srno = 1;
													foreach ($countries as $country) {
												?>
														<tr>
															<td><?= $srno ?></td>
															<td><?= $country["country"] ?></td>
															<td><?= $country["createdDate"] ?></td>
															<td><?= $country["modifiedDate"] ?></td>
															<td class="action-btns">
																<a href="add_country.php?edit=<?= $country["id"] ?>" class=" edit-btn"><i class="fas fa-edit"></i></a>
																<a href="./handler/requestHandler.php?dCountry=<?= $country["id"] ?>" class="edit-btn deleteRow"><i class="fas fa-trash"></i></a>
															</td>
														</tr>
												<?php
													}
												} else {
													echo "<tr><td colspan=3>No Record Found!!</td></tr>";
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
	<script src="js/scripts.js"></script>
	<script src="js/validation.js"></script>
</body>

</html>