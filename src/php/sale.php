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

    if (isset($_GET['cardid'])) {
        //$username = "lkasa";
        $cardid = $_GET['cardid'];

        //save address
        $q = "select seller, itemid from cart where viewer = '$username';";

        //echo $q;
        //run query
        $r = @mysqli_query($dbc, $q);

        $q2 = "select transaction_id from transaction ORDER BY transaction_id desc limit 1;";

        //echo $q2;

        $r2 = @mysqli_query($dbc, $q2);
        $row2 = mysqli_fetch_row($r2);

        if(mysqli_num_rows($r2) > 0) {
            $transactionid = $row2[0];
            $transactionid += 1;
        }
        else{
            $transactionid = 1;
        }

        //echo $transactionid;
        $addressid = $_GET['addressid'];

        while($row = mysqli_fetch_row($r)){
            $seller = $row[0];
            $itemid = $row[1];

            //save address
            $q3 = "insert ignore into transaction (transaction_id, buyer, seller, itemid, date, addressid) values ('$transactionid', '$username', '$seller', '$itemid', utc_timestamp(), '$addressid');";

            //echo $q3;
            //run query
            $r3 = @mysqli_query($dbc, $q3);
        }
        //echo $card;
        $q4 = "insert ignore into creditcard (card, transaction_id, username, cardholder, cardtype, expDate, addressid) values ((select card from creditcard where cardid = '$cardid';), '$transactionid', '$username', '$cardholder', '$cardtype', '$expDate', '$billingid');";

        //echo $q4;
        //run query
        $r4 = @mysqli_query($dbc, $q4);

        $q5 = "delete from cart where viewer = '$username';";

        //echo $q5;
        //run query
        $r5 = @mysqli_query($dbc, $q5);
    }
    mysqli_close($dbc);
    redirect_user();
}

//print_r($_GET)
?>
