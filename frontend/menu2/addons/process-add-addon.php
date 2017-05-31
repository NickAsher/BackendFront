<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
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

    for($i=1; $i<=$ItemNoOfSizeVariations; $i++){
        $ItemPriceSize = isSecure_checkPostInput("__addon_price_size$i") ;
        $Query2 = "INSERT INTO `menu_meta_rel_size-addons_table` VALUES('', '$NewItemId', '$i',  '$ItemPriceSize') " ;
        if(!mysqli_query($DBConnectionBackend, $Query2)){
            throw new Exception("Problem in price size insert query $i : ".mysqli_error($DBConnectionBackend)) ;
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