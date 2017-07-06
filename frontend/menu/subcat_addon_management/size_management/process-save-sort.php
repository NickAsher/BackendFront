<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$SortedIdsArray = isSecure_checkPostInput('__sortarray') ;
$CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code') ;


foreach ($SortedIdsArray as $sortNo=>$ItemId){
    isSecure_isValidPositiveInteger(GetPostConst::None, $ItemId) ;
}

$DBConnection = YOPDOSqlConnect() ;



$CaseStatement = '' ;
$CaseValues = array() ;
/*
 * SortedIdsArray
 *      Array(
 *          [0] => 5,
 *          [1] => 6,
 *          [7] => 7
 *
 *
 *          )
 */
foreach ($SortedIdsArray as $sortNo=>$RelId){
    $RealSortNo = $sortNo + 1 ;
    $CaseStatement .= "WHEN `size_id` = ? THEN ? " ;
    array_push($CaseValues, $RelId) ;
    array_push($CaseValues, $RealSortNo) ;

}




$Query = "UPDATE `menu_meta_size_table` SET `size_sr_no` = CASE $CaseStatement END WHERE `size_category_code` = ?  " ;
array_push($CaseValues, $CategoryCode) ;

try{
    $QueryResult = $DBConnection->prepare($Query) ;
    $QueryResult->execute($CaseValues) ;
}catch(Exception $e){
    die("error in case statement");
}

echo "Success" ;


