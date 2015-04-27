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
$result = $stmt->get_result();
echo "number of results".$result->num_rows."<br>";
foreach( $result as $row) {
echo '<html>
<body>
<form method="POST" action="personal.php">';
echo "Shipping Address: <br>";
echo '<input type="text" name="street" value="'.$row["street"].'"/><br>';
echo '<input type="text" name="city" value="'.$row["city"].'"/><br>';
echo '<input type="text" name="state" value="'.$row["state"].'"/><br>';
echo '<input type="text" name="zip" value="'.$row["zip"].'"/><br>';
echo 'Card info: <br>';
echo 'type:<input type="text" name="ctype" value="'.$row["ctype"].'"/><br>';
echo 'card #<input type="text" name="card" value="'. $row["card"] . "\"/><br>";
echo 'billing name<input type="text" name="cardholder" value="'. $row["cardholder"]. "\"/><br>";
echo 'exp date<input type="text" name="expdate" value="'. $row["expDate"] . "\"/><br>";
echo 'Billing Address:';
echo '<input type="text" name="bstreet" value="'.$row["street2"].'"/><br>';
echo '<input type="text" name="bcity" value="'.$row["city2"].'"/><br>';
echo '<input type="text" name="bstate" value="'.$row["state2"].'"/><br>';
echo '<input type="text" name="bzip" value="'.$row["zip2"].'"/><br>';
echo 'Bank Account:';
echo '<input type="text" name="number" value="'.$row["number"].'"/><br>';
echo '<input type="text" name="routing" value="'.$row["routing"].'"/><br>';
echo '<input type="submit" value="update" />
</form>';
echo "<a href=\"/home.php\"> home </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}
}
