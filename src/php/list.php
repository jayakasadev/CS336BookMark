




 <?php 
include("hello.php");


session_start();
if (isset($_GET["id"]) ){
$stmt = $conn->prepare("SELECT * FROM Item  U WHERE  itemid=?");
$stmt->bind_param("i",$_GET["id"]);
$stmt->execute();
$result = $stmt->get_result();
echo "number of results".$result->num_rows."<br>";
foreach( $result as $row) {

echo '<html>
<body>
<form method="POST" action="list.php">';
echo "item:". $row["title"]. "<br>";
echo '<input type="hidden" name="title" value="'.$row["title"].'"/><br>';
echo 'description<input type="textarea" name="description" value="'. $row["description"] . "\"/><br>";
echo "itemtype:".$row["itemtype"]."<br>";
echo "condition:". $row["itemcondition"]. "<br>";
echo 'status:<select name="status"><br>
 <option value="listed"'; if ($row["status"] == "listed"){ echo "selected";} echo' > active </option>
 <option value="sold"' ; if ($row["status"] == "sold"){echo "selected";} echo'> inactive </option>
 </select><br>';
echo 'pickup offered:<select name="pickup"><br>
 <option value="1"'; if ($row["pickup"] == "1"){ echo "selected";} echo' > y </option>
 <option value="0"' ; if ($row["pickup"] == "0"){echo "selected";} echo'> n </option>
 </select><br>';
echo 'price<input type="text" name="price" value="'. $row["price"]. "\"/><br>";
echo 'shipping cost<input type="text" name="shippingcost" value="'. $row["shippingcost"] . "\"/><br>";
echo '<input type="submit" value="list" />
</form>';
echo "<a href=\"/home.php\"> home </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
}
}
else if (isset($_POST["title"])){
$stmt = $conn->prepare("INSERT INTO Item(title, pickup,  price, shippingcost, description, itemowner) 
VALUES (?, ?, ?,  ?,  ?, ?) ON DUPLICATE KEY UPDATE pickup=?, price=?, shippingcost=?, description=?, status=?");
$stmt->bind_param("siddssiddss", $_POST["title"],$_POST["pickup"], $_POST["price"], $_POST["shippingcost"], $_POST["description"] ,$_SESSION["user"], $_POST["pickup"], $_POST["price"], $_POST["shippingcost"], $_POST["description"],$_POST["status"]);
$result =$stmt->execute();

echo $stmt->error;
if ($stmt->error == NULL){
echo "update successful";
echo "<a href=\"/home.php\"> see your listed items </a>               ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
}}else{
echo'<html>
<body>
<form method="POST" action="list.php">
title
<input type="text" name="title"/><br>
pickup offered:<select name="pickup"><br>
 <option value="1" > y </option>
 <option value="0"> n </option>
 </select>
 price<input type="text" name="price"/><br>
  shipping cost<input type="text" name="shippingcost"/><br>
  description<input type="textarea" name="description"/><br>
<input type="submit" value="list" />



</form>';
echo "<a href=\"/home.php\"> home </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
}
?>