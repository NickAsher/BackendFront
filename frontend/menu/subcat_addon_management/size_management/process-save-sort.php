<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$SortedIdsArray = isSecure_checkPostInput('__sortarray') ;
$CategoryCode = isSecure_checkPostInput('__category_code') ;


$DBConnection = YOLOSqlConnect() ;


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


$CaseStatement = '' ;
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
    $CaseStatement .= "WHEN `size_id` = '$RelId' THEN '$RealSortNo' " ;

}




$Query = "UPDATE `menu_meta_size_table` SET `size_sr_no` = CASE $CaseStatement END WHERE `size_category_code` = '$CategoryCode'  " ;
$QueryResult = mysqli_query($DBConnection, $Query) ;
if(!$QueryResult){
    die("error in case statement") ;
}

echo "Success" ;


