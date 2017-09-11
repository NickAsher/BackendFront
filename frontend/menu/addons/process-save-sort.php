<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$SortedIdsArray = isSecure_checkPostInput('__sortarray') ;
$AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addongroup_rel_id') ;


foreach ($SortedIdsArray as $sortNo=>$ItemId){
    isSecure_isValidPositiveInteger(GetPostConst::None, $ItemId) ;
}


$DBConnection = YOPDOSqlConnect() ;

$CaseStatement = '' ;
$CaseValues =array() ;
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
foreach ($SortedIdsArray as $sortNo=>$ItemId){
    $RealSortNo = $sortNo + 1 ;
    $CaseStatement .= "WHEN `item_id` = ? THEN  ? " ;
    array_push($CaseValues, $ItemId, $RealSortNo) ;


}




$Query = "UPDATE `menu_addons_table` SET `item_sr_no` = CASE $CaseStatement END WHERE `item_addon_group_rel_id` = '$AddonGroupRelId'  " ;
array_push($CaseValues, $AddonGroupRelId) ;
try {
    $QueryResult = $DBConnection->prepare($Query);
    $QueryResult->execute($CaseValues);
} catch (Exception $e) {
    die("error in case statement: ".$e) ;
}
echo "Success" ;



