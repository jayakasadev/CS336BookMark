<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jaya
 *
 * Page displays images
 */

$name = FALSE; //flag variable

//check for image name in url:
if(isset($_GET['image'])){
    //make sure it has an image's extension
    $ext = strtolower(substr($_GET['image'], -4));

    if(($ext == '.jpg') OR ($ext = '.jpeg') OR ($ext = '.png')){
        //full image path
        $image = "../../../uploads/{$_GET['image']}";

        //check if image exists and is a file
        if(file_exists($image) && is_file($image)){
            //echo "file exists";

            //set name as this image
            $name = $_GET['image'];
        }
    }
}

//if there is an issue, use the default image
if(!$name){
    //echo "file DNE";
    $image = '../img/unavailable.png';
    $name = 'unavailable.png';
}

//get image info
$info = getimagesize($image);
$fs = filesize($image);

//send the content information
header("Content-Type: {$info['mime']}\n");
header("Content-Disposition: inline; filename=\"$name\"\n");
header("Content-Length: $fs\n");

//send the file
readfile($image);
