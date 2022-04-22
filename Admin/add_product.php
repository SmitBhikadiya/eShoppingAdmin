<?php
session_start();
require("./handler/productHandler.php");
require("./handler/categoryHandler.php");
$productH = new ProductHandler();
$categoryH = new CategoryHandler();

// checking update request
$btn = "Add";
if (isset($_GET["edit"])) {
	$result = $productH->getProductById($_GET["edit"]);
	if (count($result) < 1) {
		$_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
		header("Location: ./products.php");
	}
	$btn = "Edit";
}

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
						<div class="col-lg-8 col-md-8">
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
												<input type="text" name="name" class="form-control" id="pname" placeholder="Product Name" value="<?= (isset($result)) ? $result["productName"] : '' ?>" />
											</div>
											<div class="form-group">
												<label class="form-label">Description*</label>
												<textarea name="desc" class="form-control" rows="3" id="pdesc"><?= (isset($result)) ? $result["productDesc"] : '' ?></textarea>
											</div>
											<div class="form-group">
												<label class="form-label">Category*</label>
												<select name="category" class="form-control" id="categtory">
													<option value="0">Select Category</option>
													<?php
													$categories = $categoryH->getAllCategory();
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
												<select name="subcategory" class="form-control" id="subcategtory">
													<option value="0">Select Sub Category</option>
													<?php
													if (isset($result)) {
														$subcats = $categoryH->getSubCategoryByCategoryId($result["categoryId"]);
														foreach ($subcats as $subcat) {
															$selected = '';
															if ($subcat["id"] == $result["subCategoryId"]) {
																$selected = "selected";
															}
															echo "<option value='" . $subcat["id"] . "' $selected>" . $subcat["subCatName"] . "</option>";
														}
													}
													?>
												</select>
											</div>

											<div class="form-group">
												<label class="form-label">Unit Price*</label>
												<input type="number" name="price" class="form-control" id="pprice" placeholder="Product Per Unit Price" value="<?= (isset($result)) ? $result["productPrice"] : '' ?>" />
											</div>
											<div class="form-group">
												<label class="form-label">Total Quantity*</label>
												<input type="number" name="qty" class="form-control" id="pqty" placeholder="Product Availabel Quantity" value="<?= (isset($result)) ? $result["totalQuantity"] : '' ?>" />
											</div>
											
											<div class="form-group">
												<label class="form-label">SKU*</label>
												<input type="text" name="sku" class="form-control" id="psku" placeholder="Enter SKU" value="<?= (isset($result)) ? $result["SKU"] : '' ?>" />
											</div>

											<div class="form-group">
												<label for="productcolor">Select Product Color</label>
												<select multiple name="colors[]" class="form-control" id="productcolor">
													<?php
													$colors = $productH->getAllColor();
													$i = 0;
													$colorIds = explode(",", (isset($result)) ? $result["productColorIds"] : '');
													//print_r($colorIds);
													foreach ($colors as $color) {
														$selected = '';
														if (isset($result) && in_array($color["id"], $colorIds)) {
															$selected = "selected";
														}
														echo "<option value='" . $color["id"] . "' $selected>" . $color["colorName"] . "</option>";
														$i++;
													}
													?>
												</select>
											</div>

											<div class="form-group">
												<label for="productsize">Select Product Size</label>
												<select multiple name="sizes[]" class="form-control" id="productsize">
													<?php
													$sizes = $productH->getAllSize();
													$i = 0;
													$sizeIds = explode(",", (isset($result)) ? $result["productSizeIds"] : '');
													foreach ($sizes as $size) {
														$selected = '';
														if (isset($result) && in_array($size["id"], $sizeIds)) {
															$selected = "selected";
														}
														echo "<option value='" . $size["id"] . "' $selected>" . $size["size"] . "</option>";
														$i++;
													}
													?>
												</select>
											</div>

											<div class="form-check form-check-inline my-3">
												<?php
													$check = (isset($result)) ? (($result['isTrending']==0) ? '' : 'checked')  : '';
												?>
												<input class="form-check-input" type="checkbox" name="trending" id="ptrending" <?=$check?>>
												<label class="form-check-label" for="ptrending">
													set as trending
												</label>
											</div>

											<div class="form-group">
												<label class="form-label">Profile Image*</label>
												<div class="input-group">
													<div class="custom-file">
														<input type="hidden" name="oldimages" value="<?= isset($result) ? $result["productImages"] : "" ?>">
														<input type="file" class="custom-file-input" name="file[]" id="pimages" accept=".jpg, .jpeg, .png" aria-describedby="inputGroupFileAddon04" data-action="<?= $btn ?>" multiple>
														<label class="custom-file-label" for="pimages">Choose Image</label>
													</div>
												</div>
												<ul class="add-produc-imgs">
													<?php
													if (isset($result)) {
														$images = explode(",", $result["productImages"]);
														foreach ($images as $image) {
													?>
															<li>
																<div class="add-cate-img-1">
																	<img width='70' height='70' src="./images/product/<?= $image ?>" alt="" />
																</div>
															</li>
													<?php
														}
													}
													?>
												</ul>
											</div>

											<!-- <div class="form-group">
												<label class="form-label">Product Images*</label>
												<input type="hidden" name="oldimages" value="<?= isset($result) ? $result["productImages"] : "" ?>">
												<input type="file" class="form-control" name="file[]" accept=".jpg, .jpeg, .png" id="pimages" data-action="<?= $btn ?>" multiple />
												<ul class="add-produc-imgs">
													<?php
													if (isset($result)) {
														$images = explode(",", $result["productImages"]);
														foreach ($images as $image) {
													?>
															<li>
																<div class="add-cate-img-1">
																	<img width='70' height='70' src="./images/product/<?= $image ?>" alt="" />
																</div>
															</li>
													<?php
														}
													}
													?>
												</ul>
											</div> -->
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

		$(document).ready(function() {
			$("#pimages").on("change", function(e) {
				files_ = $(this).get(0).files;
				var html = '';
				var relPath = '';
				if (files_.length === 0) {
					html += ``;
				}
				for (i = 0; i < files_.length; i++) {
					relPath = (URL || webkitURL).createObjectURL(files_[i]);
					html += `<li>
						<div class="add-cate-img-1">
							<img width='70' height='70' src="${relPath}" alt="" />
						</div>
					</li>`;
				}
				$(".add-produc-imgs").html(html);
			});
		});
	</script>
</body>

</html>