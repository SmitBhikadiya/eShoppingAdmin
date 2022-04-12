<?php
session_start();
require("./handler/productHandler.php");
require("./handler/categoryHandler.php");
$productH = new ProductHandler();
$categoryH = new CategoryHandler();
$msg = '';
$error = false;
$btn = "Add";

if (isset($_GET["edit"])) {
	// $result = product$obj->getColorById($_GET["edit"]);
	// if (count($result) < 1) {
	//     $_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
	//     header("Location: product_color.php");
	// }
	$btn = "Edit";
}

if (isset($_SESSION["result"])) {
	$error = $_SESSION["result"]["error"];
	$msg = $_SESSION["result"]["msg"];
	unset($_SESSION["result"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description-gambolthemes" content="" />
	<meta name="author-gambolthemes" content="" />
	<title>AP MART - Admin</title>
	<link href="css/styles.css" rel="stylesheet" />
	<link href="css/admin-style.css" rel="stylesheet" />
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="../../../cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/froala_editor.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/froala_style.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/code_view.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/colors.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/emoticons.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/image_manager.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/image.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/line_breaker.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/table.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/char_counter.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/video.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/fullscreen.css" />
	<link rel="stylesheet" href="vendor/froala_editor_3.1.1/css/plugins/file.css" />
	<link rel="stylesheet" href="../../../cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css" />
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
					<h2 class="mt-30 page-title"><?= $btn ?> Products</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item">
							<a href="index.php">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
							<a href="products.php">Products</a>
						</li>
						<li class="breadcrumb-item active"><?= $btn ?> Product</li>
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
						<div class="col-lg-10 col-md-10">
							<div class="card card-static-2 mb-30">
								<div class="card-title-2">
									<h4><b><?= $btn ?> New Product</b></h4>
								</div>
								<div class="card-body-table px-3">
									<div class="news-content-right pd-20">
										<form action="./handler/requestHandler.php" id="formAddNewProduct" method="POST" enctype="multipart/form-data">
											<input type="hidden" name="productid" value="<?= isset($result) ? $result["id"] : '' ?>">
											<div class="form-group">
												<label class="form-label">Name*</label>
												<input type="text" name="name" class="form-control" id="pname" placeholder="Product Name" />
											</div>
											<div class="form-group">
												<label class="form-label">Description*</label>
												<textarea name="desc" class="form-control" rows="3" id="pdesc"></textarea>
											</div>
											<div class="form-group">
												<label class="form-label">Category*</label>
												<select name="category" class="form-control" id="categtory">
													<option value="0">Select Category</option>
													<?php
													$categories = $categoryH->getCategory();
													foreach ($categories as $cat) {
														$selected = '';
														if (isset($result) && $result["categoryId"] == $cat["id"]) {
															$selected = "selected";
														}
														echo "<option value='" . $cat["id"] . "' $selected>" . $cat["catName"] . "</option>";
													}
													?>
												</select>
											</div>

											<div class="form-group">
												<label class="form-label">Sub Category*</label>
												<select name="subcategory" class="form-control" id="subcategtory"></select>
											</div>

											<div class="form-group">
												<label class="form-label">Unit Price*</label>
												<input type="number" name="price" class="form-control" id="pprice" placeholder="Product Per Unit Price" />
											</div>
											<div class="form-group">
												<label class="form-label">Total Quantity*</label>
												<input type="number" name="qty" class="form-control" id="pqty" placeholder="Product Availabel Quantity" />
											</div>

											<div class="form-group">
												<label for="productcolor">Select Product Color</label>
												<select multiple name="colors[]" class="form-control" id="productcolor">
													<option value="1">Magenta</option>
													<option value="2">Pink</option>
													<option value="3">Red</option>
													<option value="4">Lavender</option>
													<option value="5">Blue</option>
												</select>
											</div>

											<div class="form-group">
												<label for="productsize">Select Product Size</label>
												<select multiple name="sizes[]" class="form-control" id="productsize">
													<option value="1">XXS</option>
													<option value="2">XS</option>
													<option value="3">S</option>
													<option value="4">XL</option>
													<option value="5">XXL</option>
												</select>
											</div>

											<div class="form-group">
												<label class="form-label">Product Images*</label>
												<input type="file" class="form-control" name="file[]" accept=".jpg, .jpeg, .png" id="pimages" multiple />
											</div>
											<button class="save-btn hover-btn" type="submit" name="<?= $btn ?>Product" value="<?= $btn ?>Product">
												<?= $btn ?> New Product
											</button>
										</form>
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
	<script type="text/javascript" src="../../../cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
	<script type="text/javascript" src="../../../cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/froala_editor.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/align.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/code_beautifier.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/code_view.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/colors.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/emoticons.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/draggable.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/font_size.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/font_family.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/image.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/file.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/image_manager.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/line_breaker.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/link.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/lists.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/paragraph_format.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/paragraph_style.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/video.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/table.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/url.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/entities.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/char_counter.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/inline_style.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/save.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/fullscreen.min.js"></script>
	<script type="text/javascript" src="vendor/froala_editor_3.1.1/js/plugins/quote.min.js"></script>
	<script src="js/validation.js"></script>
	<script>
		(function() {
			new FroalaEditor("#edit", {
				zIndex: 10,
			});
		})();
	</script>
</body>

</html>