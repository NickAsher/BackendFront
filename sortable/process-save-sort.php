<?php

require_once '../sql/sqlconnection.php' ;
require_once '../security/input-security.php' ;

$SortedIdsArray = isSecure_checkPostInput('__sortarray') ;

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
foreach ($SortedIdsArray as $sortNo=>$Id){
    $RealSortNo = $sortNo + 1 ;
    $CaseStatement .= "WHEN `item_id` = '$Id' THEN '$RealSortNo' " ;

}




$Query = "UPDATE `demo` SET `item_sr_no` = CASE $CaseStatement END " ;
$QueryResult = mysqli_query($DBConnection, $Query) ;
if(!$QueryResult){
    die("error in case statement") ;
}

echo "$Query" ;


