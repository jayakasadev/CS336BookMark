<?php 
include("hello.php");
session_start();
if (isset($_GET["id"]) ){
$stmt = $conn->prepare("SELECT  A.street, A.city, A.state, A.zip,C.cardtype As ctype, C.card, C.cardholder, C.expDate,A2.street As street2, A2.city as city2, A2.state as state2, A2.zip as zip2,B.number, B.routing FROM User U LEFT JOIN BankAccount B ON U.bankid=B.bankid LEFT JOIN Address A ON U.addid=A.addid
LEFT JOIN CreditCard C ON U.cardid=C.cardid LEFT JOIN Address A2 ON C.address=A2.addid WHERE U.username=?");
$stmt->bind_param("s",$_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result();
echo "number of results".$result->num_rows."<br>";
$row;
foreach( $result as $rr) {$row=$rr;
}
echo '<html>
<body>
<form method="POST" action="purchase.php">';
echo "item:". $_SESSION["title"]." ". $_SESSION["price"]. "<br>";
if ($_SESSION["pickup"] == "1"){
echo 'do you want to pickup the item?:<select name="pickup"><br>
 <option value="1" > y </option>
 <option value="0"> n </option>
 </select><br>';}else{
 echo '<input type="hidden" value="0" name="pickup"/>';}
echo "Shipping Address: <br>";
echo 'street<input type="text" name="street" value="'.$row["street"].'"/><br>';
echo 'city<input type="text" name="city" value="'.$row["city"].'"/><br>';
echo 'state<input type="text" name="state" value="'.$row["state"].'"/><br>';
echo 'zip<input type="text" name="zip" value="'.$row["zip"].'"/><br>';

echo 'type:<input type="text" name="ctype" value="'.$row["ctype"].'"/><br>';
echo 'card #<input type="text" name="card" value="'. $row["card"] . "\"/><br>";
echo 'billing name<input type="text" name="cardholder" value="'. $row["cardholder"]. "\"/><br>";
echo 'exp date<input type="text" name="expdate" value="'. $row["expDate"] . "\"/><br>";
echo 'Billing Address:';

echo 'street<input type="text" name="bstreet" value="'.$row["street2"].'"/><br>';
echo 'city<input type="text" name="bcity" value="'.$row["city2"].'"/><br>';
echo 'state<input type="text" name="bstate" value="'.$row["state2"].'"/><br>';
echo 'zip<input type="text" name="bzip" value="'.$row["zip2"].'"/><br>';
echo '<input type="submit" value="purchase" />
</form>';
echo "<a href=\"/home.php\"> personal info </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
}
else if (isset($_POST["street"])){
updatepersonal($conn);
$stmt = $conn->prepare("INSERT INTO Transaction(buyer, seller, itemid, pickupselected, totalprice, cardid, bankid) 
VALUES (?, ?, ?,  ?,?,?,?) ");
$tprice;
if ($_POST["pickup"] == 1){ $tprice=$_SESSION["price"];} else{$tprice=$_SESSION["price"]+$_SESSION["shipping"];}
$stmt->bind_param("ssiidii",$_SESSION["user"],$_SESSION["itemowner"], $_SESSION["itemid"], $_POST["pickup"], $tprice, $_POST["pickup"],$_POST["pickup"]);
$result =$stmt->execute();
echo $_POST["pickup"];
echo $stmt->error;
if ($stmt->error == NULL){

echo "purchase complete";
echo "<a href=\"/home.php\"> see your listed items </a>     &nbsp;          ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}

}else{
echo'please login ';
}



?>