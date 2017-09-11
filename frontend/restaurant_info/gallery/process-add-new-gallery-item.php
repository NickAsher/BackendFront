<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
$DBConnectionBackend = YOLOSqlConnect() ;
$DBConnection = YOPDOSqlConnect() ;




$ImageTitle = isSecure_IsValidText(GetPostConst::Post, '__newimage_title') ;
$ImageDescription = isSecure_IsValidText(GetPostConst::Post, '__newimage_description') ;


$ImageFileArrayVariable = $_FILES['__newimage_imageFile'] ;
$NewImageName = moveImageToImageFolder($DBConnectionBackend, $IMAGE_FOLDER_FILE_PATH, $ImageFileArrayVariable);
if($NewImageName == -1){
    die("error in image uoloading") ;
}


//$Query = "INSERT INTO `gallery_table` VALUES ('', :new_image_name, :new_image_title, :new_image_desc)  " ;
$Query = "INSERT INTO `gallery_table` (`gallery_item_sr_no`, `gallery_item_id`, `gallery_item_image_name`, `gallery_item_title`, `gallery_item_description`)
  SELECT COALESCE( (MAX( `gallery_item_sr_no` ) + 1), 1), '',  :new_image_name, :new_image_title, :new_image_desc FROM `gallery_table`  " ;

try{
    $QueryResult = $DBConnection->prepare($Query) ;
    $QueryResult->execute([
        'new_image_name'=>"$NewImageName",
        'new_image_title'=>"$ImageTitle",
        'new_image_desc'=>"$ImageDescription"
    ]) ;

    echo "Item Successfully added <a href='all-gallery-items.php' >GO Back</a>" ;
}catch (Exception $e){
    echo "unable to insert the new item: ".$e->getMessage() ;

}
























?>