<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOLOSqlConnect() ;

$CategoryCode = isSecure_checkPostInput('__category_code') ;
$AddonGroupDisplayName = isSecure_checkPostInput('__addongroup_name') ;
$AddonGroupType = isSecure_checkPostInput('__addongroup_type') ;
$AddonGroupNoOfItems = 0 ;
$AddonGroupIsActive = isSecure_checkPostInput('__addongroup_is_active') ;





//
//$Query = "INSERT INTO `menu_meta_rel_category-addon_table`
//      VALUES ('', '$CategoryCode', '$AddonGroupDisplayName', '$AddonGroupType', '$AddonGroupSrNo', '$AddonGroupNoOfItems', '$AddonGroupIsActive')  " ;


$Query = "INSERT INTO `menu_meta_rel_category-addon_table` (`addon_group_sr_no`, `rel_id`, `category_code`, `addon_group_display_name`, `addon_group_type`, `addon_group_no_of_items`, `addon_group_is_active` )
  SELECT MAX( `addon_group_sr_no` ) + 1, '', '$CategoryCode', '$AddonGroupDisplayName', '$AddonGroupType', '$AddonGroupNoOfItems',  '$AddonGroupIsActive'
  FROM `menu_meta_rel_category-addon_table` WHERE `category_code` = '$CategoryCode'    " ;

$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;

if($QueryResult){
    echo " 
        Addon-Group Successfully added
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    
    
    ";
} else {
    echo "unable to insert the new item  <br><br>".mysqli_error($DBConnectionBackend) ;
}





















?>