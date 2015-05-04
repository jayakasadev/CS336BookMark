<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */
session_start();
include "../html/Header.html";

if(isset($_SESSION['username'])){
    echo "<script type='text/javascript' src='../js/headermodifiers/searchhead.js'></script>";
}
else if(isset($_SESSION['university'])){
    echo "<script type='text/javascript' src='../js/headermodifiers/altsearchhead.js'></script>";
}
//print_r($_SESSION);
?>

<?php
include "../html/Footer.html";
?>
