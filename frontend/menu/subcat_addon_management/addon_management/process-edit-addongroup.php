<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code');
$AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addongroup_rel_id');

$AddonGroupName = isSecure_IsValidText('__addongroup_name') ;
$AddonGroupIsActive = isSecure_IsYesNo('__addongroup_is_active');


$DBConnectionBackend = YOPDOSqlConnect() ;

$Query1 = "UPDATE `menu_meta_rel_category-addon_table` 
  SET `addon_group_display_name` = :addongroup_name , `addon_group_is_active` = :addongroup_is_active
  WHERE `category_code` = :category_code AND `rel_id` = :addongroup_rel_id " ;
try{
$QueryResult1 = $DBConnectionBackend->prepare($Query1) ;
$QueryResult1->execute([
    'addongroup_name'=>$AddonGroupName,
    'addongroup_is_active'=>$AddonGroupIsActive,
    'category_code'=>$CategoryCode,
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