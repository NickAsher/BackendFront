<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code');
$AddonGroupRelId = isSecure_checkPostInput('__addongroup_rel_id') ;


$DBConnectionBackend = YOLOSqlConnect() ;




$Query2 = "DELETE FROM `menu_meta_rel_category-addon_table` WHERE `category_code` = '$CategoryCode' AND `rel_id` = '$AddonGroupRelId'  ";
$QueryResult2 = mysqli_query($DBConnectionBackend, $Query2);

if ($QueryResult2) {
    echo "
        Addon-Group Successfully deleted
        <br><br>
        <a href='../all-subcat.php' >Go Back</a>
    ";

} else {
    echo "error in deleteing item <br>" . mysqli_error($DBConnectionBackend);
}










?>