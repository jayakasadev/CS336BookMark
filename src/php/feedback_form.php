<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 * Date: 4/19/2015
 * Time: 3:12 AM
 */


#feedback_form.php
$page_title = "Feedback";
include ('../html/header.html');

//Check for submission
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Minimal form validation
    if(isset($_POST['submit']) && !empty($_POST['name']) &&  !empty($_POST['university']) && !empty($_POST['email']) && !empty($_POST['comments'])){
        $name = $_POST['name'];
        $university = $_POST['university'];
        $email = $_POST['email'];
        $comment = $_POST['comments'];
    }
}
?>
<div class="jumbotron">
    <div class = "container" id="headings">
        <h1 name = "feedback title">
            <?php
                if(isset($_POST['submit']) && !empty($_POST['name']) &&  !empty($_POST['university']) && !empty($_POST['email']) && !empty($_POST['comments'])){
                    echo "Thanks!<h4>We will look into your concerns and get back to you at {$_POST['email']}.<br/>Have a Great Day!</h4>";
                }
                else if(isset($_POST['submit']) && empty($_POST['name']) &&  empty($_POST['university']) && empty($_POST['email']) && empty($_POST['comments'])){
                    echo "Feedback</br><h4 class='error'>Please go back and fill out the Feedback form correctly and completely. Thank you!</h4>";
                }
                else{
                    echo "Feedback</br><h4>We want to hear back from you!</h4>";
                }
            ?>
        </h1>

    </div>
</div>
<div class="message">
    <p class="text-center">How was your experience with Bookmark(et.)? Fill out the form below and let us know!</p>
</div>
<div class="container">
    <div class = "input">
        <div class="form">
            <form action="../php/feedback_form.php" method="post">
                <fieldset class="fields">
                    <legend align="center">Enter Your Information and Comments Below</legend>
                    <p>
                        <div class="input-group">
                            <span class="input-group-addon">Name</span>
                            <input type="text" class="form-control" name="name" placeholder="Name" aria-describedby="basic-addon1" value="<?php if(isset($_POST['name'])) echo $_POST['name'];?>">
                        </div>
                    </p>
                    <p>
                        <div class="input-group">
                            <span class="input-group-addon">University</span>
                            <input type="text" class="form-control" name="university" placeholder="University" aria-describedby="basic-addon1"
                                   value="<?php if(isset($_POST['university'])) echo $_POST['university'];?>"/>
                        </div>
                    </p>
                    <p>
                        <div class="input-group">
                            <span class="input-group-addon">Email</span>
                            <input type="text" class="form-control" name="email" placeholder="Email" aria-describedby="basic-addon1"
                                   value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>"/>
                        </div>
                    </p>
                    <p>
                        <textarea name = "comments" class="form-control" rows="3" placeholder="Comments"><?php if(isset($_POST['comments'])) echo $_POST['comments'];?></textarea>
                    </p>
                </fieldset>
                <p align="center">
                    <input type="submit" class="btn btn-default" name = "submit" value="Submit"/>
                </p>
            </form>
        </div>
    </div>
</div>

<?php
#footer of page
include ('../html/footer.html');
?>
