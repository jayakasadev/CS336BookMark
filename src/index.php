<?php
//starting session
//no need for cookies
session_start();

//counter of how many times page was visited
if( isset( $_SESSION['counter'] ) )
{
    $_SESSION['counter'] += 1;
}
else
{
    $_SESSION['counter'] = 1;
}

$msg = "You have visited this page ".  $_SESSION['counter'] . " times in this session.";
?>

<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>BookMark(et.)</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="../bootstrap3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/Header_style.css">
    <link rel="stylesheet" href="css/Footer_style.css">
    <link rel="stylesheet" href="css/main_style.css">

    <script type="text/javascript" src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</head>

<body>
<div class="header">
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-5">
            <div class = "nav nav-pills pull-left">
                <li role="presentation"><a href="#">BookMark(et.)</a></li>
            </div>
        </div>
        <div class="col-md-5">
            <div class = "nav nav-pills pull-right">
                <li role = presentation><a href="php/Login.php">Login</a></li>
                <li role="presentation"><a href="php/NewAccount.php">New User</a></li>
                <li role="presentation"><a href="html/Help.html">Help</a></li>
            </div>
        </div>
    </div>
</div>
<?php
$total = 0;
$slidecount = 0;
?>
<div class="content">
    <div class="headline">
        <div class="jumbotron col-sm-12 container">
            <div class="container">
                <h1 align="left" class="h1first">WHAT YOU NEED</h1>
                <h1 align="right" class="h1second">WHEN YOU NEED IT</h1>
            </div>

        </div>
    </div>

    <div class="holder">
        <div class="container">
            <div class="row slogans">
                <div class="col-sm-4 slogan">
                    <legend align="center">Find what you need</legend>
                    <p align="justify">Tired of looking through message boards to see what your classmates are selling? Wish it were easier to get what you need for school? At BookMark(et.), we make it easy for you to connect with your classmates and find the things you need.</p>
                </div>
                <div class="col-sm-4 slogan" >
                    <legend align="center">Set the rules</legend>
                    <p align="justify">Don't like being ripped off by buyback programs? Tired of posting on message boards to sell your things? Don't let anyone else tell you what your things are worth. Sell whatever you want, at the price you like.</p>
                </div>
                <div class="col-sm-4 slogan">
                    <legend align="center">Try it out</legend>
                    <p align="justify">You do not need to be a member to give Bookmark(et.) a try. Check out what's available. Select your school from the list below, and check out what's available near you.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="schools">
        <h1 align="center">Click on your School and see what's available</h1>
        <div class="slider">
            <?php
            //connect to db

            //echo "<h1>$msg</h1>";

            require('php/mysqlconnection.php');

            $count = 0;
            $display = 6;


            $q = "select * from university order by universityname";

            //run query
            $r = @mysqli_query($dbc, $q);



            if($r){
                while($row = mysqli_fetch_row($r)){
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

                    $file = "img/$row[0].jpg";
                    if(file_exists($file)){
                        //echo "<input align='center' class='img-circle' type='image' height='239px' width='239px' src=\"$file\">";
                        echo "<a name='$name' href='php/Browse.php'><img class='img-circle' height='239px' width='250px' src=\"$file\"></a>";

                    }
                    $link = "link" . $row[0];
                    echo "<h5><a name='$link' href='php/Browse.php'>$row[1]</a></h5>";
                    //echo "<p>$row[1]</p>";
                    //$s = "Middle" . $count;

                    if (!isset($_POST[$name]) || !isset($_POST[$link])){
                        $_SESSION["favcolor"] = "green";
                        $_SESSION["favanimal"] = "cat";
                    }



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
            <a class="arrow-prev"><img width="20px" height="20px" src="img/arrow-left.png"></a>
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
            <a class="arrow-next"><img width="20px" height="20px" src="img/arrow-right.png"></a>
        </div>
    </div>
    <script type="text/javascript" src="js/schoolloader.js"></script>

    <div class="newusers">
        <div class="jumbotron" >
            <div class="container">
                <h1 align="left" >CAN'T FIND YOUR SCHOOL?</h1>
                <h2 align="right">BE THE FIRST. SIGN UP NOW!</h2>
                <button type="button" class="btn btn-lg"><a href="php/NewAccount.php" style="text-decoration: none">GET STARTED</a></button>
            </div>
        </div>
    </div>
</div>



<div class="footer">
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-9">
            <ul class = "nav nav-pills pull-left teal">
                <li role="presentation"><a href="html/About.html">About</a></li>
                <li role="presentation"><a href="html/Creators.html">Creators</a></li>
            </ul>
        </div>
        <div class="col-md-1">
            <ul class = "nav nav-pills pull-right teal">
                <li role="presentation"><a href="php/feedback_form.php">Feedback</a></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>

