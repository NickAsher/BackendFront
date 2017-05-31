<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
$DBConnectionBackend = YOLOSqlConnect() ;



if(!isset($_POST['__newimage_title']) || empty($_POST['__newimage_title'])){
    die("The post data sent is empty") ;
}

$ImageFileArrayVariable = $_FILES['__newimage_imageFile'] ;
$NewImageName = moveImageToImageFolder($DBConnectionBackend, $IMAGE_FOLDER_FILE_PATH, $ImageFileArrayVariable);
if($NewImageName == -1){
    die("error in image uoloading") ;
}
$ImageTitle = $_POST['__newimage_title'] ;
$ImageDescription = $_POST['__newimage_description'] ;


$Query = "INSERT INTO `gallery_table` VALUES ('', '$NewImageName', '$ImageTitle', '$ImageDescription')  " ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;

if($QueryResult){
    echo "Item Successfully added" ;
    header("location:all-gallery-items.php") ;
} else {
    echo "unable to insert the new item  <br><br>".mysqli_error($DBConnectionBackend) ;
}





















?>