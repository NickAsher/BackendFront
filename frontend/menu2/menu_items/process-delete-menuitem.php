<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once '../utils/menu-utils.php';


$MenuItemId = isSecure_checkPostInput('__menu_item_id');


$DBConnectionBackend = YOLOSqlConnect() ;


/*
 * This getting the info also checks whether a single row of item is returned or not.
 */
$ItemInfoArray = getSingleMenuItemInfoArray($DBConnectionBackend, $MenuItemId) ;
$MenuItemImageName = $ItemInfoArray['item_image_name'] ;



$Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $MenuItemImageName) ;
if($Del1){

    $Query = "DELETE FROM `menu_items_table` WHERE `item_id` = '$MenuItemId' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query);

    if ($QueryResult) {
        echo "
        Item Successfully deleted
        <br><br>
        <a href='all-menuitems.php'>Go Back</a>
    " ;

    } else {
        echo "error in deleteing item <br>" . mysqli_error($DBConnectionBackend);
    }


}













?>