<link type="text/css" rel="stylesheet" href="../css/home_style.css">
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

session_start();
include "../html/Header.html";
$user = "";

if(isset($_SESSION['username'])){
    echo "<script type='text/javascript' src='../js/headermodifiers/homehead.js'></script>";
    $user = $_SESSION['username'];
} else if (isset($_GET['university'])) {
    $_SESSION['university'] = $_GET['university'];
    echo "<script type='text/javascript' src='../js/headermodifiers/althomehead.js'></script>";
}
else if(isset($_SESSION['university'])){
    echo "<script type='text/javascript' src='../js/headermodifiers/althomehead.js'></script>";
}
//build body below
?>

<div class="headline jumbotron">
    <div class = "container">
        <h1 align="center">BookMark(et.)</h1>
    </div>
</div>
<div class="items">
    <h1>New Items:</h1>
    <div class="newitems container">
        <?php
        //connect to db
        require ('mysqlconnection.php');

        $university = $_SESSION['university'];

        $q = "select itemid, title, image,special from item where universityid = (select universityid from university where universityname = '$university') and itemowner != '$user' order by date desc limit 5;";

        //run query
        $r = @mysqli_query($dbc, $q);

        //check the query ran well
        if($r && mysqli_num_rows($r) > 0) {
            $rows = mysqli_num_rows($r);
            echo "<div class='col-sm-1'></div>";
            while($row = mysqli_fetch_row($r)) {

                $name = "" . $row[0];
                $file = "../img/$row[2]";
                $link = "" . $row[1];
                $special = "" . $row[3];

                if($special != "Normal"){
                    if($special == "Electronic") {
                        $q2 = "select itemid from electronics where itemid = '$name';";
                        //echo $q2;
                    }
                    else{
                        $q2 = "select itemid from book where itemid = '$name';";
                        //echo $q2;
                    }
                    //run query
                    $r2 = @mysqli_query($dbc, $q2);
                    $row2 = mysqli_fetch_row($r2);

                    if(is_null($row2[0])){
                        $q2 = "delete from item where itemid = '$name';";
                        $r2 = @mysqli_query($dbc, $q2);

                        $rows--;
                        if($rows == 0){
                            echo "<h1 align='center' class='col-md-10'>No Items Currently Listed</h1>";
                        }
                        continue;
                    }
                }

                echo "<div class='col-lg-2'>";
                if (file_exists($file)) {
                    echo "<a name='$name' href='Item Info.php?itemid=$name'><img align='center' class='img-rounded' src='$file'/></a>";
                }
                else{
                    echo "<a name='$name' href='Item Info.php?itemid=$name'><img align='center' class='img-rounded' src='../img/unavailable.png'/></a>";
                }
                echo "<h5 align='center'><a name='$link' href='Item Info.php?itemid=$name'>$link</a></h5>";
                echo "</div>";
            }
            echo "<div class='col-sm-1'></div>";
        }
        else{
            echo "<h1 align='center' class='col-md-10'>No Items Currently Listed</h1>";
        }
        ?>
    </div>
    <h1>Popular Items:</h1>
    <div class="popularitems container">
        <?php
        $university = $_SESSION['university'];
        echo "<h1></h1>";

        $q = "select itemid, title, image, special from item where universityid = (select universityid from university where universityname = '$university') and itemowner != '$user' order by views desc limit 5;";

        //run query
        $r = @mysqli_query($dbc, $q);

        //check the query ran well
        if($r && mysqli_num_rows($r) > 0) {
            $rows = mysqli_num_rows($r);
            echo "<div class='col-sm-1'></div>";
            while($row = mysqli_fetch_row($r)) {

                $name = "" . $row[0];
                $file = "../img/$row[2]";
                $link = "" . $row[1];
                $special = "" . $row[3];

                if($special != "Normal"){
                    if($special == "Electronic") {
                        $q2 = "select itemid from electronics where itemid = '$name';";
                        //echo $q2;
                    }
                    else{
                        $q2 = "select itemid from book where itemid = '$name';";
                        //echo $q2;
                    }
                    //run query
                    $r2 = @mysqli_query($dbc, $q2);
                    $row2 = mysqli_fetch_row($r2);

                    if(is_null($row2[0])){
                        $q2 = "delete from item where itemid = '$name';";
                        $r2 = @mysqli_query($dbc, $q2);
                        $rows--;
                        if($rows == 0){
                            echo "<h1 align='center' class='col-md-10'>No Items Currently Listed</h1>";
                        }
                        continue;
                    }
                }

                echo "<div class='col-lg-2'>";
                if (file_exists($file)) {
                    echo "<a name='$name' href='Item Info.php?itemid=$name'><img align='center' class='img-rounded' src='$file'/></a>";
                }
                else{
                    echo "<a name='$name' href='Item Info.php?itemid=$name'><img align='center' class='img-rounded' src='../img/unavailable.png'/></a>";
                }
                echo "<h5 align='center'><a name='$link' href='Item Info.php?itemid=$name'>$link</a></h5>";
                echo "</div>";
            }
            echo "<div class='col-sm-1'></div>";
        }
        else{
            echo "<h1 align='center' class='col-md-10'>No Items Currently Listed</h1>";
        }
        mysqli_close($dbc);
        ?>
    </div>
</div>

<?php
include "../html/Footer.html";
?>
