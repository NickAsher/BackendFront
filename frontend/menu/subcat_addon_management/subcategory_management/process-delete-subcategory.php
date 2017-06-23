<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code') ;
$SubCategoryRelId = isSecure_checkPostInput('__subcategory_rel_id') ;


$DBConnectionBackend = YOLOSqlConnect() ;

mysqli_begin_transaction($DBConnectionBackend) ;
try{




    $Query1 = "SELECT * FROM `menu_meta_rel_category-subcategory_table` WHERE `rel_id` = '$SubCategoryRelId' " ;
    $QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
    if(mysqli_num_rows($QueryResult1) != 1){
        throw new Exception("No Of rows returned is not 1 so unable to delete the subcategory") ;

    }




    $Table1 = "menu_meta_rel_category-subcategory_table" ;
    $Table2 = "menu_items_table" ;
    $Table3 = "menu_meta_rel_size-items_table" ;

    $Query2 = "DELETE `$Table1` , `$Table2` , `$Table3` 
      FROM `$Table1`   INNER JOIN `$Table2`  INNER JOIN `$Table3`  
      ON `$Table2`.`item_subcategory_rel_id` =  `$Table1`.`rel_id`  AND `$Table2`.`item_id` = `$Table3`.`item_id`
      WHERE `$Table1`.`rel_id` = '$SubCategoryRelId' ";

    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Unable to delete the subcategory: ".mysqli_error($DBConnectionBackend) ) ;
    }


    /*
     * this is the case that a subcategory is there but there are no items in it. In that case
     * Query2 will delete 0 rows because of join ON condition . So this is done to just delete the subcategory
     */
    if(mysqli_affected_rows($DBConnectionBackend) == 0) {
        $Query3 = "DELETE FROM `$Table1` WHERE `rel_id` = '$SubCategoryRelId'   " ;
        $QueryResult3 = mysqli_query($DBConnectionBackend, $Query3) ;
        if(!$QueryResult3){
            throw new Exception("Unable to delete the empty subcategory: ".mysqli_error($DBConnectionBackend) ) ;
        }
    }





    /*
     * This query is used to re-sort the Sr No of the subcategories
     */


    $Query4 = "SELECT * FROM `$Table1` WHERE `category_code` = '$CategoryCode' ORDER BY `subcategory_sr_no` ASC" ;
    $QueryResult4 = mysqli_query($DBConnectionBackend, $Query4) ;
    if(!$QueryResult4){
        throw new Exception("Unable to fetch the subcategories to sort") ;
    }

    $CaseStatement = '' ;
    $RealSortNo = 1 ;
    foreach ($QueryResult4 as $Record4){
        $ThisSubCategoryRelId = $Record4['rel_id'] ;
        $CaseStatement .= "WHEN `rel_id` = '$ThisSubCategoryRelId' THEN '$RealSortNo' " ;
        $RealSortNo ++ ;
    }

    $Query5 = "UPDATE `$Table1` SET `subcategory_sr_no` = CASE $CaseStatement END WHERE `category_code` = '$CategoryCode'  " ;
    $QueryResult5 = mysqli_query($DBConnectionBackend, $Query5) ;
    if(!$QueryResult5){
        throw new Exception("Error in sorting the new Subcategories: ".mysqli_error($DBConnectionBackend)) ;
    }






    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


    echo " 
 
        SubCategory  Successfully deleted
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    echo $e ;
    echo " 
        <br><Br>
        SubCategory  Error Above
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";
    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


}


















?>