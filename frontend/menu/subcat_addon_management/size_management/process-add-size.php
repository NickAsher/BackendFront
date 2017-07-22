<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$DBConnectionBackend = YOPDOSqlConnect() ;

$CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;
$SizeName = isSecure_IsValidText(GetPostConst::Post, '__size_name') ;
$SizeNameAbbr = isSecure_IsValidText(GetPostConst::Post, '__size_name_abbr') ;
$SizeIsActive = isSecure_IsYesNo(GetPostConst::Post, '__size_is_active') ;

$SizeIsDefault = 'false' ;




try {
    $ImageFileArrayVariable = $_FILES['__size_image'];
    $Size_ImageName = moveImageToImageFolder("$IMAGE_FOLDER_FILE_PATH/", $ImageFileArrayVariable);
} catch (Exception $e){
    die($e) ;
}

try{
    $DBConnectionBackend->beginTransaction() ;




    $Query = "INSERT INTO `menu_meta_size_table` (`size_sr_no`, `size_id`, `size_category_id`, `size_name`, `size_name_short`, `size_is_default`, `size_is_active`, `size_image`)
      SELECT COALESCE( (MAX( `size_sr_no` ) + 1), 1), '', :category_id , :size_name , :size_name_abbr , '$SizeIsDefault', :size_is_active , :size_image
      FROM `menu_meta_size_table` WHERE `size_category_id` = '$CategoryId'    " ;

    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'category_id'=>$CategoryId,
            'size_name'=>$SizeName,
            'size_name_abbr'=>$SizeNameAbbr,
            'size_is_active'=>$SizeIsActive,
            'size_image'=>$Size_ImageName
        ]);

    } catch (Exception $e) {
        throw new Exception("unable to insert the new item: ".$e) ;
    }


    $SizeId = $DBConnectionBackend->lastInsertId() ;






    $AllMenuItemsInThisCategory = getListOfAllMenuItemsInCategory_Array_PDO($DBConnectionBackend, $CategoryId) ;
    $InsertStatement_Item = '' ;


    foreach ($AllMenuItemsInThisCategory as $Record2){
        $ItemId = $Record2['item_id'] ;
        $ItemCategoryCode = $Record2['item_category_id'] ; //this is fetched to avoid prepared statement here.

        $InsertStatement_Item .= "('', '$ItemId', '0.0', 'no', '$SizeId', '$ItemCategoryCode'), " ;
    }
    $InsertStatement_Item = rtrim($InsertStatement_Item, ", ") ;


    $Query3 = "INSERT INTO `menu_meta_rel_size_items_table` VALUES $InsertStatement_Item " ;
    try {
        $QueryResult3 = $DBConnectionBackend->query($Query3);
    } catch (Exception $e) {
        throw new Exception("Problem in price size insert query for items ".$e) ;

    }










    $AllAddonItemsInThisCategory = getListOfAllAddonItemsInCategoryArray_PDO($DBConnectionBackend, $CategoryId) ;

    $InsertStatement_Addon = '' ;

    foreach ($AllAddonItemsInThisCategory as $Record4){
        $AddonId = $Record4['item_id'] ;
        $AddonCategoryCode = $Record4['item_category_id'] ;
        $InsertStatement_Addon .= "('', '$AddonId', '0.0', 'no', '$SizeId', '$AddonCategoryCode'), " ;
    }
    $InsertStatement_Addon = rtrim($InsertStatement_Addon, ", ") ;
    $Query5 = "INSERT INTO `menu_meta_rel_size_addons_table` VALUES $InsertStatement_Addon " ;
    try {
        $QueryResult5 = $DBConnectionBackend->query($Query5);
    } catch (Exception $e) {
        throw new Exception("Problem in price size insert query for Addons ".$e) ;
    }















    $DBConnectionBackend->commit() ;


    echo " 
        Addon-Group Successfully added
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    echo "Unable to add the item: ".$e->getMessage() ;

    $DBConnectionBackend->rollBack() ;

    deleteImageFromImageFolder("$IMAGE_FOLDER_FILE_PATH/", $Size_ImageName) ;




}


























?>