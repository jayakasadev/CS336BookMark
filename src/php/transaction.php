 <?php 
include("hello.php");


session_start();
if (isset($_GET["id"]) ){
$stmt = $conn->prepare("SELECT * FROM Transaction  U, Item I, Address A WHERE  transaction_id=? AND U.itemid=I.itemid AND U.addid=A.addid");
$stmt->bind_param("i",$_GET["id"]);
$stmt->execute();
$result = $stmt->get_result();
echo "number of results".$result->num_rows."<br>";
foreach( $result as $row) {

echo '<html>
<body>
<form method="POST" action="transaction.php">';
echo "item:". $row["title"]. "<br>";
echo '<input type="hidden" name="tid" value="'.$row["transaction_id"].'"/><br>';
echo 'description'. $row["description"] . "<br>";
echo "itemtype:".$row["itemtype"]."<br>";
echo "condition:". $row["itemcondition"]. "<br>";
echo 'status &nbsp;'.$row["status"] .'<br>';
echo 'pickup requested &nbsp;'; if ($row["pickupselected"] ==0){ echo 'no'; } else { echo 'yes'; } echo '<br>';
echo 'price'. $row["price"]. "<br>";
echo 'shipping cost '. $row["shippingcost"] . "<br>";
if ($row["pickupselected"] =='0') {
echo "<br><b>Shipping Address:</b> <br>";
echo 'Street:'.$row["street"].'<br>';
echo 'City:'.$row["city"].'<br>';
echo 'State:'.$row["state"].'<br>';
echo 'Zip:'.$row["zip"].'<br>';


}
if ($_SESSION["user"]==$row["seller"]) {
echo 'tracking/pickup info<input type="text" name="deliveryinfo" value="'. $row["deliveryinfo"] ."\"\><br>";
echo '<input type="submit" value="update" />
</form>';
echo "<a href=\"/home.php\"> home </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}else if ($_SESSION["user"] == $row["buyer"]){

echo 'tracking/pickup info'. $row["deliveryinfo"];
echo "<a href=\"/home.php\"> home </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}

}
}
else if (isset($_POST["tid"])){
$stmt = $conn->prepare("UPDATE Transaction
SET deliveryinfo=? WHERE Transaction.transaction_id=?");
$stmt->bind_param("si", $_POST["deliveryinfo"], $_POST["tid"]);
$result =$stmt->execute();

echo $stmt->error;
if ($stmt->error == NULL){
echo "update successful";
echo "<a href=\"/home.php\"> see your listed items </a>               ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}}else{
echo'<html>
<body>
please login >';
echo "<a href=\"/login.php\"> login </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}
?>