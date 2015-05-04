<?php include("hello.php");


if (isset($_POST["user"])){
$stmt = $conn->prepare("INSERT INTO University(universityname) 
VALUES (?) ");
$stmt->bind_param("s", $_POST["universityname"]);
$result =$stmt->execute();
echo $stmt->error;
$stmt = $conn->prepare("INSERT INTO User(username, password, first_name, last_name, email, universityid) VALUES (?,?, ?,?, ?, (SELECT University.universityid FROM University WHERE University.universityname=?))");
$stmt->bind_param("ssssss",$_POST["user"], $_POST["pass"], $_POST["first"], $_POST["last"], $_POST["email"], $_POST["universityname"]);
$stmt->execute();
echo $stmt->error;
if ($stmt->error == NULL){
session_start();
$_SESSION["user"]=$_POST["user"];
echo "account created ";
echo "<a href=\"/home.php\"> see your listed items </a>               ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}




}
 ?>