<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';

$MenuItemId = isSecure_checkPostInput('__menu_item_id');
$DBConnectionBackend = YOLOSqlConnect() ;


/*
 * This getting the info also checks whether a single row of item is returned or not.
 */
$ItemInfoArray = getSingleMenuItemInfoArray($DBConnectionBackend, $MenuItemId) ;
$MenuItemImageName = $ItemInfoArray['item_image_name'] ;





mysqli_begin_transaction($DBConnectionBackend) ;
try{

    $Query = "DELETE FROM `menu_items_table` WHERE `item_id` = '$MenuItemId' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query);
    if(!$QueryResult){
        throw new Exception("Unable to delete the item from menu_items_table : ".mysqli_error($DBConnectionBackend) ) ;
    }

    $Query2 = "DELETE FROM `menu_meta_rel_size-items_table` WHERE `item_id` = '$MenuItemId' " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2);
    if(!$QueryResult2){
        throw new Exception("Unable to delete the item prices from menu_meta_rel_size-items_table : ".mysqli_error($DBConnectionBackend) ) ;
    }



    $Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $MenuItemImageName) ;
    if(!$Del1){
        throw new Exception("Unable to delete the image, so cannot delete the item") ;
    }

    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;

    echo "
        Item Successfully deleted
        <br><br>
        <a href='all-menuitems.php'>Go Back</a>
    " ;

} catch (Exception $e){
    echo $e ;

    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


}

















?>