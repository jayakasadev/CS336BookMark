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
    echo "<script type='text/javascript' src='../js/headermodifiers/altiteminfohead.js'></script>";
}
//print_r($_SESSION);

$university = $_SESSION['university'];

?>
<div class="headline jumbotron">
    <div class="container">
        <h1 align='center'>Browse Items Available At Your School</h1>
    </div>
</div>

<div class="inputs">
    <form action="../php/Browse.php" method="post">
        <div class="row">
            <div class="col-sm-1"></div>
            <div align="center" class="col-sm-8">
                <input type="text" class="form-control" name="search" placeholder="Search:"
                       aria-describedby="basic-addon1"
                       value="<?php if (isset($_POST['search'])) echo $_POST['search']; ?>">
            </div>
            <script type="text/javascript">
                $(document).ready(function () {
                    $(".dropdown-toggle").dropdown('toggle');
                });
            </script>
            <div align="center" class="col-sm-1">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Order By:
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo "Browse.php?query=select image, title, itemid from item inner join university using (universityid) where universityname = '$university' order by title;" ?>">By
                                Title Ascending</a></li>
                        <li>
                            <a href="<?php echo "Browse.php?query=select image, title, itemid from item inner join university using (universityid) where universityname = '$university' order by title desc;" ?>">By
                                Title Descending</a></li>
                        <li>
                            <a href="<?php echo "Browse.php?query=select image, title, itemid, date from item inner join university using (universityid) where universityname = '$university' order by date;" ?>">By
                                Date Ascending</a></li>
                        <li>
                            <a href="<?php echo "Browse.php?query=select image, title, itemid, date from item inner join university using (universityid) where universityname = '$university' order by date desc;" ?>">By
                                Date Descending</a></li>
                        <li>
                            <a href="<?php echo "Browse.php?query=select image, title, itemid, views from item inner join university using (universityid) where universityname = '$university' order by views;" ?>">By
                                Views Ascending</a></li>
                        <li>
                            <a href="<?php echo "Browse.php?query=select image, title, itemid, views from item inner join university using (universityid) where universityname = '$university' order by views desc;" ?>">By
                                Views Descending</a></li>
                        <li>
                            <a href="<?php echo "Browse.php?query=select image, title, itemid, itemtype from item inner join university using (universityid) where universityname = '$university' order by itemtype;" ?>">Newest
                                First</a></li>
                        <li>
                            <a href="<?php echo "Browse.php?query=select image, title, itemid, itemtype from item inner join university using (universityid) where universityname = '$university' order by itemtype desc;" ?>">Oldest
                                First</a></li>
                        <li>
                            <a href="<?php echo "Browse.php?query=select image, title, itemid, special from item inner join university using (universityid) where universityname = '$university' order by special;" ?>">By
                                Type</a></li>
                        <li>
                            <a href="<?php echo "Browse.php?query=select image, title, itemid, special from item inner join university using (universityid) where universityname = '$university' order by special desc;" ?>">By
                                Type Descending</a></li>
                    </ul>
                </div>
            </div>
            <div align="center" class="col-sm-1">
                <p class="submitbutton">
                    <a><input type="submit" class="btn btn-success" name="submit" value="Search"/></a>
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
        $electronic = 0;
        $book = 0;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $search = $_POST['search'];
            $pieces = preg_split(' /[\s ,.?:<>] +/', $search);
            $tail = 'and (';
            $tick = 0;
            foreach ($pieces as $piece) {
                $piece = strtolower($piece);
                if ($tick == 0) {
                    $tail = $tail . "title like '%" . $piece . "%'";
                    $tail = $tail . " or description like '%" . $piece . "%'";
                    $tail = $tail . " or itemtype like '%" . $piece . "%'";
                    $tail = $tail . " or price like '%" . $piece . "%'";
                    $tail = $tail . " or itemcondition like '%" . $piece . "%'";
                    $tail = $tail . " or itemowner like '%" . $piece . "%'";

                    $tick++;
                } else {
                    $tail = $tail . " or title like '%" . $piece . "%'";
                    $tail = $tail . " or description like '%" . $piece . "%'";
                    $tail = $tail . " or itemtype like '%" . $piece . "%'";
                    $tail = $tail . " or price like '%" . $piece . "%'";
                    $tail = $tail . " or itemcondition like '%" . $piece . "%'";
                    $tail = $tail . " or itemowner like '%" . $piece . "%'";
                }
                if ($piece == "electronic") {
                    $electronic = 1;
                }
                if ($piece == "book") {
                    $book = 1;
                }
            }
            $tail = $tail . ");";
            //echo "<h6>$tail</h6>";

            if ($electronic == 1) {
                $q = "select image, title, itemid, special, description, itemtype, price, itemcondition,itemowner from item inner join university using (universityid) inner join electronics using(itemid) where universityname = '$university'" . $tail;
            } else if ($book == 1) {
                $q = "select image, title, itemid, special, description, itemtype, price, itemcondition,itemowner from item inner join university using (universityid) inner join book using(itemid) where universityname = '$university'" . $tail;
            } else {
                $q = "select image, title, itemid, description from item inner join university using (universityid) where universityname = '$university'" . $tail;
            }
        } else {
            if (isset($_GET['query'])) {
                $q = $_GET['query'];
            } else {
                $q = "select image, title, itemid from item inner join university using (universityid) where universityname = '$university';";
            }
        }
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
        mysqli_close($dbc);
        ?>
    </div>
</div>

<?php
include "../html/Footer.html";
?>
