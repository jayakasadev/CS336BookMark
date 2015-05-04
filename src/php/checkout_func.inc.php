<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

function saveaddr($dbc, $username = '', $street = '', $city='', $state = '', $zip = '', $type=''){
    $errors = array(); //init error array
    $output = array(); //init error array

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

    //validate street
    if(empty($type)){
        $errors[] = 'Enter the Type.';
    }

    //if eveyrthing is ok
    if(empty($errors)){
        //save address
        $q = "insert into address (username, street, city, state, zip, addresstype) values ('$username', '$street', '$city', '$state', '$zip', '$type');";

        //echo $q;
        //run query
        $r = @mysqli_query($dbc, $q);

        $q = "select addressid from address where username = '$username' and street = '$street' and city = '$city' and state = '$state' and zip = '$zip' and addresstype = '$type';";

        //echo $q;
        //run query
        $r = @mysqli_query($dbc, $q);

        $row = mysqli_fetch_row($r);

        return array(true, $row);
    }
    return array(false, $errors);
}

?>
