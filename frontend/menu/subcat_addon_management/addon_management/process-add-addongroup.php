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
$AddonGroupSrNo = isSecure_checkPostInput('__addongroup_sr_no') ;
$AddonGroupIsActive = isSecure_checkPostInput('__addongroup_is_active') ;






$Query = "INSERT INTO `menu_meta_rel_category-addon_table` 
      VALUES ('', '$CategoryCode', '$AddonGroupDisplayName', '$AddonGroupType', '$AddonGroupSrNo', '$AddonGroupNoOfItems', '$AddonGroupIsActive')  " ;
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