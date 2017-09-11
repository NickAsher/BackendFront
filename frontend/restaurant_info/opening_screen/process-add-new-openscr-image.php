<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
$DBConnectionBackend = YOPDOSqlConnect() ;
$DBConnectionBackend_Old = YOLOSqlConnect() ;



if(!isset($_FILES['__newimage_imageFile']) || empty($_FILES['__newimage_imageFile'])){
    die("The post data sent is empty") ;
}

$ImageFileArrayVariable = $_FILES['__newimage_imageFile'] ;
$NewImageName = moveImageToImageFolder($DBConnectionBackend_Old, $IMAGE_FOLDER_FILE_PATH, $ImageFileArrayVariable);
if($NewImageName == -1){
    die("error in image uoloading") ;
}



$Query = "INSERT INTO `opening_screen_images_table` (`item_sr_no`, `item_id`, `item_image`)
  SELECT COALESCE( (MAX( `item_sr_no` ) + 1), 1), '', :new_image_name FROM `opening_screen_images_table` " ;
try {
    $QueryResult = $DBConnectionBackend->prepare($Query);
    $QueryResult->execute(['new_image_name' => $NewImageName]);

    echo "
        Item Successfully added
        <div>
            <a href='all-openscr-images.php'>Go Back </a>
        </div>
    " ;

} catch (Exception $e) {

    echo "Unable to add the new image to the database: ".$e ;

    try {
        $Del1 = deleteImageFromImageFolderNew($IMAGE_FOLDER_FILE_PATH, $NewImageName);
        echo "<br> Deleted the image so " ;
    }catch (Exception $e){
        throw new Exception("Unable to delete the image from image folder : ".$e );
    }



}























?>