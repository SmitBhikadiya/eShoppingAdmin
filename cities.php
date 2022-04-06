<?php
require("./handler/addressHandler.php");
$address = new AddressHandler();
$cities = $address->getCities();
$countries = $address->getCountries();
$msg = '';
$error = true;
if (isset($_POST["addCity"])) {
	$countryid = $_POST["country"];
	$stateid = $_POST["state"];
	$city = strtolower(trim($_POST["city"]));
	$result = $address->addCity($countryid, $stateid, $city);
	if ($result == "") {
		$error = false;
		$msg = "New City Added Successfully";
	} else {
		$msg = $result;
	}
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

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add City</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card-body-table px-3">
						<form id="formAddCity" action="add_city.php" method="POST">
							<div class="form-group">
								<label class="form-label">Select Country*</label>
								<select class="form-control" name="country" id="countrylist">
									<option value="0">Select Country</option>
									<?php
									foreach ($countries as $country) {
										echo "<option value='" . $country["id"] . "'>" . $country["country"] . "</option>";
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label class="form-label">Select State*</label>
								<select class="form-control" name="state" id="statelist">
								</select>
							</div>
							<div class="form-group">
								<label class="form-label">City Name*</label>
								<input type="text" class="form-control" name="city" id="cityname" placeholder="City name">
							</div>
							<button type="submit" class="save-btn hover-btn" name="addCity" value="addCity">Add City</button>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div id="layoutSidenav">
		<div id="layoutSidenav_nav">
			<?php
			include_once("./includes/sidebar.php");
			?>
		</div>
		<div id="layoutSidenav_content">
			<main>
				<div class="container-fluid">
					<h2 class="mt-30 page-title">City</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item"><a href="add_city.php">Address</a></li>
						<li class="breadcrumb-item active">City</li>
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
										<p><b>Cities</b></p>
										<p><a href="#" class="add-btn hover-btn" data-toggle="modal" data-target="#exampleModal">Add City</a></p>
									</h4>
								</div>
								<div class="card-body-table px-3">
									<div class="table-responsive">
										<table class="table ucp-table table-hover">
											<thead>
												<tr>
													<th style="width:60px">SrNo.</th>
													<th>City</th>
													<th>State</th>
													<th>Country</th>
													<th>Created Date</th>
													<th>Updated Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$srno = 1;
												foreach ($cities as $city) {
												?>
													<tr>
														<td><?= $srno++ ?></td>
														<td><?= $city["city"] ?></td>
														<td><?= $city["state"] ?></td>
														<td><?= $city["country"] ?></td>
														<td><?= $city["createdDate"] ?></td>
														<td><?= $city["modifiedDate"] ?></td>
														<td class="action-btns">
															<a data-toggle="modal" data-target="#exampleModal" class="edit-btn"><i class="fas fa-edit"></i></a>
															<a href="add_city.php?delete=<?= $city["id"] ?>" class="edit-btn"><i class="fas fa-trash"></i></a>
														</td>
													</tr>
												<?php
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
	<script src="js/address.js"></script>
</body>

</html>