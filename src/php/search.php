 <?php 
include("hello.php");


echo "Items for sale:<br>";
$stmt = $conn->prepare("SELECT U.title, U.itemid, U.price FROM Item  U WHERE U.status='listed' OR U.status='pending' ");
$stmt->execute();
$result = $stmt->get_result();
echo "number of results".$result->num_rows."<br>";
foreach( $result as $row) {

echo "<a href=\"detailed.php?id=".$row["itemid"]."\">". $row["title"]."</a>".$row["price"]."<br>";


}


echo "<a href=\"/home.php\"> my home page </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/login.php\"> logout </a>        &nbsp; &nbsp; &nbsp; &nbsp;       ";
echo "<a href=\"/search.php\"> search for items to buy </a>";


?>