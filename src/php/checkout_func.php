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
    $addressid = $_GET['addressid'];
    //$username = "lkasa";
    //echo $username . "\n";
    //echo $seller . "\n";
    //echo $itemid . "\n";
    //echo $price . "\n";

    $q = "select viewer, seller, itemid from cart where viewer = '$username';";

    //run query
    $r = @mysqli_query($dbc, $q);
    if($r) {
        //echo "Ran ";
        while($row = mysqli_fetch_row($r)) {
            $buyer = $row[0];
            $seller = $row[1];
            $itemid = $row[2];

            //echo $buyer . " ";
            //echo $seller . " ";
            //echo $itemid. " ";

            $q2 = "insert into transaction (buyer, seller, itemid, date, addressid) values ('$buyer', '$seller', '$itemid', utc_timestamp(), $addressid);";

            echo $q2;

            //run query
            $r2 = @mysqli_query($dbc, $q2);
        }
        mysqli_close($dbc);
        //redirect_user("Checkout.php");
    }
    //echo "Didnt Run ";
    mysqli_close($dbc);
    //redirect_user("Home.php");
}

//print_r($_GET)
?>
