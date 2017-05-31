<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$CategoryCode =  isSecure_checkPostInput('__category_code');
$AddonItemId = isSecure_checkPostInput('__addon_item_id');
$AddonItemName = isSecure_checkPostInput('__addon_item_name');

$ItemNoOfSizeVariations = isSecure_checkPostInput('__item_no_of_size_variations') ;



$DBConnectionBackend = YOLOSqlConnect() ;










mysqli_begin_transaction($DBConnectionBackend) ;
try{

    $Query = "UPDATE `menu_addons_table` SET `item_name` = '$AddonItemName' WHERE `item_id` = '$AddonItemId' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("Probelm in the item update query: ".mysqli_error($DBConnectionBackend)) ;
    }




    for($i=1; $i<=$ItemNoOfSizeVariations; $i++){
        $ItemPriceSize = isSecure_checkPostInput("__addon_price_size$i") ;

        $Query2 = "UPDATE `menu_meta_rel_size-addons_table` SET `addon_price` = '$ItemPriceSize' WHERE `addon_id` = '$AddonItemId' AND `size_sr_no` = '$i' " ;
        if(!mysqli_query($DBConnectionBackend, $Query2)){
            throw new Exception("Problem in price size update query $i : ".mysqli_error($DBConnectionBackend)) ;
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