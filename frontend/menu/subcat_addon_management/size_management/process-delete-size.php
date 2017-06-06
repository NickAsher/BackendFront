<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code');
$SizeCode = isSecure_checkPostInput('__size_code');
if(!isset($_POST['__is_delete'])){
    die("The delete action is not set") ;
}


$DBConnectionBackend = YOLOSqlConnect() ;



mysqli_begin_transaction($DBConnectionBackend) ;
try{

    $Query = "DELETE FROM `menu_meta_size_table` WHERE `size_category_code` = '$CategoryCode' AND `size_code` = '$SizeCode'  ";
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("unable to delete the item from menu_meta_size_table  <br><br>".mysqli_error($DBConnectionBackend)) ;
    }


    $Query2 = "DELETE FROM `menu_meta_rel_size-items_table` WHERE `item_category_code` = '$CategoryCode' AND `size_code` = '$SizeCode' " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Unable to delete the items from the menu_meta_rel_size-items_table: ".mysqli_error($DBConnectionBackend)) ;
    }

    $Query3 = "DELETE FROM `menu_meta_rel_size-addons_table` WHERE `category_code` = '$CategoryCode' AND `size_code` = '$SizeCode' " ;
    $QueryResult3 = mysqli_query($DBConnectionBackend, $Query3) ;
    if(!$QueryResult3){
        throw new Exception("Unable to delete the items from the menu_meta_rel_size-items_table: ".mysqli_error($DBConnectionBackend)) ;
    }




    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


    echo " 
        Size Variration Successfully deleted
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    echo $e ;
    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


}











?>