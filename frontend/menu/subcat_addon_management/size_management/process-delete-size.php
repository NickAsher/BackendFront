<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code');
$SizeId = isSecure_checkPostInput('__size_id');

if(!isset($_POST['__is_delete'])){
    die("The delete action is not set") ;
}


$DBConnectionBackend = YOLOSqlConnect() ;



mysqli_begin_transaction($DBConnectionBackend) ;
try{


    $Table1 = "menu_meta_size_table" ;
    $Table2 = "menu_meta_rel_size-items_table" ;
    $Table3 = "menu_meta_rel_size-addons_table" ;


    $Query1 = "DELETE `$Table1` , `$Table2` , `$Table3` 
      FROM `$Table1`   INNER JOIN `$Table2`  INNER JOIN `$Table3`  
      ON `$Table1`.`size_id` =  `$Table2`.`size_id`  AND `$Table1`.`size_id` = `$Table3`.`size_id` 
        AND `$Table1`.`size_category_code` =  `$Table2`.`item_category_code`  AND `$Table1`.`size_category_code` = `$Table3`.`category_code`
      WHERE `$Table1`.`size_category_code` = '$CategoryCode' AND `$Table1`.`size_id` = '$SizeId'  ";


    if(!mysqli_query($DBConnectionBackend, $Query1)){
        throw new Exception("Problem in the delete query for size table   <br><br>".mysqli_error($DBConnectionBackend)) ;
    }

//    $NumOfAffectedRows = mysqli_affected_rows($DBConnectionBackend) ;







    /*
     * This query is used to re-sort the Sr No of the Sizes
     */


    $Query2 = "SELECT * FROM `$Table1` WHERE `size_category_code` = '$CategoryCode' ORDER BY `size_sr_no` ASC " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Unable to fetch the sizes to sort") ;
    }

    $CaseStatement = '' ;
    $RealSortNo = 1 ;
    foreach ($QueryResult2 as $Record2){
        $ThisSize_SizeId = $Record2['size_id'] ;
        $CaseStatement .= "WHEN `size_id` = '$ThisSize_SizeId' THEN '$RealSortNo' " ;
        $RealSortNo ++ ;
    }

    $Query = "UPDATE `$Table1` SET `size_sr_no` = CASE $CaseStatement END WHERE `size_category_code` = '$CategoryCode'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("Error in sorting the new Subcategories: ".mysqli_error($DBConnectionBackend)) ;
    }





    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


    echo " 
        Size Variration Successfully deleted, 
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    echo $e ;
    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


}











?>