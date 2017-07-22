<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';

$MenuItemId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__menu_item_id');

$DBConnectionBackend = YOPDOSqlConnect() ;





/*
 * This getting the info also checks whether a single row of item is returned or not.
 */
$ItemInfoArray = getSingleMenuItemInfoArray_PDO($DBConnectionBackend, $MenuItemId) ;
$ItemSubcategoryRelId = $ItemInfoArray['item_subcategory_rel_id'] ;

$MenuItemImageName = $ItemInfoArray['item_image_name'] ;





try {
    $DBConnectionBackend->beginTransaction() ;


    $Table1 = "menu_items_table";
    $Table2 = "menu_meta_rel_size_items_table";

    $Query1 = "DELETE `$Table1` , `$Table2`  FROM `$Table1` INNER JOIN `$Table2`
      ON `$Table1`.`item_id` =  `$Table2`.`item_id` 
      WHERE `$Table1`.`item_id` = :item_id  ";
    try{
    $QueryResult1 = $DBConnectionBackend->prepare($Query1);
    $QueryResult1->execute(['item_id' => $MenuItemId]);
    }catch(Exception $e) {
        throw new Exception("Unable to delete the Menu Item: " . $e->getMessage());
    }




    $Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $MenuItemImageName) ;
    if(!$Del1){
        throw new Exception("Unable to delete the image, so cannot delete the item") ;
    }



    /*
     * This is the code to sort the remaining items after deleting an item
     *      1. Firstly we fetch all the items in subcategory
     *      2. Then we see if NoOfItems is not 0 (case when last item is deleted)
     *          2.1 If not zero then sort them using a case statement
     *          2.2 If zero then simply don't do anything
     */

    $AllMenuItemsInSubCategory = getListOfAllMenuItemsInSubCategory_Array_PDO($DBConnectionBackend, $ItemSubcategoryRelId) ;
    if(count($AllMenuItemsInSubCategory) != 0 ){


        $CaseStatement = '' ;
        $RealSortNo = 1 ;
        foreach ($AllMenuItemsInSubCategory as $Record2){
            $ThisItem_ItemId = $Record2['item_id'] ;
            $CaseStatement .= "WHEN `item_id` = '$ThisItem_ItemId' THEN '$RealSortNo' " ;
            $RealSortNo ++ ;
        }

        $Query3 = "UPDATE `$Table1` SET `item_sr_no` = CASE $CaseStatement END WHERE `item_subcategory_rel_id` = '$ItemSubcategoryRelId'  " ;
        try {
            $QueryResult3 = $DBConnectionBackend->query($Query3);
        }catch (Exception $e){
            throw new Exception("Error in sorting the new Menuitems: ". $e->getMessage());
        }
    }


















    $DBConnectionBackend->commit() ;


    echo "
        Item Successfully deleted
        <br><br>
        <a href='all-menuitems.php'>Go Back</a>
    " ;

} catch (Exception $e){
    echo "Unable to delete the item, but it's image has been deleted: ".$e->getMessage() ;

    $DBConnectionBackend->rollBack() ;


}

















?>