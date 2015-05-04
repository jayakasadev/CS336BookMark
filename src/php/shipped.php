<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

session_start();
require "login_func.inc.php";

//safety check
if(!isset($_SESSION['username'])){
    redirect_user();
}
//delete cookies
else{
    if(isset($_GET['itemid'])){
        require "mysqlconnection.php";
        $itemid = $_GET['itemid'];
        $q = "update transaction set shipped='Yes' where itemid ='$itemid';";
        //echo $q;
        //run query
        $r = @mysqli_query($dbc, $q);
        redirect_user('Sold.php');
    }
}
redirect_user('Sold.php');
?>
