<link rel="stylesheet" href="../css/newaccount_style.css">

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 * Date: 4/22/2015
 * Time: 6:54 PM
 */

#feedback_form.php
$page_title = "Create Account";

include ("../html/Header.html");

//Check for submission
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Minimal form validation
    if(isset($_POST['submit']) && !empty($_POST['username']) &&  !empty($_POST['password']) && !empty($_POST['confirm']) && !empty($_POST['university'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $university = $_POST['university'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];
    }
}
?>

<script type="text/javascript" src="../js/headermodifiers/newuserhead.js"></script>
<div class="jumbotron">
    <div class = "container">
        <?php
        if(isset($_POST['submit']) && !empty($_POST['username']) &&  !empty($_POST['password']) && !empty($_POST['confirm']) && !empty($_POST['university'])){



            echo "<script> location.replace('../home.php'); </script>";
        }
        else if(isset($_POST['submit'])) {
            if (empty($_POST['username'])) {
                echo "<h1>Create You Account!</h1>";
                echo "<h4>You gotta have a username!</h4>>";
            } else if (strlen($_POST['username']) > 15) {
                echo "<h1>Create You Account!</h1>";
                echo "<h4>Username can't be longer than 15 letters!</h4>>";
            } else if (empty($_POST['password'])) {
                echo "<h1>Create You Account!</h1>";
                echo "<h4>You gotta have a password!</h4>>";
            } else if (strlen($_POST['password']) > 40) {
                echo "<h1>Create You Account!</h1>";
                echo "<h4>Password can't be longer than 40 letters!</h4>>";
            } else if (empty($_POST['confirm'])) {
                echo "<h1>Create You Account!</h1>";
                echo "<h4>You gotta confirm your password!</h4>>";
            } else if (($_POST['confirm']) !== $_POST['password']) {
                echo "<h1>Create You Account!</h1>";
                echo "<h4>Your passwords don't match!</h4>>";
            } else if (empty($_POST['university'])) {
                echo "<h1>Create You Account!</h1>";
                echo "<h4>You gotta tell us what school you're from!</h4>>";
            } else if (strlen($_POST['university']) > 80) {
                echo "<h1>Create You Account!</h1>";
                echo "<h4>Your passwords don't match!</h4>>";
            }
        }
        else{
            echo "<h1>Create You Account!</h1>";
        }
        ?>
    </div>
</div>

<div class="infoinput">
    <div class = "container input">
        <div class="form">
            <form action="../php/NewAccount.php" method="post">
                <h2 class align="center">Enter Your Information and Comments Below</h2>
                <fieldset class="fields container">
                    <div class="row">
                        <p>
                        <div class="input essential col-lg-5">
                            <input type="text" class="form-control" name="username" placeholder="Username" aria-describedby="basic-addon1"
                                   value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
                        </div>
                        </p>
                    </div>
                    <div class="row">
                        <p>
                        <div class="input col-lg-5">
                            <input type="password" class="form-control" name="password" placeholder="Password" aria-describedby="basic-addon1"
                                   value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>">
                        </div>
                        </p>
                    </div>
                    <div class="row">
                        <p>
                        <div class="input col-lg-5">
                            <input type="password" class="form-control" name="confirm" placeholder="Confirm Password" aria-describedby="basic-addon1"
                                   value="<?php if(isset($_POST['confirm'])) echo $_POST['confirm'];?>">
                        </div>
                        </p>
                    </div>
                    <div class="row">
                        <p>
                        <div class="input col-lg-5">
                            <input type="text" class="form-control" name="university" placeholder="University" aria-describedby="basic-addon1"
                                   value="<?php if(isset($_POST['university'])) echo $_POST['university'];?>">
                        </div>
                        </p>
                    </div>
                    <div class="row">
                        <p>
                        <div class="input col-lg-5">
                            <input type="text" class="form-control" name="firstname" placeholder="First Name" aria-describedby="basic-addon1"
                                   value="<?php if(isset($_POST['firstname'])) echo $_POST['firstname'];?>">
                        </div>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <p>
                        <div class="input col-lg-5">
                            <input type="text" class="form-control" name="lastname" placeholder="Last Name" aria-describedby="basic-addon1"
                                   value="<?php if(isset($_POST['lastname'])) echo $_POST['lastname'];?>">
                        </div>
                        </p>
                    </div>
                    <div class="row">
                        <p>
                        <div class="input col-lg-12">
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
</div>

<?php

include ("../html/Footer.html");
?>
