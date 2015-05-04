<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

function savecard($dbc, $card = '',$username='', $cardholder = '', $cardtype = '', $expDate='', $addressid = '', $street = '', $city='', $state = '', $zip = ''){
    $errors = array(); //init error array

    //validate street
    if(empty($street)){
        $errors[] = 'Enter your Street Address.';
    }

    //validate street
    if(empty($city)){
        $errors[] = 'Enter your City.';
    }

    //validate street
    if(empty($state)){
        $errors[] = 'Enter your State.';
    }

    //validate street
    if(empty($zip)){
        $errors[] = 'Enter your ZipCode.';
    }

    //if eveyrthing is ok
    if(empty($errors)){
        //save address
        $q = "insert ignore into address (username, street, city, state, zip, addresstype) values ('$username', '$street', '$city', '$state', '$zip', 'Billing');";

        //echo $q;
        //run query
        $r = mysqli_query($dbc, $q);

        $q = "select addressid from address where username = '$username' and street = '$street' and city = '$city' and state = '$state' and zip = '$zip' and addresstype = 'Billing';";

        //echo $q;
        //run query
        $r = @mysqli_query($dbc, $q);

        $row = mysqli_fetch_row($r);
    }
    else {
        return array(false, $errors);
    }

    $billingid=$row[0];

    //echo $billingid;

    //validate street
    if(empty($card)){
        $errors[] = 'Enter your Card Number.';
    }

    //validate street
    if(empty($cardholder)){
        $errors[] = 'Enter Card Holder\'s Name.';
    }

    //validate street
    if(empty($cardtype)){
        $errors[] = 'Enter The Card Type.';
    }

    if($cardtype != "Visa" && $cardtype != "American Express" && $cardtype != "Discover" && $cardtype != "Master Card"){
        $errors[] = 'Incorrect Card Type.';
    }

    //validate street
    if(empty($expDate)){
        $errors[] = 'Enter the Expiration Date.';
    }

    //validate street
    if(empty($addressid)){
        $errors[] = 'Enter Address ID.';
    }

    //validate street
    if(empty($billingid)){
        $errors[] = 'Enter Billing Address ID.';
    }

    //if eveyrthing is ok
    if(empty($errors)){
        $username = $_SESSION['username'];

        //echo $username;

        //save address
        $q = "select seller, itemid from cart where viewer = '$username';";

        //echo $q;
        //run query
        $r = @mysqli_query($dbc, $q);


        $q2 = "select transaction_id from transaction ORDER BY transaction_id desc limit 1;";

        //echo $q2;

        $r2 = @mysqli_query($dbc, $q2);
        $row2 = mysqli_fetch_row($r2);

        if(mysqli_num_rows($r2) > 0) {
            $transactionid = $row2[0];
            $transactionid += 1;
        }
        else{
            $transactionid = 1;
        }

        //echo $transactionid;

        while($row = mysqli_fetch_row($r)){
            $seller = $row[0];
            $itemid = $row[1];

            //save address
            $q3 = "insert ignore into transaction (transaction_id, buyer, seller, itemid, date, addressid) values ('$transactionid', '$username', '$seller', '$itemid', utc_timestamp(), '$addressid');";

            //echo $q3;
            //run query
            $r3 = @mysqli_query($dbc, $q3);
        }
        //echo $card;
        $q4 = "insert ignore into creditcard (card, transaction_id, username, cardholder, cardtype, expDate, addressid) values ('$card', '$transactionid', '$username', '$cardholder', '$cardtype', '$expDate', '$billingid');";

        //echo $q4;
        //run query
        $r4 = @mysqli_query($dbc, $q4);

        $q = "select itemid, special from item inner join cart using (itemid) where viewer='$username';";
        $r1 = @mysqli_query($dbc, $q);

        if($r1 && mysqli_num_rows($r1) > 0) {
            while($row = mysqli_fetch_row($r1)) {
                $type = $row[1];
                $itemid = $row[0];

                //echo "<h1>$type</h1>";
                //echo "<h1>$itemid</h1>";

                $q9 = "delete from item where itemid = '$itemid';";
                //echo "NORMAL ". $q1;
                $r9 = @mysqli_query($dbc, $q9);

                if($type == "Electronic"){
                    $q10 = "delete from electronics where itemid = '$itemid';";
                    //echo "ELEC " . $q1;
                    $r10 = @mysqli_query($dbc, $q10);
                }
                else if($type == "Book") {
                    $q11 = "delete from book where itemid = '$itemid';";
                    //echo "Book " . $q1;
                    $r11 = @mysqli_query($dbc, $q11);
                }
            }
        }
        //echo $q5;
        //run query

        $q5 = "delete from cart where viewer = '$username';";

        //echo $q5;
        //run query
        $r5 = @mysqli_query($dbc, $q5);

        return array(true, $errors);
    }
    return array(false, $errors);
}

?>
