<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description-gambolthemes" content="">
	<meta name="author-gambolthemes" content="">
	<title>AP Mart - Admin</title>
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
					<h2 class="mt-30 page-title">View Profile</h2>
					<ol class="breadcrumb mb-30">
						<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
						<li class="breadcrumb-item active">View Profile</li>
					</ol>
					<div class="row">
						<div class="col-lg-4 col-md-5">
							<div class="card card-static-2 mb-30">
								<div class="card-body-table">
									<div class="shopowner-content-left text-center pd-20">
										<div class="shop_img mb-3">
											<img src="images/avatar/img-1.jpg" alt="">
										</div>
										<div class="shopowner-dt-left">
											<h4>Gambo Supermarket</h4>
											<span>Admin</span>
										</div>
										<div class="shopowner-dts">
											<div class="shopowner-dt-list">
												<span class="left-dt">Full Name</span>
												<span class="right-dt">Admin</span>
											</div>
											<div class="shopowner-dt-list">
												<span class="left-dt">Email</span>
												<span class="right-dt"><a href="https://gambolthemes.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="4621272b24292a7f727506212b272f2a6825292b">[email&#160;protected]</a></span>
											</div>
											<div class="shopowner-dt-list">
												<span class="left-dt">Phone</span>
												<span class="right-dt">+918437176189</span>
											</div>
											<div class="shopowner-dt-list">
												<span class="left-dt">Address</span>
												<span class="right-dt">Ludhiana, Punjab</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- <div class="col-lg-8 col-md-7">
								<div class="card card-static-2 mb-30">
									<div class="card-title-2">
										<h4><b>Edit Profile</b></h4>
									</div>
									<div class="card-body-table">
										<div class="news-content-right pd-20">
											<div class="row">
												<div class="col-lg-6">
													<div class="form-group mb-3">
														<label class="form-label">First Name*</label>
														<input type="text" class="form-control" value="Gambo" placeholder="Enter First Name">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group mb-3">
														<label class="form-label">Last Name*</label>
														<input type="text" class="form-control" value="Supermarket" placeholder="Enter Last Name">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group mb-3">
														<label class="form-label">Email*</label>
														<input type="email" class="form-control" value="gambol943@gmail.com" placeholder="Enter Email Address">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group mb-3">
														<label class="form-label">Phone*</label>
														<input type="text" class="form-control" value="+918437176189" placeholder="Enter Phone Number">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group mb-3">
														<label class="form-label">Profile Image*</label>
														<div class="input-group">
															<div class="custom-file">
																<input type="file" class="custom-file-input" id="profile-img" aria-describedby="inputGroupFileAddon04">
																<label class="custom-file-label" for="profile-img">Choose Image</label>
															</div>
														</div>
														<div class="add-cate-img-1">
															<img src="images/avatar/img-1.jpg" alt="">
														</div>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group mb-3">
														<label class="form-label">Address*</label>
														<textarea class="text-control" placeholder="">Ludhiana, Punjab</textarea>
													</div>
												</div>
												<div class="col-lg-12">
													<button class="save-btn hover-btn" type="submit">Save Changes</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> -->
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
<!-- Mirrored from gambolthemes.net/html-items/gambo_admin/edit_profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Feb 2021 16:39:42 GMT -->

</html>