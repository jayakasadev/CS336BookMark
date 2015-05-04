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
    $itemid= $_GET['itemid'];

    $q = "select itemid, special from item where itemid='$itemid';";

    echo $q;

    $r1 = @mysqli_query($dbc, $q);

    if($r1 && mysqli_num_rows($r1) > 0) {
        while($row = mysqli_fetch_row($r1)) {
            $type = $row[1];
            $itemid = $row[0];

            echo "<h1>TEST</h1>";

            $q9 = "delete from item where itemid = '$itemid';";
            //echo "NORMAL ". $q1;
            $r9 = @mysqli_query($dbc, $q9);

            if($type == "Electronic"){
                $q10 = "delete from electronics where itemid = '$itemid';";
                //echo "ELEC " . $q1;
                $r10 = @mysqli_query($dbc, $q10);
            }
            else if($type == "Book") {
                $q11 = "delete from book where itemid = '$itemid';";
                //echo "Book " . $q1;
                $r11 = @mysqli_query($dbc, $q11);
            }
        }
    }
    mysqli_close($dbc);
    redirect_user("Account.php");
}

//print_r($_GET)
?>
