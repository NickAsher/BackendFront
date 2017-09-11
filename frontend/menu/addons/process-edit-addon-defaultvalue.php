<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';

$CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;
$AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addongroup_rel_id') ;
$AddonDefaultItemId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addon_id') ;


$DBConnectionBackend = YOPDOSqlConnect() ;


$ListAllAddonItemInAddonGroup = getListOfAllAddonItemsInAddonGroup_Array_PDO($DBConnectionBackend, $AddonGroupRelId) ;
$CaseStatement = '' ;
$CaseValues = array() ;


foreach ($ListAllAddonItemInAddonGroup as $AddonItemRecord){
    $AddonItemId = $AddonItemRecord['item_id'] ;
    if($AddonItemId==$AddonDefaultItemId){
        $CaseStatement .= "WHEN `item_id` = ? THEN 'yes'  " ;
    } else {
        $CaseStatement .= "WHEN `item_id` = ? THEN 'no'  " ;
    }

    array_push($CaseValues, $AddonItemId) ;





}

$Query2 = "UPDATE `menu_addons_table` SET `item_is_default` = CASE $CaseStatement END  " ;

try {
    $QueryResult2 = $DBConnectionBackend->prepare($Query2);
    $QueryResult2->execute($CaseValues);
} catch (Exception $e) {
    echo ("error in  updating <br>".$e) ;
}
    echo "
    Successfully updated values
    <br>
    <a href='all-addons.php' >Go Back</a>
    " ;
