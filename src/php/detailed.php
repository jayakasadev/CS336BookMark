 <?php 
include("hello.php");

session_start();
echo "Detailed info:<br>";
$stmt = $conn->prepare("SELECT U.itemid, U.itemowner, U.title, U.description, U.itemtype, U.itemcondition, U.pickup, U.price, U.shippingcost, C.universityname FROM Item  U, User S, University C  WHERE (U.status='listed' OR U.status='pending') AND itemid=? AND U.itemowner=S.username AND S.universityid=C.universityid");
$stmt->bind_param("i",$_GET["id"]);
$stmt->execute();
$stmt->bind_result($itemid, $itemowner, $title, $description, $itemtype, $itemcondition, $pickup, $price, $shippingcost, $universityname);
//echo "number of results".$result->num_rows."<br>";
while( $stmt->fetch()) {

echo "seller:".$itemowner."<br>";
echo "item:". $title. "<br>";
echo "description:". $description . "<br>";
echo "itemtype:".$itemtype."<br>";
echo "condition:". $itemcondition. "<br>";
echo "pickup offered:". $pickup . "<br>";
echo "price:". $price. "<br>";
echo "shipping cost:". $shippingcost . "<br>";
echo "university:". $universityname . "<br>";
$_SESSION["title"]=$title;
$_SESSION["itemid"]=$itemid;
$_SESSION["price"]=$price;
$_SESSION["pickup"]=$pickup;
$_SESSION["itemowner"]=$itemowner;
$_SESSION["shipping"]=$shippingcost;
}

echo "<a href=\"purchase.php?id=".$itemid."\">buy item</a> &nbsp; &nbsp;";
echo "<a href=\"/home.php\"> home </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";

?>