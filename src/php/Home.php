 <?php 
include("hello.php");
if (isset($_POST["user"])){
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
echo "logged in as: ". $_SESSION["user"];
echo "<br><b>My listings</b><br> <form method=\"POST\" action=\"home.php\"> <select name=\"status\">
<option > all </option>
 <option value=\"listed\" > active </option>
 <option value=\"sold\"> inactive </option>

 </select><input type=\"submit\" value=\"update\"> </form>";
 if (isset($_POST["status"]) && ($_POST["status"] !='')){
$stmt = $conn->prepare("SELECT * FROM Item  U WHERE U.itemowner=? AND U.status=?");
$stmt->bind_param("ss", $_SESSION["user"], $_POST["status"]);
}else{
$stmt = $conn->prepare("SELECT * FROM Item  U WHERE U.itemowner=?");
$stmt->bind_param("s", $_SESSION["user"]);

}
$stmt->execute();
$result = $stmt->get_result();
echo "<table>";
foreach( $result as $row) {

echo "<tr><td><a href=\"list.php?id=".$row["itemid"]."\">". $row["title"]."</a></td><td>".$row["price"]."</td></tr><br>";


}
echo "</table>";
echo "<br><b>My sold items:</b><br>";
$stmt = $conn->prepare("SELECT * FROM Transaction  U, Item I WHERE U.seller=?  AND U.itemid=I.itemid");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result();
echo "<table>";
foreach( $result as $row) {

echo "<tr><td><a href=\"transaction.php?id=".$row["transaction_id"]."\">". $row["title"]."</a></td><td>".$row["price"]."</td></tr><br>";


}
echo "</table>";
echo "<br><b>Repeat selling Listings:</b><br>";
$stmt = $conn->prepare("SELECT *, COUNT(*) as sales FROM Transaction  U, Item I WHERE U.seller=?  AND U.itemid=I.itemid GROUP BY U.itemid HAVING COUNT(*) >1");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result();
echo "<table>";
foreach( $result as $row) {

echo "<tr><td><a href=\"transaction.php?id=".$row["transaction_id"]."\">". $row["title"]."</a></td><td>".$row["price"]."</td>&nbsp;<td>". $row["sales"]. "</td></tr><br>";


}
echo "</table>";

echo "</table>";
echo "<br> <b>Repeat sellers for purchased items:</b><br>";
$stmt = $conn->prepare("SELECT * ,COUNT(*) as sales FROM Transaction  U, Item I WHERE U.buyer=?  AND U.itemid=I.itemid GROUP BY U.seller HAVING COUNT(*) >1");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result();
echo "<table>";
foreach( $result as $row) {

echo "<tr><td><a href=\"transaction.php?id=".$row["transaction_id"]."\">". $row["title"]."</a></td><td>".$row["price"]."</td>&nbsp;<td>". $row["sales"]."</td></tr><br>";


}
echo "</table>";
echo "<br> <b>My purchases:</b><br>";
$stmt = $conn->prepare("SELECT * FROM Transaction  U, Item I  WHERE U.buyer=? AND U.itemid=I.itemid ");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result();
echo "<table>";
foreach( $result as $row) {

echo "<tr><td><a href=\"transaction.php?id=".$row["transaction_id"]."\">". $row["title"]."</a></td><td>".$row["price"]."</td></tr><br>";


}
echo "</table>";
echo "<br><b>Other users who have used same credit card(s) as me:</b><br>";
$stmt = $conn->prepare("SELECT DISTINCT T.buyer, C.card, C.cardtype FROM Transaction T, CreditCard C WHERE T.cardid=ANY( SELECT U.cardid FROM Transaction  U  WHERE U.buyer=? ) AND T.buyer <>? AND C.cardid=T.cardid ");
$stmt->bind_param("ss", $_SESSION["user"], $_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result();
echo "<table>";
foreach( $result as $row) {

echo "<tr> <td> <user: &nbsp; </td><td>".$row["buyer"]."</td><td>". $row["cardtype"] ."</td><td>".$row["card"] ."</td></tr> <br>";


}
echo "</table>";

echo "<a href=\"/list.php\"> list another item </a>     &nbsp;&nbsp; &nbsp; &nbsp;           ";
echo "<a href=\"/personal.php\"> personal info </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";

}
?>