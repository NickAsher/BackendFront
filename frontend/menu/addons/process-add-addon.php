<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$DBConnectionBackend = YOLOSqlConnect() ;

$AddonName = isSecure_checkPostInput('__addon_name') ;
$AddonImage = "empty";

$AddonCategoryCode = isSecure_checkPostInput('__addon_category_code') ;
$AddonGroupCode = isSecure_checkPostInput('__addon_group_code') ;
$ItemNoOfSizeVariations = isSecure_checkPostInput('__item_no_of_size_variations') ;

$AddonIsDefault = 'no' ;







mysqli_begin_transaction($DBConnectionBackend) ;
try{
    $Query = "INSERT INTO `menu_addons_table` 
            VALUES ('', '$AddonName', '$AddonImage', '$AddonCategoryCode', '$AddonGroupCode', '$AddonIsDefault', $ItemNoOfSizeVariations)  " ;

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
    foreach ($QueryResult2 as $Record2){
        $SizeCode = $Record2['size_code'] ;
        $AddonPriceForThatSize = isSecure_checkPostInput("__addon_price_size_$SizeCode") ;
        $Query3 = "INSERT INTO `menu_meta_rel_size-addons_table` VALUES('', '$NewItemId',  '$AddonPriceForThatSize', '$SizeCode', '$AddonCategoryCode') " ;
        if(!mysqli_query($DBConnectionBackend, $Query3)){
            throw new Exception("Problem in price size insert query for size $SizeCode : ".mysqli_error($DBConnectionBackend)) ;
        }
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