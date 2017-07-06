<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOPDOSqlConnect() ;

$CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code') ;
$SizeName = isSecure_IsValidText(GetPostConst::Post, '__size_name') ;
$SizeNameAbbr = isSecure_IsValidText(GetPostConst::Post, '__size_name_abbr') ;
$SizeIsActive = isSecure_IsYesNo(GetPostConst::Post, '__size_is_active') ;

$SizeIsDefault = 'false' ;





try{
    $DBConnectionBackend->beginTransaction() ;

    $Query = "INSERT INTO `menu_meta_size_table` (`size_sr_no`, `size_id`, `size_category_code`, `size_name`, `size_name_short`, `size_is_default`, `size_is_active` )
      SELECT COALESCE( (MAX( `size_sr_no` ) + 1), 1), '', :category_code, :size_name, :size_name_abbr, '$SizeIsDefault', :size_is_active
      FROM `menu_meta_size_table` WHERE `size_category_code` = '$CategoryCode'    " ;

    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'category_code'=>$CategoryCode,
            'size_name'=>$SizeName,
            'size_name_abbr'=>$SizeNameAbbr,
            'size_is_active'=>$SizeIsActive
        ]);
    } catch (Exception $e) {
        throw new Exception("unable to insert the new item: ".$e->getMessage()) ;
    }


    $SizeId = $DBConnectionBackend->lastInsertId() ;






    $AllMenuItemsInThisCategory = getListOfAllMenuItemsInCategory_Array_PDO($DBConnectionBackend, $CategoryCode) ;
    $VALUES = '' ;

    foreach ($AllMenuItemsInThisCategory as $Record2){
        $ItemId = $Record2['item_id'] ;
        $ItemCategoryCode = $Record2['item_category_code'] ; //this is fetched to avoid prepared statement here.
        $VALUES .= "('', '$ItemId', '-1', '$SizeId', '$ItemCategoryCode'), " ;
    }
    $VALUES = rtrim($VALUES, ", ") ;
    $Query3 = "INSERT INTO `menu_meta_rel_size-items_table` VALUES $VALUES " ;
    try {
        $QueryResult3 = $DBConnectionBackend->query($Query3);
    } catch (Exception $e) {
        throw new Exception("Problem in price size insert query for items ".$e->getMessage()) ;

    }










    $AllAddonItemsInThisCategory = getListOfAllAddonItemsInCategoryArray_PDO($DBConnectionBackend, $CategoryCode) ;

    $VALUES = '' ;

    foreach ($AllAddonItemsInThisCategory as $Record4){
        $AddonId = $Record4['item_id'] ;
        $AddonCategoryCode = $Record4['item_category_code'] ;
        $VALUES .= "('', '$AddonId', '-1', '$SizeId', '$AddonCategoryCode'), " ;
    }
    $VALUES = rtrim($VALUES, ", ") ;
    $Query5 = "INSERT INTO `menu_meta_rel_size-addons_table` VALUES $VALUES " ;
    try {
        $QueryResult5 = $DBConnectionBackend->query($Query5);
    } catch (Exception $e) {
        throw new Exception("Problem in price size insert query for Addons ".$e->getMessage()) ;
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


}


























?>