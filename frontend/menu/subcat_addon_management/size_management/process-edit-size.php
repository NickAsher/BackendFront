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

    $Query = "UPDATE `menu_meta_size_table` SET `size_name` = '$SizeName' , `size_name_short` = '$SizeNameAbbr', `size_sr_no` = '$SizeSrNo', `size_is_active` = '$SizeIsActive'  WHERE `size_code` = '$SizeCode' AND `size_category_code` = '$CategoryCode'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("unable to update the new item  <br><br>".mysqli_error($DBConnectionBackend)) ;
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