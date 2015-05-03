 <?php 
include("hello.php");


session_start();
if (isset($_GET["id"]) ){
$stmt = $conn->prepare("SELECT I.title, U.transaction_id, I.description,I.itemtype, I.itemcondition,I.status, U.pickupselected, U.totalprice,  A.street, A.city, A.state, A.zip, C.cardtype, C.card, U.buyer, U.seller, U.deliveryinfo FROM Transaction  U, Item I, Address A, CreditCard C WHERE  transaction_id=? AND U.itemid=I.itemid AND U.addid=A.addid AND U.cardid=C.cardid");
$stmt->bind_param("i",$_GET["id"]);
$stmt->execute();
$stmt->bind_result($title,$transaction_id, $description, $itemtype, $itemcondition, $status, $pickupselected, $totalprice, $street, $city, $state, $zip, $cardtype, $card, $buyer,$seller, $deliveryinfo);
//echo "number of results".$result->num_rows."<br>";
while( $stmt->fetch()) {

echo '<html>
<body>
<form method="POST" action="transaction.php">';
echo "item:". $title. "<br>";
echo '<input type="hidden" name="tid" value="'.$transaction_id.'"/><br>';
echo 'description'. $description . "<br>";
echo "itemtype:".$itemtype."<br>";
echo "condition:". $itemcondition. "<br>";
echo 'status &nbsp;'.$status .'<br>';
echo 'pickup requested &nbsp;'; if ($pickupselected ==0){ echo 'no'; } else { echo 'yes'; } echo '<br>';
echo 'price'. $totalprice. "<br>";


if ($pickupselected =='0') {
echo "<br><b>Shipping Address:</b> <br>";
echo 'Street:'.$street.'<br>';
echo 'City:'.$city.'<br>';
echo 'State:'.$state.'<br>';
echo 'Zip:'.$zip.'<br>';


}
if ($_SESSION["user"]==$seller) {
echo 'tracking/pickup info<input type="text" name="deliveryinfo" value="'. $deliveryinfo ."\"\><br>";
echo '<input type="submit" value="update" />
</form>';
echo "<a href=\"/home.php\"> home </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}else if ($_SESSION["user"] == $buyer){
echo 'card used :'.$cardtype.'&nbsp;'. $card. "<br>";
echo 'tracking/pickup info'. $deliveryinfo;
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