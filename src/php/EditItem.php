<link type="text/css" rel="stylesheet" href="../css/itemedit_style.css">
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 */

session_start();
include "../html/Header.html";

//connect to db
//require ('mysqlconnection.php');

echo "<script type='text/javascript' src='../js/headermodifiers/checkouthead.js'></script>";

//main submit conditional
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //for processiong login
    require ('edititem_func.inc.php');

    //check login
    list($check, $data) = edititem($dbc, $_POST['title'], $_POST['description'], $_POST['type'], $_POST['condition'], $_POST['price'], $_GET['itemid']);
}

//print_r($_SESSION);
?>

<div class="headline jumbotron">
    <div class = "container">
        <h1 align="center">Edit Item</h1>
    </div>
</div>
<div class="infoinput">
    <div class = "container input">
        <form action="<?php echo "EditItem.php?itemid=" . $_GET['itemid'] . "&image=" . $_GET['image']?>" method="post">
            <fieldset class="fields container">
                <div class="row">
                    <div class="col-lg-1">
                        <a href='<?php echo "deleteitem.php?itemid=" . $_GET['itemid']?>' class='btn btn-default' role='button'>Delete Item</a>
                    </div>
                </div>
                <div class="row">
                    <div class="input col-lg-5">
                        <h1 align="center">Delivery Address</h1>
                        <input type="text" class="form-control" name="title" placeholder="Title" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['title'])) echo $_POST['title'];?>">
                        <input type="text" class="form-control" name="description" placeholder="Description" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['description'])) echo $_POST['description'];?>">
                        <input type="text" class="form-control" name="type" placeholder="Type" maxlength="2" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['type'])) echo $_POST['type'];?>">
                        <input type="text" class="form-control" name="condition" placeholder="Condition" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['condition'])) echo $_POST['condition'];?>">
                        <input type="text" class="form-control" name="price" placeholder="Price" maxlength="2" aria-describedby="basic-addon1"
                               value="<?php if(isset($_POST['price'])) echo $_POST['price'];?>">
                        <p class = "save" align="center">
                            <input type="submit" class="btn btn-default" name = "submit" value="Save"/>
                        </p>
                    </div>
                    <div class="col=lg-2"></div>
                    <div class="col-lg-5">
                        <?php
                        $image = $_GET['image'];
                        echo "<img align='center' class='img-rounded' src='$image'/>";
                        ?>
                    </div>
                </div>
            </fieldset>
        </form>
        <div class="row">
            <div class="col-lg-12">
                <form class="well" action="<?php echo "upload.php?image=" . "$image"?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Select a file to upload</label>
                        <input type="file" name="file">
                        <p class="help-block">Only jpg,jpeg,png and gif file with maximum size of 1 MB is allowed.</p>
                    </div>
                    <input type="submit" class="btn btn-lg btn-primary" value="Upload">
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "../html/Footer.html";
?>
