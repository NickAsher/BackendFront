<?php
require_once '../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';

$DBConnection = YOLOSqlConnect() ;


$ListOfAllCategories = getListOfAllCategories_Array($DBConnection) ;
foreach ($ListOfAllCategories as $Record1){
    $CategoryCode = $Record1['category_code'] ;

    $ListOfAllAddonGroupsInCategory = getListOfAllAddonGroupsInACategory_Array($DBConnection, $CategoryCode) ;


    foreach ($ListOfAllAddonGroupsInCategory as $Record2){
        $SubCategoryRelId = $Record2['rel_id'] ;

        $ListOfAllAddonItemsInAddonGroup = getListOfAllAddonItemsInAddonGroup_Array($DBConnection, $SubCategoryRelId) ;


        foreach ($ListOfAllAddonItemsInAddonGroup as $key=>$Record3){
            $SrNo = $key+1 ;
            $ItemId = $Record3['item_id'] ;
            $Query = "UPDATE `menu_addons_table` SET `item_sr_no` = '$SrNo' WHERE `item_id` = '$ItemId' " ;
            $QueryResult = mysqli_query($DBConnection, $Query) ;
            if(!$QueryResult){
                echo "problem in setting sr no for item id $ItemId : ".mysqli_error($DBConnection) ;
            }
        }

    }
}

echo "Success 2" ;