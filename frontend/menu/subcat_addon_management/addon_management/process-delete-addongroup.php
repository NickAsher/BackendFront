<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code');
$AddonGroupRelId = isSecure_checkPostInput('__addongroup_rel_id') ;


$DBConnectionBackend = YOLOSqlConnect() ;




mysqli_begin_transaction($DBConnectionBackend) ;
try{


    $Table1 = "menu_meta_rel_category-addon_table" ;
    $Table2 = "menu_addons_table" ;
    $Table3 = "menu_meta_rel_size-addons_table" ;



    $Query1 = "SELECT * FROM `$Table1` WHERE `rel_id` = '$AddonGroupRelId' " ;
    $QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
    if(mysqli_num_rows($QueryResult1) != 1){
        throw new Exception("No Of rows returned is not 1 so unable to delete the AddonGroup") ;

    }




    $Query2 = "DELETE `$Table1` , `$Table2` , `$Table3` 
      FROM `$Table1`   INNER JOIN `$Table2`  INNER JOIN `$Table3`  
      ON `$Table1`.`rel_id` = `$Table2`.`item_addon_group_rel_id`   AND `$Table2`.`item_id` = `$Table3`.`addon_id`
      WHERE `$Table1`.`rel_id` = '$AddonGroupRelId' ";

    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Unable to delete the AddonGroup") ;
    }


    /*
     * this is the case that a AddonGroup is there but there are no addons in it. In that case
     * Query2 will delete 0 rows because of join ON condition . So this is done to just delete the AddonGroup
     */
    if(mysqli_affected_rows($DBConnectionBackend) == 0) {
        $Query3 = "DELETE FROM `$Table1` WHERE `rel_id` = '$AddonGroupRelId'   " ;
        $QueryResult3 = mysqli_query($DBConnectionBackend, $Query3) ;
        if(!$QueryResult3){
            throw new Exception("Unable to delete the empty AddonGroup") ;
        }
    }







    /*
     * This query is used to re-sort the Sr No of the subcategories
     */
    $Query4 = "SELECT * FROM `$Table1` WHERE `category_code` = '$CategoryCode' ORDER BY `addon_group_sr_no` ASC " ;
    $QueryResult4 = mysqli_query($DBConnectionBackend, $Query4) ;
    if(!$QueryResult4){
        throw new Exception("Unable to fetch the subcategories to sort") ;
    }

    $CaseStatement = '' ;
    $RealSortNo = 1 ;
    foreach ($QueryResult4 as $Record4){
        $ThisAddonGroupRelId = $Record4['rel_id'] ;
        $CaseStatement .= "WHEN `rel_id` = '$ThisAddonGroupRelId' THEN '$RealSortNo' " ;
        $RealSortNo ++ ;
    }

    $Query = "UPDATE `$Table1` SET `addon_group_sr_no` = CASE $CaseStatement END WHERE `category_code` = '$CategoryCode'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("Error in sorting the new AddonGroups: ".mysqli_error($DBConnectionBackend)) ;
    }








    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


    echo " 
 
        AddonGroup  Successfully deleted
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    echo $e ;
    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;


}










?>