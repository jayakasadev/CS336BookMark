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
    //setcookie('username'. '', time()-3600, '/', '', 0, 0);
    //setcookie('first_name'. '', time()-3600, '/', '', 0, 0);

    if(isset($_SESSION['university'])){
        $_SESSION = array();
        session_destroy();
        setcookie('PHPSESSID', '',  time()-3600, '/', '', 0, 0);

        redirect_user('../index.php');
    }
}
?>
