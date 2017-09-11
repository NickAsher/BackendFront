<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$SortedIdsArray = isSecure_checkPostInput('__sortarray') ;
$CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;


$DBConnection = YOPDOSqlConnect() ;

foreach ($SortedIdsArray as $sortNo=>$ItemId){
    isSecure_isValidPositiveInteger(GetPostConst::None, $ItemId) ;
}


//print_r($SortedIdsArray) ;

//foreach ($SortedIdsArray as $sortNo=>$Id){
//    $RealSortNo = $sortNo + 1 ;
//    $Query = "UPDATE `demo` SET `item_sr_no` = '$RealSortNo' WHERE `item_id` = '$Id' " ;
//    $QueryResult = mysqli_query($DBConnection, $Query) ;
//    if($QueryResult){
//        continue ;
//    } else {
//        die("error in sorting for id $Id") ;
//    }
//}



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
$CaseStatement = '' ;
$CaseValues = array() ;
foreach ($SortedIdsArray as $sortNo=>$RelId){
    $RealSortNo = $sortNo + 1 ;
    $CaseStatement .= "WHEN `rel_id` = ? THEN ? " ;
    array_push($CaseValues, $RelId) ;
    array_push($CaseValues, $RealSortNo) ;

}




$Query = "UPDATE `menu_meta_addongroups_table` SET `addon_group_sr_no` = CASE $CaseStatement END WHERE `category_id` = ?  " ;
array_push($CaseValues, $CategoryId) ;
try{
$QueryResult = $DBConnection->prepare($Query) ;
$QueryResult->execute($CaseValues) ;
}catch(Exception $e){
    die("error in case statement");
}

echo "Success" ;


