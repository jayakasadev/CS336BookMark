<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 * Date: 4/19/2015
 * Time: 3:12 AM
 */
//validate the name
if(!empty($_REQUEST['name'])){
    $name = $_REQUEST['name'];
}
else{
    $name = NULL;
    echo '<p class = "error">You forgot to enter your name!</p>';
}

//validate the university
if(!empty($_REQUEST['university'])){
    $university = $_REQUEST['university'];
}
else{
    $university = NULL;
    echo '<p class = "error">You forgot to enter your university\'s name!</p>';
}

//validate the email
if(!empty($_REQUEST['email'])){
    $email = $_REQUEST['email'];
}
else{
    $email = NULL;
    echo '<p class = "error">You forgot to enter your email!</p>';
}

//validate the comment
if(!empty($_REQUEST['comments'])){
    $comment = $_REQUEST['comments'];
}
else{
    $comment = NULL;
    echo '<p class = "error">You forgot to enter your comment!</p>';
}

//if everything is ok, print this
if($name && $university && $email && $comment) {
    echo "Thank you for your feedback, $name";
}
else{
    echo '<p class = "error">Please go back and fill out the Feedback form correctly and completely. Thank you! </p>';
}

?>
