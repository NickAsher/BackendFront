<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';

$DBConnectionBackend = YOLOSqlConnect() ;

$ItemName = isSecure_checkPostInput('__item_name') ;
$ItemDescription = isSecure_checkPostInput('__item_description') ;
$ItemCategory = isSecure_checkPostInput('__item_category') ;
$ItemSubCategoryRelId = isSecure_checkPostInput('__item_subcategory_rel_id') ;
$ItemIsActive = isSecure_checkPostInput('__item_is_active') ;




$ImageFileArrayVariable = $_FILES['__item_image'] ;
$Item_ImageName = moveImageToImageFolder($DBConnectionBackend, "$IMAGE_FOLDER_FILE_PATH/", $ImageFileArrayVariable);
if($Item_ImageName == -1){
    die("error in image uoloading") ;
}




mysqli_begin_transaction($DBConnectionBackend) ;
try{



        $Query = "INSERT INTO `menu_items_table` 
          VALUES ('', '$ItemName', '$ItemDescription', '$Item_ImageName', '$ItemCategory', '$ItemSubCategoryRelId', '$ItemIsActive' )  " ;

        $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
        if(!$QueryResult){
            throw new Exception("Probelm in the item insert query: ".mysqli_error($DBConnectionBackend)) ;
        }
        $NewItemId = mysqli_insert_id($DBConnectionBackend) ; //this is the last insert id (The item id of new product)


        $Query2 = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_code` = '$ItemCategory' ORDER BY `size_sr_no` " ;
        $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
        if(!$QueryResult2){
            throw new Exception("Probelm in the fetching the different sizes from menu_meta_size_table : ".mysqli_error($DBConnectionBackend)) ;
        }
        foreach ($QueryResult2 as $Record2){

            $SizeId = $Record2['size_id'] ;
            $SizeName = $Record2['size_name'] ;
            $ItemPriceForThatSize = isSecure_checkPostInput("__item_price_size_$SizeId") ;
            $Query3 = "INSERT INTO `menu_meta_rel_size-items_table` VALUES('', '$NewItemId',  '$ItemPriceForThatSize', '$SizeId', '$ItemCategory') " ;
            if(!mysqli_query($DBConnectionBackend, $Query3)){
                throw new Exception("Problem in price size insert query for size $SizeName : ".mysqli_error($DBConnectionBackend)) ;
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



        // since we failed to insert the new item in the database,  so here we are deleting the image that we inserted
        $Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $Item_ImageName) ;
        if($Del1){
            echo "<br> unable to insert the new item , so deleted the image  <br>" ;
        } else {
            echo "<br> unable to insert the new item and image deletion also failed <br>" ;
        }
}




























?>