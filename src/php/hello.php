<?php
$conn =new mysqli('localhost','root','jakutu', 'csell') or die($conn->connect_error());
$query = "set autocommit=0";
$result = $conn->query( $query);
function printresult($result){
foreach( $result->fetch_all() as $row) {
foreach ( $row as $item){
echo " ".$item;
}
echo "<br>";

}
}
function updatepersonal($conn){

$stmt = $conn->prepare("INSERT INTO Address(street, city, state, zip) 
VALUES (?, ?, ?,  ?) ");
$stmt->bind_param("sssi", $_POST["street"],$_POST["city"], $_POST["state"], $_POST["zip"]);
$result =$stmt->execute();
echo $stmt->error;
$stmt = $conn->prepare("UPDATE User U SET U.addid=(SELECT Address.addid FROM Address WHERE Address.street=? AND Address.zip=? ) WHERE U.username=?");
$stmt->bind_param("sis",$_POST["street"], $_POST["zip"], $_SESSION["user"]);
$stmt->execute();
echo $stmt->error;
$stmt = $conn->prepare("INSERT INTO Address(street, city, state, zip) 
VALUES (?, ?, ?,  ?) ");
$stmt->bind_param("sssi", $_POST["bstreet"],$_POST["bcity"], $_POST["bstate"], $_POST["bzip"]);
$result =$stmt->execute();
echo $stmt->error;
$stmt = $conn->prepare("SELECT Address.addid FROM Address WHERE Address.street=?  AND Address.zip=?");
$stmt->bind_param("si",$_POST["bstreet"], $_POST["bzip"]);
$stmt->execute();
echo $stmt->error;
$stmt->bind_result($addid);
//echo "number of results".$result->num_rows."<br>";
$rr;
while ($stmt->fetch()){
$rr=$addid;}
echo $rr;
$stmt = $conn->prepare("INSERT INTO CreditCard(card,cardtype, cardholder, expdate, address) 
VALUES (?, ?, ?,  ?,?) ON DUPLICATE KEY UPDATE cardtype=?, cardholder=?, expdate=?, address=?");
$stmt->bind_param("isssisssi",$_POST["card"],$_POST["ctype"], $_POST["cardholder"], $_POST["expdate"], $rr,$_POST["ctype"],$_POST["cardholder"], $_POST["expdate"], $rr);
$stmt->execute();
echo $stmt->error;
$stmt = $conn->prepare("UPDATE User U SET U.cardid=(SELECT C.cardid FROM CreditCard C WHERE C.card=? AND C.cardtype=? ) WHERE U.username=?");
$stmt->bind_param("iss",$_POST["card"], $_POST["ctype"], $_SESSION["user"]);
$stmt->execute();
echo $stmt->error;














}
?> 