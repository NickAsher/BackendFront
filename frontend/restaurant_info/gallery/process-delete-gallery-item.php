<?php


require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'utils/gallery-utils.php';

$GalleryItemId = isSecure_checkPostInput('__gallery_id') ;
$DBConnectionBackend = YOLOSqlConnect() ;
$GalleryInfoArray = getGalleryItemInfo($DBConnectionBackend, $GalleryItemId) ;
if($GalleryInfoArray == -1){
    die("Unable to get the gallery item information ") ;
}


$GalleryItem_ImageName = $GalleryInfoArray['gallery_item_image_name'] ;


$Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $GalleryItem_ImageName) ;


if($Del1 != -1  ){
    $Query = "DELETE FROM `gallery_table` WHERE `gallery_item_id` = '$GalleryItemId'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if($QueryResult){
        echo "Succesfully deleted the item " ;
    } else {
        echo "unable to delete the blog post <br> ".mysqli_error($DBConnectionBackend) ;
    }
}






?>

<div >
    <a href='all-gallery-items.php'>
        Show All posts
    </a>
</div>
