<link type="text/css" rel="stylesheet" href="../css/card_style.css">
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

session_start();
include "../html/Header.html";

require ('mysqlconnection.php');

echo "<script type='text/javascript' src='../js/headermodifiers/checkouthead.js'></script>";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //for processiong login
    require ('card_func.inc.php');

    if (isset($_GET['card'])) {
        $card = $_GET['card'];
        $cardholder = $_GET['cardholder'];
        $cardtype = $_GET['cardtype'];
        $expDate = $_GET['expDate'];
        $street = $_GET['street'];
        $state = $_GET['state'];
        $city = $_GET['city'];
        $zip = $_GET['zip'];

        /*
        echo "<h1>$card</h1>";
        echo "<h1>$cardtype</h1>";
        echo "<h1>$expDate</h1>";
        echo "<h1>$street</h1>";
        echo "<h1>$state</h1>";
        echo "<h1>$city</h1>";
        echo "<h1>$cardholder</h1>";
        echo "<h1>$zip</h1>";
        */
    } else {
        $card = $_POST['card'];
        $cardholder = $_POST['cardholder'];
        $cardtype = $_POST['cardtype'];
        $expDate = $_POST['exp'];
        $street = $_POST['street'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $zip = $_POST['zip'];
    }

    //check login
    list($check, $data) = savecard($dbc, $card, $_SESSION['username'], $cardholder, $cardtype, $expDate, $_GET['addressid'], $street, $city, $state, $zip);

    //everything is not ok
    $errors = '';
    if(!$check){
        //$errors = $data;
    }
}

//print_r($_SESSION);
?>
<div class="jumbotron">
    <div class = "container">
        <?php
        require "login_func.inc.php";
        //if no cookie is present
        if(isset($_POST['submit']) && isset($errors) && empty($errors)){
            //echo "<h1>EXITING</h1>>";
            //close connection

            mysqli_close($dbc);
            redirect_user();
        }
        elseif(isset($_POST['submit']) && isset($errors) && !empty($errors)) {
            //error handling code here
            foreach ($errors as $msg){
                echo "<h4>- $msg</h4>";
            }
            unset($errors);
        }
        else {
            echo "<h1>Credit Card Selection</h1>";
        }
        ?>
    </div>
</div>

<div class="infoinput">
    <div class = "container input">
        <fieldset class="fields container">
            <div class="row">
                <div class="input col-lg-5">
                    <form action="<?php echo "Card.php?addressid=" . $_GET['addressid'] ?>" method="post">
                        <h1 align="center">Card Information</h1>
                        <input type="text" class="form-control" name="card" placeholder="Card Number" maxlength="16" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['card'])) echo $_POST['card'];?>">
                        <input type="text" class="form-control" name="cardholder" placeholder="Card Holder" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['cardholder'])) echo $_POST['cardholder'];?>">
                        <input type="text" class="form-control" name="cardtype" placeholder="Card Type: American Express, Discover, Master Card, Visa" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['cardtype'])) echo $_POST['cardtype'];?>">
                        <input type="text" class="form-control" name="exp" placeholder="Expiration Date" maxlength="5" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['exp'])) echo $_POST['exp'];?>">
                        <h1 align="center">Billing Address</h1>
                        <input type="text" class="form-control" name="street" placeholder="Street" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['street'])) echo $_POST['street'];?>">
                        <input type="text" class="form-control" name="city" placeholder="City" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['city'])) echo $_POST['city'];?>">
                        <input type="text" class="form-control" name="state" placeholder="State" maxlength="2" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['state'])) echo $_POST['state'];?>">
                        <input type="text" class="form-control" name="zip" placeholder="Zipcode" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['zip'])) echo $_POST['zip'];?>">

                        <p class = "save" align="center">
                            <input type="submit" class="btn btn-default" name = "submit" value="Confirm Purchase"/>
                        </p>
                    </form>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-5">
                    <ul>
                        <?php
                        $username = $_SESSION['username'];

                        $q = "select card, cardholder, cardtype, expDate, addressid, cardid from creditcard where username = '$username';";
                        //echo $q;

                        //run query
                        $r = mysqli_query($dbc, $q);

                        //check the query ran well
                        if ($r && mysqli_num_rows($r) > 0) {
                            while ($row = mysqli_fetch_row($r)) {
                                echo "<li>";
                                echo "<div>";

                                $id = $row[4];

                                $q2 = "select street, city, state, zip from address where addressid = '$id';";
                                //echo $q2;
                                //run query
                                $r2 = mysqli_query($dbc, $q2);

                                $card = "" . $row[0];
                                $_POST['card'] = $card;
                                $cardholder = "" . $row[1];
                                $_POST['cardholder'] = $cardholder;
                                $type = "" . $row[2];
                                $_POST['cardtype'] = $type;
                                $expDate = "" . $row[3];
                                $_POST['exp'] = $expDate;

                                $row2 = mysqli_fetch_row($r2);

                                $street = "" . $row2[0];
                                $_POST['street'] = $street;
                                $city = "" . $row2[1];
                                $_POST['city'] = $city;
                                $state = "" . $row2[2];
                                $_POST['state'] = $state;
                                $zip = "" . $row2[3];
                                $_POST['zip'] = $zip;

                                echo "<h4>$type</h4>";
                                echo "<h6>Card Number: $card</h6>";
                                echo "<h6>Card Holder: $cardholder</h6>";
                                echo "<h6>Expiration Date: $expDate</h6>";
                                echo "<h6>Street: $street</h6>";
                                echo "<h6>City: $city</h6>";
                                echo "<h6>State: $state</h6>";
                                echo "<h6>Zip: $zip</h6>";
                                $tempid = $_GET['addressid'];
                                $linkaddr = "Card.php?addressid=" . $_GET['addressid'] . "&cardtype=" . $type . "&card=" . $card . "&cardholder=" . $cardholder . "&expDate=" . $expDate . "&street=" . $street . "&city=" . $city . "&state=" . $state . "&zip=" . $zip;
                                echo "<form action='$linkaddr' method='post'>";
                                echo "<p class = 'save' align='center'>";
                                echo "<input type='submit' class='btn btn-default' name = 'submit' value='Confirm Purchase'/>";
                                echo "</p>";
                                echo "</form>";
                                echo "</li>";
                            }
                        } else {
                            echo "<h1 align='center' class='col-md-10'>No Saved Cards</h1>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<?php

include "../html/Footer.html";
?>
