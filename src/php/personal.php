<?php include("hello.php");

session_start();
if (isset($_POST["street"])){
updatepersonal($conn);
$stmt = $conn->prepare("INSERT INTO BankAccount(number, routing) 
VALUES (?, ?) ");
$stmt->bind_param("ii", $_POST["number"],$_POST["routing"]);
$result =$stmt->execute();
echo $stmt->error;
$stmt = $conn->prepare("UPDATE User U SET U.bankid=(SELECT BankAccount.bankid FROM BankAccount WHERE BankAccount.number=? AND BankAccount.routing=? ) WHERE U.username=?");
$stmt->bind_param("iis",$_POST["number"], $_POST["routing"], $_SESSION["user"]);
$stmt->execute();
echo $stmt->error;
if ($stmt->error == NULL){

echo "update ";
echo "<a href=\"/home.php\"> home </a>            &nbsp;&nbsp;   ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}




}else if (isset($_SESSION["user"]) ){
$stmt = $conn->prepare("SELECT  A.street, A.city, A.state, A.zip,C.cardtype As ctype, C.card, C.cardholder, C.expDate,A2.street As street2, A2.city as city2, A2.state as state2, A2.zip as zip2,B.number, B.routing FROM User U LEFT JOIN BankAccount B ON U.bankid=B.bankid LEFT JOIN Address A ON U.addid=A.addid
LEFT JOIN CreditCard C ON U.cardid=C.cardid LEFT JOIN Address A2 ON C.address=A2.addid WHERE U.username=?");
 

$stmt->bind_param("s",$_SESSION["user"]);
$stmt->execute();
$stmt->bind_result($street, $city, $state, $zip, $ctype, $card, $cardholder, $expDate, $street2, $city2, $state2, $zip2, $number, $routing);
//echo "number of results".$result->num_rows."<br>";
while( $stmt->fetch()) {
echo '<html>
<body>
<form method="POST" action="personal.php">';

echo "Shipping Address: <br>";
echo 'street<input type="text" name="street" value="'.$street.'"/><br>';
echo 'city<input type="text" name="city" value="'.$city.'"/><br>';
echo 'state<input type="text" name="state" value="'.$state.'"/><br>';
echo 'zip<input type="text" name="zip" value="'.$zip.'"/><br>';

echo 'type:<input type="text" name="ctype" value="'.$ctype.'"/><br>';
echo 'card #<input type="text" name="card" value="'. $card . "\"/><br>";
echo 'billing name<input type="text" name="cardholder" value="'. $cardholder. "\"/><br>";
echo 'exp date<input type="text" name="expdate" value="'. $expDate . "\"/><br>";
echo 'Billing Address:';

echo 'street<input type="text" name="bstreet" value="'.$street2.'"/><br>';
echo 'city<input type="text" name="bcity" value="'.$city2.'"/><br>';
echo 'state<input type="text" name="bstate" value="'.$state2.'"/><br>';
echo 'zip<input type="text" name="bzip" value="'.$zip2.'"/><br>';

echo 'Bank Account:';
echo '<input type="text" name="number" value="'.$number.'"/><br>';
echo '<input type="text" name="routing" value="'.$routing.'"/><br>';
echo '<input type="submit" value="update" />
</form>';
echo "<a href=\"/home.php\"> home </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}
}
