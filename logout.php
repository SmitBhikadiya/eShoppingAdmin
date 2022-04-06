<?php
    session_start();
    unset($_SESSION["adminlogin"]);
    header("Location: signin.php");
?>