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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //for processiong login
    require('edititem_func.inc.php');

    //check login
    list($check, $data) = newitem($dbc, $_POST['title'], $_POST['description'], $_POST['type'], $_POST['condition'], $_POST['price'], $_POST['make'], $_POST['model'], $_POST['year'], $_POST['isbn'], $_POST['author'], $_POST['edition'], $_POST['image']);
}

//print_r($_SESSION);
?>

<div class="headline jumbotron">
    <div class="container">
        <h1 align="center">Edit Item</h1>
    </div>
</div>
<div class="infoinput">
    <div class="container input">
        <form action="<?php echo 'NewItem.php' ?>" method="post">
            <fieldset class="fields container">
                <div class="row">
                    <div class="input col-lg-5">
                        <h1 align="center">Item Fields</h1>
                        <input type="text" class="form-control" name="title" placeholder="Title"
                               aria-describedby="basic-addon1"
                               value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
                        <input type="text" class="form-control" name="description" placeholder="Description"
                               aria-describedby="basic-addon1"
                               value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>">
                        <input type="text" class="form-control" name="type" placeholder="Type: (New or Used)"
                               aria-describedby="basic-addon1"
                               value="<?php if (isset($_POST['type'])) echo $_POST['type']; ?>">
                        <input type="text" class="form-control" name="condition"
                               placeholder="Condition: (Excellent, Good, Average, Poor)" aria-describedby="basic-addon1"
                               value="<?php if (isset($_POST['condition'])) echo $_POST['condition']; ?>">
                        <input type="text" class="form-control" name="price" placeholder="Price"
                               aria-describedby="basic-addon1"
                               value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>">
                        <input type="text" class="form-control" name="image"
                               placeholder="Image Name (Name of File associated with Item) (Optional)"
                               aria-describedby="basic-addon1"
                               value="<?php if (isset($_POST['image'])) echo $_POST['image']; ?>">
                    </div>
                    <div class="col=lg-2"></div>
                    <div class="input col-lg-5">
                        <div class="row">
                            <h1 align="center">For Electronics:</h1>
                            <input type="text" class="form-control" name="make" placeholder="Make"
                                   aria-describedby="basic-addon1"
                                   value="<?php if (isset($_POST['make'])) echo $_POST['make']; ?>">
                            <input type="text" class="form-control" name="model" placeholder="Model"
                                   aria-describedby="basic-addon1"
                                   value="<?php if (isset($_POST['model'])) echo $_POST['model']; ?>">
                            <input type="text" class="form-control" name="year" placeholder="Year"
                                   aria-describedby="basic-addon1"
                                   value="<?php if (isset($_POST['year'])) echo $_POST['year']; ?>">
                        </div>
                        <div class="row">
                            <h1 align="center">For Books</h1>
                            <input type="text" class="form-control" name="isbn" placeholder="ISBN Number"
                                   aria-describedby="basic-addon1"
                                   value="<?php if (isset($_POST['isbn'])) echo $_POST['isbn']; ?>">
                            <input type="text" class="form-control" name="author" placeholder="Author(s)"
                                   aria-describedby="basic-addon1"
                                   value="<?php if (isset($_POST['author'])) echo $_POST['author']; ?>">
                            <input type="text" class="form-control" name="edition" placeholder="Edition"
                                   aria-describedby="basic-addon1"
                                   value="<?php if (isset($_POST['edition'])) echo $_POST['edition']; ?>">
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <div class="row">
            <div class="col-lg-12">

                <form class="well" action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Select a file to upload</label>
                        <input type="file" name="file">

                        <p class="help-block">Only jpg,jpeg,png and gif file with maximum size of 1 MB is allowed.</p>
                    </div>
                    <input type="submit" class="btn btn-lg btn-primary" value="Save Item">
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "../html/Footer.html";
?>
