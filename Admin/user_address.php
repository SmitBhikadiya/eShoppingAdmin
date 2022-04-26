<?php
session_start();
require("./handler/CustomerHandler.php");
$obj = new CustomerHandler();

// for pagination and searching
$currntPage = 1;
$showRecords = 5;
$search = '';
if (isset($_GET["page"])) {
	$currntPage = $_GET["page"];
	$showRecords = isset($_GET["show"]) ? $_GET["show"] : $showRecords;
	$search = isset($_GET["search"]) ? $_GET["search"] : $search;
}

// for sorting
$sortBy = "all";
if(isset($_GET["sortBy"])){
	$sortBy = $_GET["sortBy"];
}

$totalRecords = $obj->TotalUserAddress($search, $sortBy);
$addresses = $obj->getUserAddress($search, (($currntPage - 1) * $showRecords), $showRecords, $sortBy);

// for error or success message
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
					<h2 class="mt-30 page-title">User Address</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="customers.php">Users</a></li>
						<li class="breadcrumb-item active">User Address</li>
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

					<nav class="navbar navbar-light bg-light justify-content-between">
						<div>
							<select name="sortBy" class="form-control" id="sortBy">
								<option value="all" <?=($sortBy=="all")?"selected":""?>>All</option>
								<option value="shipping" <?=($sortBy=="shipping")?"selected":""?>>Shipping</option>
								<option value="billing" <?=($sortBy=="billing")?"selected":""?>>Billing</option>
							</select>
						</div>
						<div class="form-inline">
							<input class="form-control mr-sm-2" type="search" placeholder="Search By Name" aria-label="Search" value="<?= $search ?>">
							<button class="status-btn hover-btn my-2 my-sm-0" id="searchRec" type="submit">Search</button>
						</div>
					</nav>

					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h4><b>All Address</b></h4>
								</div>
								<div class="card-body-table px-3">
									<div class="table-responsive">
										<table class="table ucp-table table-hover">
											<thead>
												<tr>
													<th style="width:60px">ID</th>
													<th>UserName</th>
													<th>AddressType</th>
													<th>Street</th>
													<th>Country</th>
													<th>State</th>
													<th>City</th>
													<th>Modified Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (count($addresses) > 0) {
													$srno = 1;
													foreach ($addresses as $add) {
												?>
														<tr>
															<td><?= $add["id"] ?></td>
															<td><?= $add["username"] ?></a></td>
															<td><?= ($add["addressType"]==0)? "Billing" : "Shipping"?></td>
															<td><?= $add["streetname"] ?></td>
															<td><?= $add["country"] ?></td>
															<td><?= $add["state"] ?></td>
															<td><?= $add["city"] ?></td>
															<td><?= $add["modifiedDate"] ?></td>
															<td class="action-btns">
																<a href="./handler/requestHandler.php?dUserAddress=<?= $add["id"] ?>" class="delete-btn deleteRow" title="Edit"><i class="fas fa-trash-alt"></i></a>
															</td>
														</tr>
												<?php
													}
												} else {
													echo "<tr><td colspan=6>No Record Found!!</td></tr>";
												}
												?>
											</tbody>
										</table>
										<div class="div-pagination mt-3 d-flex justify-content-between">
											<div class="page-select">
												show&nbsp;
												<select style="height: 35px; width:60px; border:1px solid #0056b3; color:#0056b3; border-radius:4px" name="" id="show-record">
													<?php
													foreach ([5, 10, 25, 50] as $rec) {
														$selected = '';
														if ($rec == $showRecords) {
															$selected = "selected";
														}
														echo "<option value='$rec' $selected>$rec</option>";
													}
													?>

												</select>&nbsp;&nbsp;entries, Total Records: <span id="totalrecords"><?= $totalRecords ?></span>
											</div>
											<div>
												<nav aria-label="Page navigation example">
													<ul class="pagination">
														<li class="page-item">
															<a class="page-link" aria-label="Previous" data-action="left">
																<span aria-hidden="true">&laquo;</span>
																<span class="sr-only">Previous</span>
															</a>
														</li>
														<?php
														$temp = $currntPage+1;
														$totalPage = ceil($totalRecords / $showRecords);
														if($totalPage==1){
															echo '<li class="page-item active"><a class="page-link">1</a></li>';
														}else if($totalPage==2){
															echo '<li class="page-item '.(($currntPage==1 || $currntPage=='' || $currntPage==0)?"active":"").'"><a class="page-link">1</a></li>';
															echo '<li class="page-item '.(($currntPage==2)?"active":"").'"><a class="page-link">2</a></li>';
														}else if($totalPage>=3){
															for($i=$temp-1;$i<($temp+2);$i++){
																if($i>$totalPage){
																	break;
																}else{
																	echo '<li class="page-item '.(($i==$currntPage)?"active":"").'"><a class="page-link">'.$i.'</a></li>';
																}
															}
														}

														?>

														<li class="page-item">
															<a class="page-link" aria-label="Next" data-action="right">
																<span aria-hidden="true">&raquo;</span>
																<span class="sr-only">Next</span>
															</a>
														</li>
													</ul>
												</nav>
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
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="js/scripts.js"></script>
</body>
<!-- Mirrored from gambolthemes.net/html-items/gambo_admin/customers.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Feb 2021 16:40:30 GMT -->

</html>