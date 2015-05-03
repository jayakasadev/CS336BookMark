 <?php 
include("hello.php");
if (isset($_POST["user"])){
$query = "SELECT U.username FROM User  U WHERE U.username='fd546' AND U.password='apple'";
$stmt = $conn->prepare("SELECT U.username FROM User  U WHERE U.username=? AND U.password=?");
$stmt->bind_param("ss", $_POST["user"], $_POST["pass"]);
$stmt->execute();
//$result = $stmt->get_result();
$stmt->store_result();
echo $stmt->num_rows;
if ($stmt->num_rows ==0){

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
echo " logged in as: ". $_SESSION["user"];
echo "<br><b>My listings</b><form method=\"POST\" action=\"home.php\"> <select name=\"status\">
<option  value=\"\"> all </option>
 <option value=\"listed\" > active </option>
 <option value=\"sold\"> inactive </option>

 </select><input type=\"submit\" value=\"update\"> </form>";
 if (isset($_POST["status"]) && ($_POST["status"] !='')){
$stmt = $conn->prepare("SELECT itemid, title, price FROM Item  U WHERE U.itemowner=? AND U.status=?");
$stmt->bind_param("ss", $_SESSION["user"], $_POST["status"]);
}else{
$stmt = $conn->prepare("SELECT itemid, title, price FROM Item  U WHERE U.itemowner=?");
$stmt->bind_param("s", $_SESSION["user"]);

}
$stmt->execute();
//$result = $stmt->get_result();
$stmt->bind_result($itemid, $title, $price);
echo "<table>";
while( $stmt->fetch()) {

echo "<tr><td><a href=\"list.php?id=".$itemid."\">". $title."</a></td><td>".$price."</td></tr>";


}
echo "</table>";
echo "<br><b>My sold items:</b><br>";
$stmt = $conn->prepare("SELECT U.transaction_id, I.title, U.totalprice FROM Transaction  U, Item I WHERE U.seller=?  AND U.itemid=I.itemid");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$stmt->bind_result($transaction_id, $title, $totalprice);
echo "<table>";
while( $stmt->fetch()) {

echo "<tr><td><a href=\"transaction.php?id=".$transaction_id."\">". $title."</a></td><td>".$totalprice."</td></tr>";


}
echo "</table>";
echo "<br><b>Repeat selling Listings:</b>";
$stmt = $conn->prepare("SELECT U.transaction_id, I.title, I.price, COUNT(*) as sales FROM Transaction  U, Item I WHERE U.seller=?  AND U.itemid=I.itemid GROUP BY U.itemid HAVING COUNT(*) >1");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$stmt->bind_result($transaction_id, $title, $price, $sales);
echo "<table>";
echo "<tr><td><b>title</b></td><td><b>price</b></td>&nbsp;<td><b> # of times sold</b></td></tr>";
while( $stmt->fetch()) {

echo "<tr><td><a href=\"transaction.php?id=".$transaction_id."\">". $title."</a></td><td>".$price."</td>&nbsp;<td>". $sales. "</td></tr>";


}
echo "</table>";

echo "</table>";
echo "<br> <b>Items Purchased from Repeat Sellers </b>";
$stmt = $conn->prepare("SELECT U.transaction_id, I.title, U.totalprice,U.seller FROM Transaction  U, Item I WHERE U.buyer=?  AND U.itemid=I.itemid GROUP BY U.seller HAVING COUNT(*) >1");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$stmt->bind_result($transaction_id, $title, $totalprice, $seller);
echo "<table>";
echo "<tr><td><b>title</b></td><td><b>price</b></td>&nbsp;<td><b> seller</b></td></tr>";
while($stmt->fetch()) {

echo "<tr><td><a href=\"transaction.php?id=".$transaction_id."\">". $title."</a></td><td>".$totalprice."</td>&nbsp;<td>". $seller."</td></tr>";


}
echo "</table>";
echo "<br> <b>My purchases:</b><br>";
$stmt = $conn->prepare("SELECT U.transaction_id, I.title, U.totalprice FROM Transaction  U, Item I  WHERE U.buyer=? AND U.itemid=I.itemid ");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$stmt->bind_result($transaction_id, $title, $totalprice);
echo "<table>";
while( $stmt->fetch()) {

echo "<tr><td><a href=\"transaction.php?id=".$transaction_id."\">". $title."</a></td><td>".$totalprice."</td></tr>";


}
echo "</table>";
echo "<br><b>Other users who have used same credit card(s) as me:</b><br>";
$stmt = $conn->prepare("SELECT DISTINCT T.buyer, C.card, C.cardtype FROM Transaction T, CreditCard C WHERE T.cardid=ANY( SELECT U.cardid FROM Transaction  U  WHERE U.buyer=? ) AND T.buyer <>? AND C.cardid=T.cardid ");
$stmt->bind_param("ss", $_SESSION["user"], $_SESSION["user"]);
$stmt->execute();
$stmt->bind_result($buyer, $card, $cardtype);
echo "<table>";
while( $stmt->fetch()) {

echo "<tr> <td> <user: &nbsp; </td><td>".$buyer."</td><td>". $cardtype ."</td><td>".$card ."</td></tr>";


}
echo "</table>";

echo "<a href=\"/list.php\"> list another item </a>     &nbsp;&nbsp; &nbsp; &nbsp;           ";
echo "<a href=\"/personal.php\"> personal info </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";

}
?>