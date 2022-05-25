<?php
session_start();
require("./handler/productHandler.php");
$obj = new ProductHandler();

// for pagination and searching
$currntPage = 1;
$showRecords = 5;
$search = '';

$currntPage = (isset($_GET["page"]) && $_GET["page"]!='') ? $_GET["page"] : $currntPage;
$showRecords = (isset($_GET["show"]) && $_GET["show"]!='') ? $_GET["show"] : $showRecords;
$search = (isset($_GET["search"]) && $_GET["search"]!='') ? $_GET["search"] : $search;

$totalRecords = $obj->TotalProducts($search);
$products = $obj->getProducts($search,(($currntPage - 1) * $showRecords), $showRecords);

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
					<h2 class="mt-30 page-title">Products</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">Products</li>
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
						<a href="add_product.php" class="add-btn hover-btn">Add New</a>
						<div class="form-inline">
							<input class="form-control mr-sm-2" type="search" placeholder="Search By Name" aria-label="Search" value="<?=$search?>">
							<button class="status-btn hover-btn my-2 my-sm-0" id="searchRec" type="submit">Search</button>
						</div>
					</nav>

					<div class="row justify-content-between">
						<div class="col-lg-12 col-md-12">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h4>
										<p><b>Product List</b></p>
									</h4>
								</div>
								<div class="card-body-table px-3">
									<div class="table-responsive">
										<table class="table ucp-table table-hover">
											<thead>
												<tr>
													<th style="width:60px">ID</th>
													<th>Image</th>
													<th>Name</th>
													<th>Price</th>
													<th>Quantity</th>
													<th>Category</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if (count($products) > 0) {
													$srno = 1;
													foreach ($products as $product) {
												?>
														<tr>
															<td><?= $product["id"] ?></td>
															<td>
																<div class="cate-img-5">
																	<?php
																	if($product["productImages"]!=''){
																		$images = explode(",", $product["productImages"]);
																	?>
																		<img width="100" height="60" src="images/product/<?= $images[0] ?>" alt="">
																	<?php
																	}else{
																		?>
																		<img width="100" height="60" style="border: 1px solid red;" title="Image not available" src="images/noimage.jpg" alt="">
																		<?php
																	}
																	?>
																</div>
															</td>
															<td><?= $product["productName"] ?></td>
															<td><?= $product["productPrice"] ?></td>
															<td><?= $product["totalQuantity"] ?></td>
															<td><?= $product["catName"] ?></td>
															<td class="action-btns">
																<a href="view_product.php?view=<?= $product["id"] ?>" class="view-shop-btn" title="View"><i class="fas fa-eye"></i></a>
																<a href="add_product.php?edit=<?= $product["id"] ?>" class="edit-btn"><i class="fas fa-edit"></i></a>&nbsp;
																<a href="./handler/requestHandler.php?dProduct=<?= $product["id"] ?>" class="edit-btn deleteRow"><i class="fas fa-trash"></i></a>
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
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="js/scripts.js"></script>
	<script src="js/validation.js"></script>
</body>

</html>