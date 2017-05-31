<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once '../utils/menu-utils.php';


$DBConnectionBackend = YOLOSqlConnect() ;

$ItemName = isSecure_checkPostInput('__item_name') ;
$ItemDescription = isSecure_checkPostInput('__item_description') ;
$ItemCategory = isSecure_checkPostInput('__item_category') ;
$ItemSubCategory = isSecure_checkPostInput('__item_subcategory') ;


$ItemNoOfSizeVariations = isSecure_checkPostInput('__item_no_of_size_variations') ;


$ImageFileArrayVariable = $_FILES['__item_image'] ;
$Item_ImageName = moveImageToImageFolder($DBConnectionBackend, "$IMAGE_FOLDER_FILE_PATH/", $ImageFileArrayVariable);
if($Item_ImageName == -1){
    die("error in image uoloading") ;
}




mysqli_begin_transaction($DBConnectionBackend) ;
try{
        $Query = "INSERT INTO `menu_items_table` 
      VALUES ('', '$ItemName', '$ItemDescription', '$Item_ImageName', '$ItemCategory', '$ItemSubCategory' )  " ;

        $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
        if(!$QueryResult){
            throw new Exception("Probelm in the item insert query: ".mysqli_error($DBConnectionBackend)) ;
        }
        $NewItemId = mysqli_insert_id($DBConnectionBackend) ; //this is the last insert id

        for($i=1; $i<=$ItemNoOfSizeVariations; $i++){
            $ItemPriceSize = isSecure_checkPostInput("__item_price_size$i") ;
            $Query2 = "INSERT INTO `menu_meta_rel_size-items_table` VALUES('', '$NewItemId', '$i',  '$ItemPriceSize') " ;
            if(!mysqli_query($DBConnectionBackend, $Query2)){
                throw new Exception("Problem in price size insert query $i : ".mysqli_error($DBConnectionBackend)) ;
            }
        }


        mysqli_commit($DBConnectionBackend) ;
        mysqli_autocommit($DBConnectionBackend, true) ;
        echo "
        Item Successfully added
        <br><br>
        <a href='all-menuitems.php' >Go Back</a>
    " ;

} catch (Exception $e){
        echo $e ;

        mysqli_rollback($DBConnectionBackend) ;
        mysqli_autocommit($DBConnectionBackend, true) ;



        $Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $Item_ImageName) ;
        if($Del1){
            echo "unable to insert the new item , so deleted the image  <br><br>".mysqli_error($DBConnectionBackend) ;
        }
        echo "unable to insert the new item and image deletion also failed <br><br>".mysqli_error($DBConnectionBackend) ;
}




























?>