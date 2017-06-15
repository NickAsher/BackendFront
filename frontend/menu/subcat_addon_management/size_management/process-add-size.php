<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOLOSqlConnect() ;

$CategoryCode = isSecure_checkPostInput('__category_code') ;
$SizeSrNo = isSecure_checkPostInput('__size_sr_no') ;
$SizeCode = isSecure_checkPostInput('__size_code') ;
$SizeName = isSecure_checkPostInput('__size_name') ;
$SizeNameAbbr = isSecure_checkPostInput('__size_name_abbr') ;
$SizeIsActive = isSecure_checkPostInput('__size_is_active') ;





mysqli_begin_transaction($DBConnectionBackend) ;
try{

    $Query = "INSERT INTO `menu_meta_size_table` VALUES ('', '$SizeSrNo', '$CategoryCode', '$SizeCode', '$SizeName', '$SizeNameAbbr' , 'false', '$SizeIsActive')  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("unable to insert the new item  <br><br>".mysqli_error($DBConnectionBackend)) ;
    }


    $Query2 = "SELECT * FROM `menu_items_table` WHERE `item_category_code` = '$CategoryCode' " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Unable to fetch the items in menu_items_table for the category $CategoryCode <br>: ".mysqli_error($DBConnectionBackend)) ;
    }
    foreach ($QueryResult2 as $Record2){
        $ItemId = $Record2['item_id'] ;
        $Query3 = "INSERT INTO `menu_meta_rel_size-items_table` VALUES('', '$ItemId', '-1', '$SizeCode', '$CategoryCode')" ;
        $QueryResult3 = mysqli_query($DBConnectionBackend, $Query3) ;
        if(!$QueryResult3){
            throw new Exception("Unable to insert new item price for id $ItemId: ".mysqli_error($DBConnectionBackend)) ;
        }
    }

    $Query4 = "SELECT * FROM `menu_addons_table` WHERE `item_category_code` = '$CategoryCode' " ;
    $QueryResult4 = mysqli_query($DBConnectionBackend, $Query4) ;
    if(!$QueryResult4){
        throw new Exception("Unable to fetch the addons in menu_addons_table for the category $CategoryCode <br>: ".mysqli_error($DBConnectionBackend)) ;
    }
    foreach ($QueryResult4 as $Record4){
        $AddonId = $Record4['item_id'] ;
        $Query5 = "INSERT INTO `menu_meta_rel_size-addons_table` VALUES('', '$AddonId', '-1', '$SizeCode', '$CategoryCode')" ;
        $QueryResult5 = mysqli_query($DBConnectionBackend, $Query5) ;
        if(!$QueryResult5){
            throw new Exception("Unable to insert new addon price for id $AddonId: ".mysqli_error($DBConnectionBackend)) ;
        }
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