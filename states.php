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
					<h5 class="modal-title" id="exampleModalLabel">Add State</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card-body-table px-3">
						<form id="formAddState" action="add_state.php">
							<div class="form-group">
								<label class="form-label">Select Country*</label>
								<select class="form-control" id="statelist">
									<option value="1">India</option>
									<option value="2">US</option>
								</select>
							</div>
							<div class="form-group">
								<label class="form-label">State Name*</label>
								<input type="text" class="form-control" id="statename" placeholder="State name">
							</div>
							<button type="submit" style="width: 100%;" class="save-btn hover-btn">Add State</button>
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
			require("./handler/addressHandler.php");
			$address = new AddressHandler();
			$states = $address->getStates();
			?>
		</div>
		<div id="layoutSidenav_content">
			<main>
				<div class="container-fluid">
					<h2 class="mt-30 page-title">State</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item"><a href="add_city.php">Address</a></li>
						<li class="breadcrumb-item active">State</li>
					</ol>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h4 style="width:100%;display: flex; justify-content: space-between;align-items: center;">
										<p><b>State List</b></p>
										<p><a href="#" class="add-btn hover-btn" data-toggle="modal" data-target="#exampleModal">Add State</a></p>
									</h4>
								</div>
								<div class="card-body-table px-3">
									<div class="table-responsive">
										<table class="table ucp-table table-hover">
											<thead>
												<tr>
													<th style="width:60px">ID</th>
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
												foreach ($states as $state) {
												?>
													<tr>
														<td><?= $srno++ ?></td>
														<td><?= $state["state"] ?></td>
														<td><?= $state["country"] ?></td>
														<td><?= $state["createdDate"] ?></td>
														<td><?= $state["modifiedDate"] ?></td>
														<td class="action-btns">
															<a data-toggle="modal" data-target="#exampleModal" class="edit-btn"><i class="fas fa-edit"></i></a>
															<a href="add_state.php?delete=<?= $state["id"] ?>" class="edit-btn"><i class="fas fa-trash"></i></a>
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
</body>

</html>