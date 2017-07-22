<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id');
$AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addongroup_rel_id');

$AddonGroupName = isSecure_IsValidText(GetPostConst::Post, '__addongroup_name') ;
$AddonGroupIsActive = isSecure_IsYesNo(GetPostConst::Post, '__addongroup_is_active');


$DBConnectionBackend = YOPDOSqlConnect() ;

$Query1 = "UPDATE `menu_meta_addongroups_table` 
  SET `addon_group_display_name` = :addongroup_name , `addon_group_is_active` = :addongroup_is_active
  WHERE `category_id` = :category_id AND `rel_id` = :addongroup_rel_id " ;
try{
$QueryResult1 = $DBConnectionBackend->prepare($Query1) ;
$QueryResult1->execute([
    'addongroup_name'=>$AddonGroupName,
    'addongroup_is_active'=>$AddonGroupIsActive,
    'category_id'=>$CategoryId,
    'addongroup_rel_id'=>$AddonGroupRelId
]) ;

    echo "
        Addon-Group Successfully Updated
        <br><br>
        <a href='../all-subcat.php' >Go Back</a>
    ";

} catch(Exception $e) {
    echo "error in Updating item <br>" . $e->getMessage()."
        
        <br><br>
        <a href='../all-subcat.php' >Go Back</a>
    ";
}














?>