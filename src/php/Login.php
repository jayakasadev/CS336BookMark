<link type="text/css" rel="stylesheet" href="../css/login_style.css">
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 *
 * This page will print any errors associated with logging in and creates entire login page
 */

session_start();

include "../html/Header.html";

//main submit conditional
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //for processiong login
    require ('login_func.inc.php');

    //connect to db
    require ('mysqlconnection.php');

    //check login
    list($check, $data) = check_login($dbc, $_POST['username'], $_POST['password']);

    //everything is ok
    if($check){
        //set cookies
        $_SESSION['username'] = $data['username'];
        $_SESSION['university'] = $data['universityname'];
    }
    //issues
    else{
        $errors = $data;
    }

    //close connection
    mysqli_close($dbc);
}

//build body of page below
?>
<script type="text/javascript" src="../js/headermodifiers/loginhead.js"></script>

<div class="jumbotron">
    <div class = "container">
        <?php
        //if no cookie is present
        if(isset($_POST['submit']) && isset($_SESSION['username'])){
            //need functions
            redirect_user();
        }
        elseif(isset($_POST['submit']) && isset($errors) && !empty($errors)) {

                //error handling code here
                foreach ($errors as $msg){
                    echo "<h4>- $msg</h4>";
                }
        }
        else {
            echo "<h1>Login</h1>";
        }
        ?>
    </div>
</div>
<div class="infoinput">
    <div class = "container input">
        <form action="../php/Login.php" method="post">
                <fieldset class="fields container">
                    <div class="row">
                        <div class="input essential col-lg-5">
                            <input type="text" class="form-control" name="username" placeholder="Username" aria-describedby="basic-addon1"
                                   value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input col-lg-5">
                            <input type="password" class="form-control" name="password" placeholder="Password" aria-describedby="basic-addon1"
                                   value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>">
                        </div>
                    </div>
                </fieldset>
                <p class = "submitbutton">
                    <input type="submit" class="btn btn-default" name = "submit" value="Login"/>
                </p>
            </form>
    </div>
</div>
<?php

include "../html/Footer.html"

?>
