<link type="text/css" rel="stylesheet" href="../css/cart_style.css">
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
        <h1 align="center">Cart</h1>
    </div>
</div>
<div class="items">
    <div id="nav" class="cartitems container">
        <ul>
            <li>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <a href='Checkout.php' class='btn btn-default' role='button'>Proceed To Checkout</a>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-3">
                        <a href='delete_cart_item.php' class='btn btn-default' role='button'>Clear Cart</a>
                    </div>
                    <div class="col-sm-1"></div>
                </div>
            </li>

            <?php
            //connect to db
            require ('mysqlconnection.php');

            $username = $_SESSION['username'];

            $q = "select itemid, price, seller from cart where viewer = '$username'";

            //run query
            $r = @mysqli_query($dbc, $q);

            //check the query ran well
            if($r && mysqli_num_rows($r) > 0) {


                while($row = mysqli_fetch_row($r)) {
                    echo "<li>";
                    echo "<div class='row'>";
                    echo "<div class='col-sm-1'></div>";

                    $id = "" . $row[0];
                    $price = "" . $row[1];
                    $seller = "" . $row[2];

                    $q2 = "select image, title, description from cart as c inner join item using (itemid);";

                    //run query
                    $r2 = @mysqli_query($dbc, $q2);

                    $row2 = mysqli_fetch_row($r2);

                    $image = $row2[0];
                    $file = "../img/$image";
                    $title = "" . $row2[1];
                    $description = "" . $row2[2];

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
                    echo "<a href='delete_cart_item.php?itemid=$id' class='btn btn-default' role='button'>Remove</a>";
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
