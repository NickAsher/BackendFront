<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code');
$AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addongroup_rel_id') ;


$DBConnectionBackend = YOPDOSqlConnect() ;




try{
    $DBConnectionBackend->beginTransaction() ;


    $Table1 = "menu_meta_rel_category-addon_table" ;
    $Table2 = "menu_addons_table" ;
    $Table3 = "menu_meta_rel_size-addons_table" ;








    $Query2 = "DELETE `$Table1` , `$Table2` , `$Table3` 
      FROM `$Table1`   INNER JOIN `$Table2`  INNER JOIN `$Table3`  
      ON `$Table1`.`rel_id` = `$Table2`.`item_addon_group_rel_id`   AND `$Table2`.`item_id` = `$Table3`.`addon_id`
      WHERE `$Table1`.`rel_id` = :rel_id    ";
    try {
        $QueryResult2 = $DBConnectionBackend->prepare($Query2);
        $QueryResult2->execute(['rel_id' => $AddonGroupRelId]);
    }catch (Exception $e){
        throw new Exception("Unable to delete the AddonGroup".$e->getMessage()) ;
    }


    /*
     * this is the case that a AddonGroup is there but there are no addons in it. In that case
     * Query2 will delete 0 rows because of join ON condition . So this is done to just delete the AddonGroup
     */
    if($QueryResult2->rowCount() == 0) {
        $Query3 = "DELETE FROM `$Table1` WHERE `rel_id` = :rel_id   " ;
        try {
            $QueryResult3 = $DBConnectionBackend->prepare($Query3);
            $QueryResult3->execute(['rel_id' => $AddonGroupRelId]);
        }catch (Exception $e){
            throw new Exception("Unable to delete the empty AddonGroup".$e->getMessage()) ;
        }
    }







    /*
     * This query is used to re-sort the Sr No of the addongroups
     */

    $ListOfAddonGroupsInCategory = getListOfAllAddonGroupsInACategory_Array_PDO($DBConnectionBackend, $CategoryCode) ;

    if(count($ListOfAddonGroupsInCategory) != 0) {

        $CaseStatement = '';
        $RealSortNo = 1;
        foreach ($ListOfAddonGroupsInCategory as $Record4) {
            $ThisAddonGroupRelId = $Record4['rel_id'];
            $CaseStatement .= "WHEN `rel_id` = '$ThisAddonGroupRelId' THEN '$RealSortNo' ";
            $RealSortNo++;
        }

        $Query = "UPDATE `$Table1` SET `addon_group_sr_no` = CASE $CaseStatement END WHERE `category_code` = :category_code  ";
        try {
            $QueryResult = $DBConnectionBackend->prepare($Query);
            $QueryResult->execute(['category_code' => $CategoryCode]);
        }catch (Exception $e){
            throw new Exception("Error in sorting the new AddonGroups: " . $e->getMessage());
        }

    }








    $DBConnectionBackend->commit() ;


    echo " 
 
        AddonGroup  Successfully deleted
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    echo $e ;
    $DBConnectionBackend->rollBack() ;


}










?>