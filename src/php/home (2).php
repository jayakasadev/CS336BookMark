 <?php 
include("hello.php");
if (isset($_POST["user"])){
echo "user".$_POST["user"]. $_POST["pass"];
$query = "SELECT U.username FROM User  U WHERE U.username='fd546' AND U.password='apple'";
$stmt = $conn->prepare("SELECT U.username FROM User  U WHERE U.username=? AND U.password=?");
$stmt->bind_param("ss", $_POST["user"], $_POST["pass"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result != FALSE && mysqli_num_rows($result)==0){

echo "invalid user/password";
}else{
session_start();
$_SESSION["user"] = $_POST["user"];
process($conn);
}
}else{
process($conn);
}
function process($conn){

echo 'welcome-login successful';
session_start();

echo "My listed items:<br>";
$stmt = $conn->prepare("SELECT * FROM Item  U WHERE U.itemowner=? ");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result();
foreach( $result as $row) {

echo "<a href=\"list.php?id=".$row["itemid"]."\">". $row["title"]."</a>".$row["price"]."<br>";


}
echo "My sold items:<br>";
$stmt = $conn->prepare("SELECT * FROM Transaction  U, Item I WHERE U.seller=?  AND U.itemid=I.itemid");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result();
foreach( $result as $row) {

echo "<a href=\"transaction.php?id=".$row["transaction_id"]."\">". $row["title"]."</a>".$row["price"]."<br>";


}

echo "My purchases:<br>";
$stmt = $conn->prepare("SELECT * FROM Transaction  U, Item I  WHERE U.buyer=? AND U.itemid=I.itemid ");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result();
foreach( $result as $row) {

echo "<a href=\"transaction.php?id=".$row["transaction_id"]."\">". $row["title"]."</a>".$row["price"]."<br>";


}

echo "<a href=\"/list.php\"> list another item </a>     &nbsp;&nbsp; &nbsp; &nbsp;           ";
echo "<a href=\"/personal.php\"> personal info </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";

}
?>