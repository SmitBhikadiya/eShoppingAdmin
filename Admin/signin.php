<?php
    session_start();

    if(isset($_SESSION['adminlogin'])){
        header("Location: index.php");
    }

    require_once("./handler/adminuserHandler.php");
    $error = '';
    if(isset($_SESSION["error"])){
        $error = $_SESSION["error"];
        unset($_SESSION["error"]);
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

<body class="bg-sign">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header card-sign-header">
                                    <h3 class="text-center font-weight-light my-4">Sign In</h3>
                                </div>
                                <div class="card-body">
                                    <form id="formSignin" action="./handler/requestHandler.php" method="POST">
                                        <?php 
                                            if($error!=''){
                                            ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?=$error?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                            <?php
                                            }
                                        ?>
                                        <div class="form-group">
                                            <label class="form-label" for="email">Email*</label>
                                            <input class="form-control py-3" id="email" name="email" type="email" placeholder="Enter email address" value="<?=(isset($_COOKIE['email']))? $_COOKIE['email'] : ''?>" />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="password">Password*</label>
                                            <input class="form-control py-3" id="password" name="password" type="password" placeholder="Enter password" value="<?=(isset($_COOKIE['password']))? $_COOKIE['password'] : ''?>" />
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" id="remember" name="remember" type="checkbox" <?=(isset($_COOKIE['remember']))? 'checked' : ''?> />
                                                <label class="custom-control-label" for="remember">Remember password</label>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" name="signin" class="btn btn-sign hover-btn">Sign In Now</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/validation.js"></script>
</body>

</html>