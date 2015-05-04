<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */
session_start();
require "login_func.inc.php";

//safety check
if(!isset($_SESSION['username'])){
    redirect_user("Login.php");
}
else {
    require "mysqlconnection.php";
    $username = $_SESSION['username'];

    if (isset($_GET['itemid'])) {



        //$username = "lkasa";
        $itemid = $_GET['itemid'];

        //echo $username . "\n";
        //echo $seller . "\n";
        //echo $itemid . "\n";
        //echo $price . "\n";

        $q = "delete from cart where itemid = '$itemid' and viewer = '$username';";

        //run query
        $r = @mysqli_query($dbc, $q);
    }
    else{
        $q = "delete from cart where viewer = '$username';";

        //run query
        $r = @mysqli_query($dbc, $q);
    }
    mysqli_close($dbc);
    redirect_user("Cart.php");
}

//print_r($_GET)
?>
