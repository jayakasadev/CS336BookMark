<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

function check_account($dbc, $username = '', $password = '', $confirm='', $university='', $first_name='', $last_name='', $email=''){

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
    elseif(empty($confirm) || $confirm != $password){
        $errors[] = 'Passwords do not match.';
    }
    else{
        $p = mysqli_real_escape_string($dbc, $password);
    }

    //validate password
    if(empty($university)){
        $errors[] = 'Enter your University.';
    }
    else{
        $uni = mysqli_real_escape_string($dbc, $university);
    }

    //if eveyrthing is ok
    if(empty($errors)){
        //echo "no errors";
        //retrieve the username for this username/password combo
        $q = "select username from user where username = '$u'";

        //run query
        $r = @mysqli_query($dbc, $q);

        //fetch records
        $row = mysqli_fetch_row($r);

        //echo "Row" . $row[0];

        //check results
        //user doesnt exist
        if(mysqli_num_rows($r) < 1){
            //echo "no user match";

            //check if university or username exists
            $q = "select count(universityid) from university where '%$uni%' like universityname";

            //echo " " . $q;

            //run query
            $r = @mysqli_query($dbc, $q);

            //fetch records
            $row = mysqli_fetch_row($r);

            //echo "Row" . $row[0];

            //new university
            if(mysqli_num_rows($r) < 1){
                ////echo "uni DNE";

                $q = "insert into university (universityname) values ($uni)";

                //run query
                $r = @mysqli_query($dbc, $q);
            }

            ////echo "uni exists";

            //university was just created or already exists
            //time to add to db
            $q = "insert into user (username, password, first_name, last_name, universityid, email, registration) values ('$u', SHA1('$p'), '$first_name', '$first_name', (select universityid from university where universityname like '%$uni%'), '$email', utc_date())";

            //echo $q;

            //fetch records
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

            //echo "Row" . $row;

            //run query
            $r = @mysqli_query($dbc, $q);

            //retrieve the username for this username/password combo
            $q = "select username, universityname from user inner join university using (universityid) where username = '$u' and password = SHA1('$p')";

            //run query
            $r = @mysqli_query($dbc, $q);

            //fetch records
            $row = mysqli_fetch_assoc($r);

            //echo "Output Row" . $row['username'];

            //return true and the record
            return array(true, $row);
        }
        //user exists
        else{
            //echo "entries match";
            $errors[] = 'User ' . $username . ' already exists.';
        }
    }

    return array(false, $errors);
}

?>
