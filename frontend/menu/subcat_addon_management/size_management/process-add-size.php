<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOLOSqlConnect() ;

$CategoryCode = isSecure_checkPostInput('__category_code') ;
$SizeName = isSecure_checkPostInput('__size_name') ;
$SizeNameAbbr = isSecure_checkPostInput('__size_name_abbr') ;
$SizeIsActive = isSecure_checkPostInput('__size_is_active') ;





mysqli_begin_transaction($DBConnectionBackend) ;
try{


    $Query = "INSERT INTO `menu_meta_size_table` (`size_sr_no`, `size_id`, `size_category_code`, `size_name`, `size_name_short`, `size_is_default`, `size_is_active` )
      SELECT MAX( `size_sr_no` ) + 1, '', '$CategoryCode', '$SizeName', '$SizeNameAbbr', 'false', '$SizeIsActive'
      FROM `menu_meta_size_table` WHERE `size_category_code` = '$CategoryCode'    " ;

    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("unable to insert the new item  <br><br>".mysqli_error($DBConnectionBackend)) ;
    }

    $SizeId = mysqli_insert_id($DBConnectionBackend) ;

    $Query2 = "SELECT * FROM `menu_items_table` WHERE `item_category_code` = '$CategoryCode' " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Unable to fetch the items in menu_items_table for the category $CategoryCode <br>: ".mysqli_error($DBConnectionBackend)) ;
    }
    $VALUES = '' ;

    foreach ($QueryResult2 as $Record2){
        $ItemId = $Record2['item_id'] ;
        $VALUES .= "('', '$ItemId', '-1', '$SizeId', '$CategoryCode'), " ;
    }
    $VALUES = rtrim($VALUES, ", ") ;
    $Query3 = "INSERT INTO `menu_meta_rel_size-items_table` VALUES $VALUES " ;
    if(!mysqli_query($DBConnectionBackend, $Query3)){
        throw new Exception("Problem in price size insert query for items ".mysqli_error($DBConnectionBackend)) ;
    }














    $Query4 = "SELECT * FROM `menu_addons_table` WHERE `item_category_code` = '$CategoryCode' " ;
    $QueryResult4 = mysqli_query($DBConnectionBackend, $Query4) ;
    if(!$QueryResult4){
        throw new Exception("Unable to fetch the addons in menu_addons_table for the category $CategoryCode <br>: ".mysqli_error($DBConnectionBackend)) ;
    }
    $VALUES = '' ;

    foreach ($QueryResult4 as $Record4){
        $AddonId = $Record4['item_id'] ;
        $VALUES .= "('', '$AddonId', '-1', '$SizeId', '$CategoryCode'), " ;
    }
    $VALUES = rtrim($VALUES, ", ") ;
    $Query5 = "INSERT INTO `menu_meta_rel_size-addons_table` VALUES $VALUES " ;
    if(!mysqli_query($DBConnectionBackend, $Query5)){
        throw new Exception("Problem in price size insert query for Addons ".mysqli_error($DBConnectionBackend)) ;
    }













    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


    echo " 
        Addon-Group Successfully added
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    echo $e ;
    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


}


























?>