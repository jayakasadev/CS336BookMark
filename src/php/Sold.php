<link type="text/css" rel="stylesheet" href="../css/sold_style.css">
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

session_start();
include "../html/Header.html";


echo "<script type='text/javascript' src='../js/headermodifiers/carthead.js'></script>";
//print_r($_SESSION);
?>
<div class="headline jumbotron">
    <div class = "container">
        <h1 align="center">Item's Sold</h1>
    </div>
</div>


<div class="items">
    <div id="nav" class="cartitems container">
        <ul>

            <?php
            //connect to db
            require ('mysqlconnection.php');

            $username = $_SESSION['username'];

            $q = "select * from transaction where seller = '$username';";

            //run query
            $r = @mysqli_query($dbc, $q);

            //check the query ran well
            if($r && mysqli_num_rows($r) > 0) {


                while($row = mysqli_fetch_row($r)) {
                    echo "<li>";
                    echo "<div class='row'>";
                    echo "<div class='col-sm-1'></div>";

                    $id = "" . $row[3];
                    $buyer = "" . $row[1];
                    $date = "" . $row[4];
                    $seller = "" . $row[2];
                    $shipped = "" . $row[6];

                    $q2 = "select image, title, description, price from item WHERE itemid = $id;";

                    //run query
                    $r2 = @mysqli_query($dbc, $q2);

                    $row2 = mysqli_fetch_row($r2);

                    $image = $row2[0];
                    $file = "../img/$image";
                    $title = "" . $row2[1];
                    $description = "" . $row2[2];
                    $price = "" . $row2[3];

                    echo "<div class='col-lg-2'>";
                    if (file_exists($file)) {
                        echo "<a name='$id' href='Item Info.php?itemid=$id'><img align='center' class='img-rounded' src='$file'/></a><br/>";
                    }
                    else{
                        echo "<a name='$id' href='Item Info.php?itemid=$id'><img align='center' class='img-rounded' src='../img/unavailable.png'/></a><br/>";
                    }
                    echo "</div>";
                    echo "<div class='col-sm-1'></div>";

                    echo "<div class='col-lg-5'>";
                    echo "<h4>$title</h4>";
                    echo "<h4>Description: $description</h4>";
                    echo "<h4>Price: $$price</h4>";
                    echo "<h4>Seller: <a name='ownerlink' href='Items.php?owner=$seller'>$seller</a></h4>";
                    echo "</div>";
                    echo "<div class='col-sm-1'></div>";
                    echo "<div class='col-sm-1'>";
                    echo "<div>";
                    if($shipped == "No"){
                        echo "<a href='shipped.php?itemid=$id' class='btn btn-danger' role='button'>Pending Item</a>";
                    }
                    else{
                        echo "<a href='#' class='btn btn-success' role='button'>Item Was Shipped</a>";
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='col-sm-1'></div>";
                    echo "</div>";
                    echo "</li>";
                }
            }
            else{
                echo "<h1 align='center' class='col-md-10'>No Items Currently In Cart</h1>";
            }
            ?>
        </ul>
    </div>
</div>
<?php
include "../html/Footer.html";
?>
