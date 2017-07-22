<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;

$ColumnToUpdate = isSecure_IsValidText(GetPostConst::Post, '__update_column') ;


$DBConnectionBackend = YOPDOSqlConnect() ;


$Query = "SELECT * FROM `sync_table` WHERE `id` = '1' ; " ;
try {
    $QueryResult = $DBConnectionBackend->query($Query);
    $AllSyncStates = $QueryResult->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e){
    die($e) ;
}


$OldValueOfThatCoumn = intval($AllSyncStates[$ColumnToUpdate]) ;
$NewValue = $OldValueOfThatCoumn + 1 ;



$Query2 = "UPDATE `sync_table`SET `$ColumnToUpdate` = '$NewValue' WHERE `id` = '1' ; " ;
try {
    $QueryResult2 = $DBConnectionBackend->query($Query2);
} catch (Exception $e){
    die($e) ;
}



echo "Sync Is Successfull" ;