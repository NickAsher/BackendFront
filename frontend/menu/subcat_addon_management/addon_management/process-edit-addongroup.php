<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code');
$AddonGroupCode = isSecure_checkPostInput('__addongroup_code');

$AddonGroupName = isSecure_checkPostInput('__addongroup_name') ;
$AddonGroupIsActive = isSecure_checkPostInput('__addongroup_is_active');


$DBConnectionBackend = YOLOSqlConnect() ;

$Query1 = "UPDATE `menu_meta_rel_category-addon_table` 
  SET `addon_group_display_name` = '$AddonGroupName' , `addon_group_is_active` = '$AddonGroupIsActive'
  WHERE `category_code` = '$CategoryCode' AND `addon_group_code` = '$AddonGroupCode' " ;

$QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
if($QueryResult1){
    echo "
        Addon-Group Successfully Updated
        <br><br>
        <a href='../all-subcat.php' >Go Back</a>
    ";

} else {
    echo "error in Updating item <br>" . mysqli_error($DBConnectionBackend)."
        
        <br><br>
        <a href='../all-subcat.php' >Go Back</a>
    ";
}














?>