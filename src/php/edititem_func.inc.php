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


function newitem($dbc, $title = '', $description = '', $type = '', $condition = '', $price = '', $make = '', $model = '', $year = '', $isbn = '', $author = '', $edition = '', $image = '')
{
    $errors = array(); //init error array

    //validate street
    if (empty($title)) {
        $errors[] = "Enter a Title.";
    }

    //validate street
    if (empty($description)) {
        $errors[] = "Enter a Description.";
    }

    //validate street
    if (empty($type)) {
        $errors[] = "Select a Type.";
    }

    //validate street
    if (empty($condition)) {
        $errors[] = "Enter the Condition.";
    }

    //validate street
    if (empty($price)) {
        $errors[] = "Enter the Price.";
    }

    //echo "Normal";
    if (empty($make) && empty($model) && empty($year) && empty($isbn) && empty($author) && empty($edition)) {
        if (empty($errors)) {
            $username = $_SESSION['username'];
            $university = $_SESSION['university'];
            $q = "insert into item (itemowner, universityid, title, description, itemcondition, price, image, date, itemtype) values ('$username', (select universityid from user where username = '$username'), '$title', '$description', '$condition', '$price', '$image', utc_timestamp(), '$type');";
            //echo $q;
            $r = mysqli_query($dbc, $q);
            return array(true, $errors);
        } else {

            return array(false, $errors);
        }
    }

    //book
    echo "Book";
    if (empty($make) && empty($model) && empty($year) && (!empty($isbn) || !empty($author) || !empty($edition))) {
        if (empty($isbn)) {
            $errors[] = "Enter an ISBN Number.";
        }

        //validate street
        if (empty($author)) {
            $errors[] = "Enter the Author.";
        }

        //validate street
        if (empty($edition)) {
            $errors[] = "Enter the Edition.";
        }

        if (empty($errors)) {
            $username = $_SESSION['username'];
            $university = $_SESSION['university'];
            $q = "insert into item (itemowner, universityid, title, description, itemcondition, price, image, date, itemtype) values ('$username', (select universityid from user where username = '$username'), '$title', '$description', '$condition', '$price', '$image', utc_timestamp(), '$type', 'Book');";
            //echo $q;
            $r = mysqli_query($dbc, $q);

            $q = "insert into book (itemid, isbn, author, edition) values ((select itemid from item where title = '$title' and itemowner = '$username'),  '$isbn', '$author', '$edition');";
            //echo $q;
            $r = mysqli_query($dbc, $q);

            return array(true, $errors);
        }
    }

    //electronic
    echo "Electronics";
    if ((!empty($make) || !empty($model) || !empty($year)) && (empty($isbn) && empty($author) && empty($edition))) {
        if (empty($make)) {
            $errors[] = "Enter the Make.";
        }

        //validate street
        if (empty($model)) {
            $errors[] = "Enter the Model.";
        }

        //validate street
        if (empty($year)) {
            $errors[] = "Enter the Year.";
        }

        if (empty($errors)) {
            $username = $_SESSION['username'];
            $university = $_SESSION['university'];
            $q = "insert into item (itemowner, universityid, title, description, itemcondition, price, image, date, itemtype) values ('$username', (select universityid from user where username = '$username'), '$title', '$description', '$condition', '$price', '$image', utc_timestamp(), '$type', 'Electronic');";
            //echo $q;
            $r = mysqli_query($dbc, $q);

            $q = "insert into electronics (itemid, make, model, year) values ((select itemid from item where title = '$title' and itemowner = '$username'), '$make', '$model', '$year');";
            //echo $q;
            $r = mysqli_query($dbc, $q);

            return array(true, $errors);
        }
    } else {
        $errors[] = "Item can only be one of two types.";
    }

    mysqli_close($dbc);

    return array(false, $errors);
}

?>
