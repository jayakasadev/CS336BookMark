<link type="text/css" rel="stylesheet" href="../css/checkout_style.css">
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

session_start();
include "../html/Header.html";

echo "<script type='text/javascript' src='../js/headermodifiers/checkouthead.js'></script>";

//main submit conditional
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //for processiong login
    require ('checkout_func.inc.php');

    //connect to db
    require ('mysqlconnection.php');


    //check login
    list($check, $data) = saveaddr($dbc, $_SESSION['username'], $_POST['street'], $_POST['city'], $_POST['state'], $_POST['zip'], 'Delivery');


    //everything is not ok
    $errors = '';
    if(!$check){
        $errors = $data;
    }
    else{
        $addressid=$data[0];
    }

    //close connection
    mysqli_close($dbc);
}

//print_r($_SESSION);
?>
<div class="jumbotron">
    <div class = "container">
        <?php
        require "login_func.inc.php";

        //if no cookie is present
        if(isset($_POST['submit']) && isset($errors) && empty($errors)){
            //need functions
            redirect_user("Card.php?addressid=$addressid");

            //echo $_SESSION['username'];
            //echo $_SESSION['university'];
        }
        elseif(isset($_POST['submit']) && isset($errors) && !empty($errors)) {
            //error handling code here
            foreach ($errors as $msg){
                echo "<h4>- $msg</h4>";
            }
        }
        else {
            echo "<h1>Delivery Address Selection</h1>";
        }
        ?>
    </div>
</div>

<div class="infoinput">
    <div class = "container input">
        <form action="Checkout.php" method="post">
            <fieldset class="fields container">
                <div class="row">
                    <div class="input col-lg-5">
                        <h1 align="center">Delivery Address</h1>
                        <input type="text" class="form-control" name="street" placeholder="Street" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['street'])) echo $_POST['street'];?>">
                        <input type="text" class="form-control" name="city" placeholder="City" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['city'])) echo $_POST['city'];?>">
                        <input type="text" class="form-control" name="state" placeholder="State" maxlength="2" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['state'])) echo $_POST['state'];?>">
                        <input type="text" class="form-control" name="zip" placeholder="Zipcode" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['zip'])) echo $_POST['zip'];?>">

                        <p class = "save" align="center">
                            <input type="submit" class="btn btn-default" name = "submit" value="Save"/>
                        </p>
                    </div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-5">
                        <ul>
                            <?php
                            //connect to db
                            require ('mysqlconnection.php');

                            $username = $_SESSION['username'];

                            $q = "select street, city, state, zip, addresstype, addressid from address where username = '$username';";
                            //run query
                            $r = mysqli_query($dbc, $q);

                            //check the query ran well
                            if($r && mysqli_num_rows($r) > 0) {
                                while($row = mysqli_fetch_row($r)) {
                                    echo "<li>";
                                    echo "<div>";

                                    $street = "" . $row[0];
                                    $city = "" . $row[1];
                                    $state = "" . $row[2];
                                    $zip = "" . $row[3];
                                    $type = "" . $row[4];
                                    $id = "" . $row[5];


                                    echo "<h4>$type</h4>";
                                    echo "<h6>Street: $street</h6>";
                                    echo "<h6>City: $city</h6>";
                                    echo "<h6>State: $state</h6>";
                                    echo "<h6>Zip: $zip</h6>";

                                    echo "<a href='Card.php?addressid=$id' class='btn btn-default' role='button'>Use</a>";
                                    echo "</div>";
                                    echo "</li>";
                                }
                            }
                            else{
                                echo "<h1 align='center' class='col-md-10'>No Saved Addresses</h1>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<?php
include "../html/Footer.html";
?>
