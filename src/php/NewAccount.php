<link rel="stylesheet" href="../css/newaccount_style.css">

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */
session_start();

include "../html/Header.html";

//main submit conditional
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //for processiong login
    require ('NewAccount_Func.php');

    //connect to db
    require ('mysqlconnection.php');

    //check login
    list($check, $data) = check_account($dbc, $_POST['username'], $_POST['password'], $_POST['confirm'], $_POST['university'], $_POST['firstname'], $_POST['lastname'],  $_POST['email']);

    //echo $check;
    //everything is ok
    if($check){


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

//print_r($_SESSION);

?>
<script type="text/javascript" src="../js/headermodifiers/newuserhead.js"></script>

<div class="jumbotron">
    <div class = "container">
        <?php
        require "login_func.inc.php";

        //if no cookie is present
        if(isset($_POST['submit']) && isset($_SESSION['username'])){
            //need functions
            redirect_user();

            //echo $_SESSION['username'];
            //echo $_SESSION['university'];
        }
        elseif(isset($_POST['submit']) && isset($errors) && !empty($errors)) {

            //error handling code here
            foreach ($errors as $msg){
                echo "<h4>- $msg</h4>";
            }
        }
        else {
            echo "<h1>New Account</h1>";
        }
        ?>
    </div>
</div>

<div class="infoinput">
    <div class = "container input">
        <form action="../php/NewAccount.php" method="post">
            <h2 class align="center">Enter Your Information and Comments Below</h2>
            <fieldset class="fields container">
                <div class="row">
                    <p>
                    <div class="input col-lg-5">
                        <input type="text" class="form-control" name="username" placeholder="Username" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
                        <input type="password" class="form-control" name="password" placeholder="Password" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>">
                        <input type="password" class="form-control" name="confirm" placeholder="Confirm Password" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['confirm'])) echo $_POST['confirm'];?>">
                        <input type="text" class="form-control" name="university" placeholder="University" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['university'])) echo $_POST['university'];?>">
                        <input type="text" class="form-control" name="firstname" placeholder="First Name" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['firstname'])) echo $_POST['firstname'];?>">
                        <input type="text" class="form-control" name="lastname" placeholder="Last Name" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['lastname'])) echo $_POST['lastname'];?>">
                        <input type="email" class="form-control" name="email" placeholder="Email" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>">
                    </div>
                    </p>
                </div>
            </fieldset>
            <p class = "submitbutton" align="center">
                <input type="submit" class="btn btn-default" name = "submit" value="Submit"/>
            </p>
        </form>
    </div>
</div>

<?php
include ("../html/Footer.html");
?>
