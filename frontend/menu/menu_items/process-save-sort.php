<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once $ROOT_FOLDER_PATH.'/vendor/autoload.php' ;


$SortedIdsArray = isSecure_checkPostInput('__sortarray') ;
$SubCategoryRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__subcategory_rel_id') ;


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
    $CaseStatement .= "WHEN `item_id` = ? THEN ? " ;
    array_push($CaseValues, $ItemId) ;
    array_push($CaseValues, $RealSortNo) ;


}

$Query = "UPDATE `menu_items_table` SET `item_sr_no` = CASE $CaseStatement END WHERE `item_subcategory_rel_id` = ?  " ;
array_push($CaseValues, $SubCategoryRelId) ; //this if for the SubcateogryRelId in the query
try{
$QueryResult = $DBConnection->prepare($Query) ;
$QueryResult->execute($CaseValues) ;
}catch (Exception $e){
    die( "Unable to sort the items : ".$e->getMessage() );
}

echo "Success" ;


