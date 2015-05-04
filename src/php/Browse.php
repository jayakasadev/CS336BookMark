<link type="text/css" rel="stylesheet" href="../css/browse_style.css">
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */
session_start();
include "../html/Header.html";

if(isset($_SESSION['username'])){
    echo "<script type='text/javascript' src='../js/headermodifiers/iteminfohead.js'></script>";
} else {
    $_SESSION['itemid'] = $_GET['itemid'];
    echo "<script type='text/javascript' src='../js/headermodifiers/altiteminfohead.js'></script>";
}
//print_r($_SESSION);

?>
<div class="headline jumbotron">
    <div class="container">
        <h1 align="center">Browse Items Available At Your School</h1>
    </div>
</div>

<div class="inputs">
    <form action="../php/Browse.php" method="post">
        <div class="row">
            <div class="col-sm-1"></div>
            <div align="center" class="col-sm-9">
                <input type="text" class="form-control" name="search" placeholder="Search:"
                       aria-describedby="basic-addon1"
                       value="<?php if (isset($_POST['search'])) echo $_POST['search']; ?>">
            </div>
            <div align="center" class="col-sm-1">
                <p class="submitbutton">
                    <input type="submit" class="btn btn-success" name="submit" value="Search"/>
                </p>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </form>
</div>

<div class="schools">
    <div class="slider">
        <?php
        //connect to db
        require('mysqlconnection.php');

        $count = 0;

        $university = $_SESSION['university'];

        $q = "select image, title, itemid from item inner join university using (universityid) where universityname = '$university';";

        //run query
        $r = @mysqli_query($dbc, $q);

        if ($r) {
            while ($row = mysqli_fetch_row($r)) {
                $name = $row[2];
                if ($count == 0) {
                    echo "<div class='slide'>";
                    echo "<div class='container'>";
                    echo "<div class='row'>";
                }


                $file = "../img/$row[0]";
                $link = "" . $row[1];
                echo "<div align='center' class='col-lg-3'>";
                if (file_exists($file)) {
                    echo "<a name='$name' href='Item Info.php?itemid=$name'><img align='center' class='img-rounded' src='$file'/></a>";
                } else {
                    echo "<a name='$name' href='Item Info.php?itemid=$name'><img align='center' class='img-rounded' src='../img/unavailable.png'/></a>";
                }
                echo "<h5><a name='$link' href='Item Info.php?itemid=$name'>$link</a></h5>";

                echo "</div>";

                $count++;
                if ($count % 4 == 0) {
                    echo "</div>";
                    $count = 0;
                }
            }

            if ($count % 4 > 0) {
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
</div>

<?php
include "../html/Footer.html";
?>
