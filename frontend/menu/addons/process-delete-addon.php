<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$AddonGroupRelId = isSecure_checkPostInput('__addon_group_rel_id');
$AddonItemId = isSecure_checkPostInput('__addon_id');

$DBConnectionBackend = YOLOSqlConnect() ;






mysqli_begin_transaction($DBConnectionBackend) ;
try{

    $Table1 = "menu_addons_table" ;
    $Table2 = "menu_meta_rel_size-addons_table" ;

    $Query1 = "DELETE `$Table1` , `$Table2`  FROM `$Table1` INNER JOIN `$Table2`
      ON `$Table1`.`item_id` =  `$Table2`.`addon_id` 
      WHERE `$Table1`.`item_id` = '$AddonItemId' ";

    $QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
    if(!$QueryResult1){
        throw new Exception("Unable to delete the Addon Item: ".mysqli_error($DBConnectionBackend) ) ;
    }





    $Query2 = "SELECT * FROM `$Table1` WHERE `item_addon_group_rel_id` = '$AddonGroupRelId' ORDER BY `item_sr_no` ASC " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Unable to fetch the items to sort them ".mysqli_error($DBConnectionBackend) ) ;
    }

    $CaseStatement = '' ;
    $RealSortNo = 1 ;
    foreach ($QueryResult2 as $Record2){
        $ThisItem_ItemId = $Record2['item_id'] ;
        $CaseStatement .= "WHEN `item_id` = '$ThisItem_ItemId' THEN '$RealSortNo' " ;
        $RealSortNo ++ ;
    }

    $Query3 = "UPDATE `$Table1` SET `item_sr_no` = CASE $CaseStatement END WHERE `item_addon_group_rel_id` = '$AddonGroupRelId'  " ;
    $QueryResult3 = mysqli_query($DBConnectionBackend, $Query3) ;
    if(!$QueryResult3){
        throw new Exception("Error in sorting the new Addon Items: ".mysqli_error($DBConnectionBackend)) ;
    }




    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;

    echo "
        Addon-Item Successfully deleted
        <br><br>
        <a href='all-addons.php?'>Go Back</a>
    " ;

} catch (Exception $e){
    echo $e ;

    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


}







?>