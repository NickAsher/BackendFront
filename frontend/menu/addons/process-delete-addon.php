<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addon_group_rel_id');
$AddonItemId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addon_id') ;


$DBConnectionBackend = YOPDOSqlConnect() ;






try{
    $DBConnectionBackend->beginTransaction() ;

    $Table1 = "menu_addons_table" ;
    $Table2 = "menu_meta_rel_size-addons_table" ;

    $Query1 = "DELETE `$Table1` , `$Table2`  FROM `$Table1` INNER JOIN `$Table2`
      ON `$Table1`.`item_id` =  `$Table2`.`addon_id` 
      WHERE `$Table1`.`item_id` = :addon_item_id ";
    try {
        $QueryResult1 = $DBConnectionBackend->prepare($Query1);
        $QueryResult1->execute(['addon_item_id' => $AddonItemId]);
    } catch (Exception $e) {
        throw new Exception("Unable to delete the Addon Item: ".$e ) ;
    }






    $AllAddonItemsInThisGroup = getListOfAllAddonItemsInAddonGroup_Array_PDO($DBConnectionBackend, $AddonGroupRelId) ;
    if(count($AllAddonItemsInThisGroup) != 0) {


        $CaseStatement = '';
        $CaseValuesArray = array() ;
        $RealSortNo = 1;
        foreach ($AllAddonItemsInThisGroup as $Record2) {
            $ThisItem_ItemId = $Record2['item_id'];
            $CaseStatement .= "WHEN `item_id` = '$ThisItem_ItemId' THEN '$RealSortNo' ";
            $RealSortNo++;
        }

        $Query3 = "UPDATE `$Table1` SET `item_sr_no` = CASE $CaseStatement END WHERE `item_addon_group_rel_id` = '$AddonGroupRelId'  ";
        try {
            $QueryResult3 = $DBConnectionBackend->prepare($Query3);
            $QueryResult3->execute(['addongroup_rel_id' => $AddonGroupRelId]);
        } catch (Exception $e) {
            throw new Exception("Error in sorting the new Addon Items: " . $e);
        }

    }




    $DBConnectionBackend->commit() ;

    echo "
        Addon-Item Successfully deleted
        <br><br>
        <a href='all-addons.php?'>Go Back</a>
    " ;

} catch (Exception $e){
    $DBConnectionBackend->rollBack() ;
    echo $e->getMessage();



}







?>