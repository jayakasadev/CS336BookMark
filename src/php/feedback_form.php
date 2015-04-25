<link rel="stylesheet" href="../css/Feedback_style.css">

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 * Date: 4/19/2015
 * Time: 3:12 AM
 */

#feedback_form.php
#header
include ("../html/Header.html");

//Check for submission
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Minimal form validation
    if(isset($_POST['submit']) && !empty($_POST['name']) &&  !empty($_POST['university']) && !empty($_POST['email']) && !empty($_POST['comments'])){
        $name = $_POST['name'];
        $university = $_POST['university'];
        $email = $_POST['email'];
        $comment = $_POST['comments'];

        $to = "kasa288@gmail.com";
        $subject = "Feedback From BookMark(et.)";

        //mail($to, $subject, $comment . ' from ' . $email);
    }
}
?>

<div class="jumbotron">
    <div class = "container">
            <?php
            if(isset($_POST['submit']) && !empty($_POST['name']) &&  !empty($_POST['university']) && !empty($_POST['email']) && !empty($_POST['comments'])){
                echo "<h1>Thanks!<h4>We will look into your concerns and get back to you at {$_POST['email']}.<br/>Have a Great Day!</h4></h1>";

                //clear the post, makes it not sticky
                $_POST = array();
            }
            else if(isset($_POST['submit']) && empty($_POST['name']) &&  empty($_POST['university']) && empty($_POST['email']) && empty($_POST['comments'])){
                echo "<h1>Feedback</br><h4 class='error'>Please go back and fill out the Feedback form correctly and completely. Thank you!</h4></h1>";
            }
            else{
                echo "<h1>Feedback</br><h4>We want to hear back from you!</h4></h1>";
            }
            ?>
    </div>
</div>
<div class="infoinput">
    <div class = "container input">
        <div class="form">
            <form action="../php/feedback_form.php" method="post">
                <h3 class align="center">Enter Your Information and Comments Below</h3>
                <fieldset class="fields container">
                    <p>
                    <div class="input-group col-lg-12">
                        <input type="text" class="form-control" name="name" placeholder="Name" aria-describedby="basic-addon1" value="<?php if(isset($_POST['name'])) echo $_POST['name'];?>">
                    </div>
                    </p>
                    <p>
                    <div class="input-group col-lg-12">
                        <input type="text" class="form-control" placeholder="University" name="university" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['university'])) echo $_POST['university'];?>"/>
                    </div>
                    </p>
                    <p>
                    <div class="input-group col-lg-12">
                        <input type="email" class="form-control" placeholder="Email" name="email" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>"/>
                    </div>
                    </p>
                    <p>
                        <textarea name = "comments" class="form-control status-box" rows="3" placeholder="Comments"><?php if(isset($_POST['comments'])) echo $_POST['comments'];?></textarea>
                    </p>
                </fieldset>
                <p class = "submitbutton" align="center">
                    <input type="submit" class="btn btn-default" name = "submit" value="Submit"/>
                </p>
            </form>
        </div>
    </div>
</div>

<?php
    #footer file
    include ("../html/Footer.html");
?>



