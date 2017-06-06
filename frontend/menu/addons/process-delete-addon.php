<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code');
$AddonItemId = isSecure_checkPostInput('__addon_id');


$DBConnectionBackend = YOLOSqlConnect() ;






mysqli_begin_transaction($DBConnectionBackend) ;
try{

    $Query = "DELETE FROM `menu_addons_table` WHERE `item_id` = '$AddonItemId' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query);
    if(!$QueryResult){
        throw new Exception("Unable to delete the item from menu_addons_table : ".mysqli_error($DBConnectionBackend) ) ;
    }

    $Query2 = "DELETE FROM `menu_meta_rel_size-addons_table` WHERE `addon_id` = '$AddonItemId' " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2);
    if(!$QueryResult2){
        throw new Exception("Unable to delete the addon prices from menu_meta_rel_size-addon_table : ".mysqli_error($DBConnectionBackend) ) ;
    }


    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;

    echo "
        Addon-Item Successfully deleted
        <br><br>
        <a href='all-addons.php?'>Go Back</a>
    " ;

} catch (Exception $e){
    echo $e ;

    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


}







?>