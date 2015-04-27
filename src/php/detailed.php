 <?php 
include("hello.php");

session_start();
echo "Detailed info:<br>";
$stmt = $conn->prepare("SELECT * FROM Item  U WHERE (U.status='listed' OR U.status='pending') AND itemid=?");
$stmt->bind_param("i",$_GET["id"]);
$stmt->execute();
$result = $stmt->get_result();
echo "number of results".$result->num_rows."<br>";
foreach( $result as $row) {

echo "seller:".$row["itemowner"]."<br>";
echo "item:". $row["title"]. "<br>";
echo "description:". $row["description"] . "<br>";
echo "itemtype:".$row["itemtype"]."<br>";
echo "condition:". $row["itemcondition"]. "<br>";
echo "pickup offered:". $row["pickup"] . "<br>";
echo "price:". $row["price"]. "<br>";
echo "shipping cost:". $row["shippingcost"] . "<br>";
$_SESSION["title"]=$row["title"];
$_SESSION["itemid"]=$row["itemid"];
$_SESSION["price"]=$row["price"];
$_SESSION["pickup"]=$row["pickup"];
$_SESSION["itemowner"]=$row["itemowner"];
$_SESSION["shipping"]=$row["shippingcost"];
}

echo "<a href=\"purchase.php?id=".$row["itemid"]."\">buy item</a> &nbsp; &nbsp;";
echo "<a href=\"/home.php\"> home </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";

?>