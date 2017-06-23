<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$DBConnectionBackend = YOLOSqlConnect() ;

$AddonName = isSecure_checkPostInput('__addon_name') ;
$AddonImage = "empty";

$AddonCategoryCode = isSecure_checkPostInput('__addon_category_code') ;
$AddonGroupRelId = isSecure_checkPostInput('___addongroup_rel_id') ;
$AddonIsActive = isSecure_checkPostInput('__addon_is_active') ;

$AddonIsDefault = 'no' ;







mysqli_begin_transaction($DBConnectionBackend) ;
try{
    $Query = "INSERT INTO `menu_addons_table` (`item_sr_no`, `item_id`, `item_name`, `item_image`, `item_category_code`, `item_addon_group_rel_id`, `item_is_default`, `item_is_active` )
      SELECT MAX( `item_sr_no` ) + 1, '', '$AddonName', '$AddonImage', '$AddonCategoryCode', '$AddonGroupRelId', '$AddonIsDefault', '$AddonIsActive'
      FROM `menu_addons_table` WHERE `item_category_code` = '$AddonCategoryCode'    " ;




    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("Probelm in the addon insert query: ".mysqli_error($DBConnectionBackend)) ;
    }
    $NewItemId = mysqli_insert_id($DBConnectionBackend) ; //this is the last insert id


    $Query2 = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_code` = '$AddonCategoryCode' ORDER BY `size_sr_no` " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Probelm in the fetching the different sizes from menu_meta_size_table : ".mysqli_error($DBConnectionBackend)) ;
    }

    $VALUES = '' ;

    foreach ($QueryResult2 as $Record2){
        $SizeId = $Record2['size_id'] ;
        $AddonPriceForThatSize = isSecure_checkPostInput("__addon_price_size_$SizeId") ;
        $VALUES .= "('', '$NewItemId',  '$AddonPriceForThatSize', '$SizeId', '$AddonCategoryCode'), " ;
    }
    $VALUES = rtrim($VALUES, ", ") ;
    $Query3 = "INSERT INTO `menu_meta_rel_size-addons_table` VALUES $VALUES " ;
    if(!mysqli_query($DBConnectionBackend, $Query3)){
        throw new Exception("Problem in price size insert query ".mysqli_error($DBConnectionBackend)) ;
    }








    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;
    echo "
        Addon Item Successfully added
        <br><br>
        <a href='all-addons.php?'>Go Back</a>
    " ;

} catch (Exception $e){
    echo $e ;

    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;

}

















?>