<link type="text/css" rel="stylesheet" href="../css/iteminfo_style.css">
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

session_start();
include "../html/Header.html";

if(isset($_SESSION['username'])){
    echo "<script type='text/javascript' src='../js/headermodifiers/iteminfohead.js'></script>";
}
else{
    $_SESSION['itemid'] = $_GET['itemid'];
    echo "<script type='text/javascript' src='../js/headermodifiers/altiteminfohead.js'></script>";
}
//print_r($_SESSION);

//connect to db
require ('mysqlconnection.php');

$university = $_SESSION['university'];

$item = $_GET['itemid'];
//echo $item;

$q = "select special from item where itemid = '$item';";

//run query
$r = @mysqli_query($dbc, $q);

//get the row from query
$row = mysqli_fetch_row($r);

$type = $row[0];

if($type == "Electronic") {
    //echo "electron";
    $q = "select image, title, description, itemtype, itemcondition, price, itemowner, date, make, model, year from item inner join electronics using (itemid) where itemid = '$item';";
}
else if ($type == "Book"){
    //echo "book";
    $q = "select image, title, description, itemtype, itemcondition, price, itemowner, date, author, isbn, edition from item inner join book using (itemid) where itemid = '$item';";
}
else{
    //echo "normal";
    $q = "select image, title, description, itemtype, itemcondition, price, itemowner, date from item where itemid = '$item';";
}

//echo $q;

//run query
$r = @mysqli_query($dbc, $q);

//get the row from query
$row = mysqli_fetch_row($r);

//creating vars to srote info that i need
$image = $row[0];
$title = $row[1];
$description = $row[2];
$itemtype = $row[3];
$itemcondition = $row[4];
$price = $row[5];
$itemowner = $row[6];
$date = $row[7];
$make = "";
$model = "";
$year = "";
$author = "";
$isbn = "";
$edition = "";

if($type == "Electronic") {
    $make = $row[8];
    $model = $row[9];
    $year = $row[10];
}

if($type == "Book") {
    $author = $row[8];
    $isbn = $row[9];
    $edition = $row[10];
}

//echo $author;

//increase view count
$q2 = "update item set views = views + 1 where itemid = $item;";

//run query
$r2 = @mysqli_query($dbc, $q2);


//close db
mysqli_close($dbc);

?>
<div class="headline jumbotron">
    <div class = "container">
        <?php
        if(isset($_GET['retitle'])){
            if($_GET['retitle'] == "yes1") {
                echo "<h1 align='center'>Added To Cart</h1>";
            }
            else{
                echo "<h1 align='center'>Already In Cart</h1>";
            }
        }
        else{
            echo "<h1 align='center'>$title</h1>";
        }
        ?>
    </div>
</div>

<div class="info">
    <div class="row">
        <div class="col-sm-1"></div>
        <div align="center" class="col-lg-4">
            <?php
            $file = "../img/$image";
            echo "<img class='img-rounded' src='$file'/>";
            ?>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-lg-4 container">
            <div>
                <?php
                if($type == "Electronic") {
                    echo "<h3>Make: $make</h3>";
                    echo "<h3>model: $model</h3>";
                    echo "<h3>Year: $year</h3>";
                }

                if($type == "Book") {
                    echo "<h3>Author: $author</h3>";
                    echo "<h3>Edition: $edition</h3>";
                    echo "<h3>ISBN: $isbn</h3>";
                }
                echo "<h3>Description: $description</h3>";
                echo "<h3>Age: $itemtype</h3>";
                echo "<h3>Condition: $itemcondition</h3>";
                echo "<h3>Owner: <a name='ownerlink' href='Items.php?owner=$itemowner'>$itemowner</a></h3>";
                echo "<h3>Price: $$price</h3>";
                echo "<h3>Date Posted: $date</h3>";
                ?>
                <div align='center'>;
                    <a name='cart' href="item_func.php?itemid=<?php echo $item?>&owner=<?php echo $itemowner?> & price=<?php echo $price?>"><img class='img-rounded' height='150px' width='150px' src='../img/cart_icon.jpg'/></a>
                    <h5 align='center'><a name='cartlink' href="item_func.php?itemid=<?php echo $item ?>&owner=<?php echo $itemowner ?> & price=<?php echo $price ?>">Add To Cart</a></h5>
                </div>;
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>
</div>
<?php
include "../html/Footer.html";
?>
