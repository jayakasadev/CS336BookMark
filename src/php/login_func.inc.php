<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

function redirect_user($page = "Home.php"){
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

    //trim any trailing slashes
    $url = rtrim($url, '/\\');

    //add the page
    $url.= '/' . $page;

    //redirect user
    header ("Location: $url");
    exit(); // exit script
}

function check_login($dbc, $username = '', $password = ''){
    $errors = array(); //init error array

    //validate username
    if(empty($username)){
        $errors[] = 'Enter your Username.';
    }
    else{
        $u = mysqli_real_escape_string($dbc, trim($username));
    }

    //validate password
    if(empty($password)){
        $errors[] = 'Enter your Password.';
    }
    else{
        $p = mysqli_real_escape_string($dbc, $password);
    }

    //if eveyrthing is ok
    if(empty($errors)){

        //retrieve the username for this username/password combo
        $q = "select username, universityname from user inner join university using (universityid) where username = '$u' and password = SHA1('$p')";

        //run query
        $r = @mysqli_query($dbc, $q);

        //check results
        if(mysqli_num_rows($r) == 1){
            //fetch records
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

            //return true and the record
            return array(true, $row);
        }
        else{
            $errors[] = 'User ' . $username . ' does not exist with that password, try again.';
        }
    }

    return array(false, $errors);
}

?>
