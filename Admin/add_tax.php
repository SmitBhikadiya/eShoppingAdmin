<?php
session_start();
require("./handler/taxHandler.php");
require("./handler/addressHandler.php");
$taxH = new TaxHandler();
$addressH = new AddressHandler();
$countries = $addressH->getAllCountry();

// checking update request
$btn = "Add";
if (isset($_GET["edit"])) {
    $result = $taxH->getTaxById($_GET["edit"]);
    if (count($result) < 1) {
        $_SESSION["result"] = ["msg" => "Invalid Request", "error" => true];
        header("Location: ./service_tax.php");
    }
    $btn = "Edit";
    $states = $addressH->getStatesByCountryId($result["countryId"]);
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description-gambolthemes" content="">
    <meta name="author-gambolthemes" content="">
    <title>eShopper - Admin</title>
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
                    <h2 class="mt-30 page-title"><?= $btn ?> Service Tax</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="service_tax.php">Service Tax</a></li>
                        <li class="breadcrumb-item active"><?= $btn ?> Tax</li>
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

                    <div class="row justify-content-between">
                        <div class="col-lg-5 col-md-5">
                            <div class="card card-static-2 mt-30 mb-30">
                                <div class="card-title-2">
                                    <h4 style="width:100%;display: flex; justify-content: space-between;align-items: center;">
                                        <p><b><?= $btn ?> Service Tax</b></p>
                                    </h4>
                                </div>
                                <div class="card-body-table px-3">
                                    <form action="./handler/requestHandler.php" id="formAddTax" method="POST">
                                        <input type="hidden" name="taxId" value="<?= isset($result) ? $result["id"] : '' ?>">
                                        <div class="card-body-table px-3">
                                            <div class="news-content-right pd-20">
                                                <div class="form-group">
                                                    <label class="form-label">Tax*</label>
                                                    <input type="number" id="addtax" name="tax" min=1 class="form-control" placeholder="Enter Tax" value="<?= isset($result) ? $result["tax"] : "" ?>" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Select Country*</label>
                                                    <select class="form-control" name="country" id="countrylist">
                                                        <option value="0">Select Country</option>
                                                        <?php
                                                        foreach ($countries as $country) {
                                                            $selected = '';
                                                            if (isset($result) && $result["countryId"] == $country["id"]) {
                                                                $selected = "selected";
                                                            }
                                                            echo "<option value='" . $country["id"] . "' $selected>" . $country["country"] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Select State*</label>
                                                    <select class="form-control" name="state" id="statelist">
                                                        <?php
                                                        foreach ($states as $state) {
                                                            $selected = '';
                                                            if ($result["stateId"] == $state["id"]) {
                                                                $selected = "selected";
                                                            }
                                                            echo "<option value='" . $state["id"] . "' $selected>" . $state["state"] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <button class="save-btn hover-btn mb-3" type="submit" name="<?= $btn ?>Tax" value="<?= $btn ?>Tax">
                                                    <?= $btn ?> Tax
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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