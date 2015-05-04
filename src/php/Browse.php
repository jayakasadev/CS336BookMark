<link type="text/css" rel="stylesheet" href="../css/browse_style.css">
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */
session_start();
include "../html/Header.html";

if(isset($_SESSION['username'])){
    echo "<script type='text/javascript' src='../js/headermodifiers/iteminfohead.js'></script>";
} else {
    $_SESSION['itemid'] = $_GET['itemid'];
    echo "<script type='text/javascript' src='../js/headermodifiers/altiteminfohead.js'></script>";
}
//print_r($_SESSION);

?>
<div class="headline jumbotron">
    <div class="container">
        <h1 align="center">Browse Items Available At Your School</h1>
    </div>
</div>

<?php
include "../html/Footer.html";
?>
