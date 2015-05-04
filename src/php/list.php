




 <?php 
include("hello.php");


session_start();
if (isset($_GET["id"]) ){
$stmt = $conn->prepare("SELECT U.title,U.itemtype,U.itemcondition, U.status, U.pickup, U.shippingcost, U.description, U.price FROM Item  U WHERE  itemid=?");
$stmt->bind_param("i",$_GET["id"]);
$stmt->execute();
$stmt->bind_result($title,$itemtype, $itemcondition, $status, $pickup, $shippingcost, $description, $price);
//echo "number of results".$result->num_rows."<br>";
while($stmt->fetch()) {

echo '<html>
<body>
<form method="POST" action="list.php">';
echo "item:". $title. "<br>";
echo '<input type="hidden" name="title" value="'.$title.'"/><br>';
echo 'description<input type="textarea" name="description" value="'. $description . "\"/><br>";
echo 'type:<select name="itemtype"><br>
 <option value="New"'; if ($itemtype == "New"){ echo "selected";} echo' > New </option>
 <option value="Used"' ; if ($itemtype == "Used"){echo "selected";} echo'> Used </option>
 </select><br>';
echo 'condition:<select name="itemcondition"><br>
 <option value="Excellent"'; if ($itemcondition == "Excellent"){ echo "selected";} echo' > Excellent </option>
 <option value="Good"' ; if ($itemcondition == "Good"){echo "selected";} echo'> Good  </option>
 <option value="Average"'; if ($itemcondition == "Average"){ echo "selected";} echo' > Average </option>
 <option value="Poor"' ; if ($itemcondition == "Poor"){echo "selected";} echo'> Poor </option>
 </select><br>';
echo 'status:<select name="status"><br>
 <option value="listed"'; if ($status == "listed"){ echo "selected";} echo' > active </option>
 <option value="sold"' ; if ($status == "sold"){echo "selected";} echo'> inactive </option>
 </select><br>';
echo 'pickup offered:<select name="pickup"><br>
 <option value="1"'; if ($pickup == "1"){ echo "selected";} echo' > y </option>
 <option value="0"' ; if ($pickup == "0"){echo "selected";} echo'> n </option>
 </select><br>';
echo 'price<input type="text" name="price" value="'. $price. "\"/><br>";
echo 'shipping cost<input type="text" name="shippingcost" value="'. $shippingcost . "\"/><br>";
echo '<input type="submit" value="list" />
</form>';
echo "<a href=\"/home.php\"> home </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
}
}
else if (isset($_POST["title"])){
$stmt = $conn->prepare("INSERT INTO Item(title, pickup,  price, shippingcost, description, itemowner, itemtype, itemcondition) 
VALUES (?, ?, ?,  ?,  ?, ?,?,?) ON DUPLICATE KEY UPDATE pickup=?, price=?, shippingcost=?, description=?, status=?, itemtype=?, itemcondition=?");
$stmt->bind_param("siddssssiddssss", $_POST["title"],$_POST["pickup"], $_POST["price"], $_POST["shippingcost"], $_POST["description"] ,$_SESSION["user"],$_POST["itemtype"],$_POST["itemcondition"], $_POST["pickup"], $_POST["price"], $_POST["shippingcost"], $_POST["description"],$_POST["status"], $_POST["itemtype"],$_POST["itemcondition"]);
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
type:<select name="itemtype"><br>
 <option value="New" > New </option>
 <option value="Used"> Used </option>
 </select><br>
echo condition:<select name="itemcondition"><br>
 <option value="Excellent" > Excellent </option>
 <option value="Good"> Good  </option>
 <option value="Average"> Average </option>
 <option value="Poor"> Poor </option>
 </select><br>
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