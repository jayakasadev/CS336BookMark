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
else{
    require "mysqlconnection.php";

    $username = $_SESSION['username'];
    //$username = "lkasa";
    $seller = $_GET['owner'];
    $itemid = $_GET['itemid'];
    $price = $_GET['price'];

    //echo $username . "\n";
    //echo $seller . "\n";
    //echo $itemid . "\n";
    //echo $price . "\n";

    $q = "insert into cart (viewer, seller, itemid, price) values ('$username', '$seller', '$itemid', '$price');";

    //echo $q . " ";

    //run query
    $r = @mysqli_query($dbc, $q);
    if($r) {

        $q = "select * from cart where itemid = $itemid";

        //run query
        $r = @mysqli_query($dbc, $q);

        //get the row from query
        $row = mysqli_fetch_row($r);

        echo "1." . $row[0];
        echo "TEST";

        redirect_user("Item Info.php?itemid=" . $_GET['itemid'] . "&retitle=yes1");
    }
    redirect_user("Item Info.php?itemid=" . $_GET['itemid'] . "&retitle=yes2");
}

//print_r($_GET)
?>
