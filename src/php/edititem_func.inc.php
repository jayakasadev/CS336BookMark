<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

//connect to db
require ('mysqlconnection.php');

function edititem($dbc, $title= '', $description = '', $type = '', $condition= '', $price = '', $id= ''){
    $errors = array(); //init error array

    //validate street
    if(!empty($title)){
        $q = "update item set title='$title' where itemid = '$id';";
        //echo $q;
        $r = mysqli_query($dbc, $q);
    }

    //validate street
    if(!empty($description)){
        $q = "update item set description = '$description' where itemid = '$id';";
        //echo $q;
        $r = mysqli_query($dbc, $q);
    }

    //validate street
    if(!empty($type)){
        $q = "update item set type = '$type'  where itemid = '$id';";
        //echo $q;
        $r = mysqli_query($dbc, $q);
    }

    //validate street
    if(!empty($condition)){
        $q = "update item set condition = '$condition'  where itemid = '$id';";
        //echo $q;
        $r = mysqli_query($dbc, $q);
    }

    //validate street
    if(!empty($price)){
        $q = "update item set price = '$price'  where itemid = '$id';";
        //echo $q;
        $r = mysqli_query($dbc, $q);
    }

    mysqli_close($dbc);

    //return array(true, $errors);
}

?>
