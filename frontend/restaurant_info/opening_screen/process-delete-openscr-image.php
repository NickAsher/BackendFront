<?php

require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$ItemId = isSecure_checkPostInput('__item_id') ;



$DBConnectionBackend = YOLOSqlConnect() ;
$GalleryInfoArray = null ;
$Query = "SELECT * FROM `opening_screen_image_table` WHERE `item_id` = '$ItemId' " ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
if($QueryResult){
    if(mysqli_num_rows($QueryResult) != 1){
        die("No of rows returned is not 1") ;
    }


} else {
    die("error in fetching the item <br> ".mysqli_error($DBConnectionBackend)) ;
}

$GalleryInfoArray = mysqli_fetch_assoc($QueryResult) ;



$GalleryItem_ImageName = $GalleryInfoArray['item_image'] ;


$Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $GalleryItem_ImageName) ;


if($Del1 != -1  ){
    $Query = "DELETE FROM `opening_screen_image_table` WHERE `item_id` = '$ItemId'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if($QueryResult){
        echo "Succesfully deleted the item " ;
    } else {
        echo "unable to delete the opening screen image <br> ".mysqli_error($DBConnectionBackend) ;
    }
}






?>

<div >
    <a href='all-openscr-images.php'>
        Show All posts
    </a>
</div>
