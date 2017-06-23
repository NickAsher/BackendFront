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
$ItemSubcategoryRelId = $ItemInfoArray['item_subcategory_rel_id'] ;

$MenuItemImageName = $ItemInfoArray['item_image_name'] ;





mysqli_begin_transaction($DBConnectionBackend) ;
try{


    $Table1 = "menu_items_table" ;
    $Table2 = "menu_meta_rel_size-items_table" ;

    $Query1 = "DELETE `$Table1` , `$Table2`  FROM `$Table1` INNER JOIN `$Table2`
      ON `$Table1`.`item_id` =  `$Table2`.`item_id` 
      WHERE `$Table1`.`item_id` = '$MenuItemId' ";

    $QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
    if(!$QueryResult1){
        throw new Exception("Unable to delete the Menu Item: ".mysqli_error($DBConnectionBackend) ) ;
    }




    $Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $MenuItemImageName) ;
    if(!$Del1){
        throw new Exception("Unable to delete the image, so cannot delete the item") ;
    }






    $Query2 = "SELECT * FROM `$Table1` WHERE `item_subcategory_rel_id` = '$ItemSubcategoryRelId' ORDER BY `item_sr_no` ASC " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Unable to fetch the items to sort them ".mysqli_error($DBConnectionBackend) ) ;
    }

    $CaseStatement = '' ;
    $RealSortNo = 1 ;
    foreach ($QueryResult2 as $Record2){
        $ThisItem_ItemId = $Record2['item_id'] ;
        $CaseStatement .= "WHEN `item_id` = '$ThisItem_ItemId' THEN '$RealSortNo' " ;
        $RealSortNo ++ ;
    }

    $Query3 = "UPDATE `$Table1` SET `item_sr_no` = CASE $CaseStatement END WHERE `item_subcategory_rel_id` = '$ItemSubcategoryRelId'  " ;
    $QueryResult3 = mysqli_query($DBConnectionBackend, $Query3) ;
    if(!$QueryResult3){
        throw new Exception("Error in sorting the new Menutes: ".mysqli_error($DBConnectionBackend)) ;
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