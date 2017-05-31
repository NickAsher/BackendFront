<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once '../utils/menu-utils.php';
require_once '../utils/menu_item-utils.php';

$CategoryCode = isSecure_checkPostInput('__category_code') ;
$AddonGroupCode = isSecure_checkPostInput('__addongroup_code') ;
$AddonDefaultItemId = isSecure_checkPostInput('__addon_id') ;
$DBConnectionBackend = YOLOSqlConnect() ;


$ListAllAddonItemInAddonGroup = getListOfAllAddonItemsInAddonGroup_Array($DBConnectionBackend, $CategoryCode, $AddonGroupCode) ;
foreach ($ListAllAddonItemInAddonGroup as $AddonItemRecord){
    $AddonItemId = $AddonItemRecord['item_id'] ;
    if($AddonItemId==$AddonDefaultItemId){
        continue ;
    }

    $Query = "UPDATE `menu_addons_table` SET `item_is_default` = 'no' WHERE `item_id` = '$AddonItemId' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) or die("Unable to set new values <br>".mysqli_error($DBConnectionBackend)) ;

}

    $Query2 = "UPDATE `menu_addons_table` SET `item_is_default` = 'yes' WHERE `item_id` = '$AddonDefaultItemId' " ;
$QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
if($QueryResult2){
    echo "
    Successfully updated values
    <br>
    <a href='all-addons.php' >Go Back</a>
    " ;
} else {
    die("error in  updating <br>".mysqli_error($DBConnectionBackend) ) ;
}

//echo "$CategoryCode-$AddonGroupCode-$AddonDefaultItemId" ;