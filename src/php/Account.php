<link type="text/css" rel="stylesheet" href="../css/account_style.css">
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

session_start();
include "../html/Header.html";


echo "<script type='text/javascript' src='../js/headermodifiers/accounthead.js'></script>";
//print_r($_SESSION);
?>

<div class="headline jumbotron">
    <div class = "container">
        <h1 align="center">Manage Account</h1>
    </div>
</div>

<div class="buttons">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-2">
            <a href='Sold.php' class='btn btn-default' role='button'>Sold Items</a>
        </div>
        <div class="col-sm-2"></div>
        <div class="col-sm-2">
            <a href='Bought.php' class='btn btn-default' role='button'>Bought Items</a>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>

<div class="schools">
    <h1 align="center">Your Listed Items (Click To Edit)</h1>
    <div class="slider">
        <?php
        //connect to db
        require('mysqlconnection.php');

        $count = 0;
        $display = 6;
        $username = $_SESSION['username'];
        $total = 0;
        $slidecount = 0;

        $q = "select itemid, title, image,special from item where itemowner = '$username';";

        //run query
        $r = @mysqli_query($dbc, $q);

        if($r){
            while($row = mysqli_fetch_row($r)){
                $special = $row[3];
                $name = $row[0];

                if($special != "Normal"){
                    //skip over deleted items
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
                        continue;
                    }
                }


                $name = "logo" . $total;
                if($count == 0){
                    if($total%6 == 0) {
                        if($total == 0){
                            echo "<div class='slide active-slide'>";
                        }
                        else{
                            echo "<div class='slide'>";
                        }
                        $slidecount++;
                        echo "<div class='container'>";
                    }
                    echo "<div class='row'>";
                }


                echo "<div class='col-sm-4'>";


                $file = "../img/$row[2]";
                echo "<h1></h1>";
                $link = "" . $row[1];

                if (file_exists($file)) {
                    echo "<a name='$name' href='EditItem.php?itemid=$row[0]&image=$file'><img align='center' class='img-rounded' src='$file'/></a>";
                }
                else{
                    echo "<a name='$name' href='EditItem.php?itemid=$row[0]&image=$file'><img align='center' class='img-rounded' src='../img/unavailable.png'/></a>";
                }
                echo "<h5><a name='$link' href='EditItem.php?itemid=$row[0]&image=$file'>$link</a></h5>";

                echo "</div>";

                $count++;
                $total++;
                if($total%6 == 0){
                    echo "</div>";
                    echo "</div>";
                }
                if($count%3 == 0){
                    echo "</div>";
                    $count = 0;
                }
            }

            if($count%3 > 0){
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        }

        //close db
        mysqli_free_result($r);
        mysqli_close($dbc);
        ?>
    </div>

    <div class="slider-nav">
        <a class="arrow-prev"><img width="20px" height="20px" src="../img/arrow-left.png"></a>
        <ul class="slider-dots">
            <?php
            $counter = 0;
            while($counter < $slidecount){
                if($counter == 0){
                    echo "<li class='dot active-dot'>&bull;</li>";
                }
                else{
                    echo "<li class='dot'>&bull;</li>";
                }
                $counter++;
            }
            ?>
        </ul>
        <a class="arrow-next"><img width="20px" height="20px" src="../img/arrow-right.png"></a>
    </div>
</div>
<script type="text/javascript" src="js/schoolloader.js"></script>
<?php
include "../html/Footer.html";
?>
