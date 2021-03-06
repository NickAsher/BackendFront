<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once $ROOT_FOLDER_PATH.'/vendor/autoload.php' ;


$SortedIdsArray = isSecure_checkPostInput('__sortarray') ;


$DBConnection = YOPDOSqlConnect() ;



foreach ($SortedIdsArray as $sortNo=>$ItemId){
    isSecure_isValidPositiveInteger(GetPostConst::None, $ItemId) ;
}






/*
 * SortedIdsArray
 *
 *      Array(
 *          [0] => 5,
 *          [1] => 6,
 *          [7] => 7
 *
 *
 *          )
 *
 *      $sortNo=>$ItemId
 */
$CaseStatement = '' ;
$CaseValues = array() ;
foreach ($SortedIdsArray as $sortNo=>$ItemId){
    $RealSortNo = $sortNo + 1 ;
    $CaseStatement .= "WHEN `category_id` = ? THEN ? " ;
    array_push($CaseValues, $ItemId) ;
    array_push($CaseValues, $RealSortNo) ;


}

$Query = "UPDATE `menu_meta_category_table` SET `category_sr_no` = CASE $CaseStatement END   " ;
try{
$QueryResult = $DBConnection->prepare($Query) ;
$QueryResult->execute($CaseValues) ;
}catch (Exception $e){
    die( "Unable to sort the items : ".$e->getMessage() );
}

echo "Success" ;


