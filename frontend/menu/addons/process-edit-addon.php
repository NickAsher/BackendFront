<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$CategoryCode =  isSecure_checkPostInput('__category_code');
$AddonItemId = isSecure_checkPostInput('__addon_item_id');
$AddonItemName = isSecure_checkPostInput('__addon_item_name');
$AddonIsActive = isSecure_checkPostInput('__addon_is_active') ;

$ItemNoOfSizeVariations = '0' ;



$DBConnectionBackend = YOLOSqlConnect() ;










mysqli_begin_transaction($DBConnectionBackend) ;
try{

    $Query = "UPDATE `menu_addons_table` SET `item_name` = '$AddonItemName', `item_is_active` = '$AddonIsActive' WHERE `item_id` = '$AddonItemId' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("Probelm in the item update query: ".mysqli_error($DBConnectionBackend)) ;
    }


    $Query2 = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_code` = '$CategoryCode' ORDER BY `size_sr_no` " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Probelm in the fetching the different sizes from menu_meta_size_table : ".mysqli_error($DBConnectionBackend)) ;
    }
    foreach ($QueryResult2 as $Record2){
        $SizeCode = $Record2['size_code'] ;
        $AddonPriceForThatSize = isSecure_checkPostInput("__addon_price_size_$SizeCode") ;

        $Query3 = "UPDATE `menu_meta_rel_size-addons_table` SET `addon_price` = '$AddonPriceForThatSize' WHERE `addon_id` = '$AddonItemId' AND `size_code` = '$SizeCode' " ;
        if(!mysqli_query($DBConnectionBackend, $Query3)){
            throw new Exception("Problem in price update query for size code $SizeCode : ".mysqli_error($DBConnectionBackend)) ;
        }
    }




    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;



    echo "
        Addon-Item Successfully Updated
        <br><br>
        <a href='all-addons.php?'>Go Back</a>
    " ;







} catch (Exception $e){
    echo $e ;

    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;








}

?>