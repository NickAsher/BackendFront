<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code');
$AddonGroupCode = isSecure_checkPostInput('__addongroup_code');


$DBConnectionBackend = YOLOSqlConnect() ;

$Query1 = "SELECT * FROM `menu_meta_rel_category-addon_table` WHERE `category_code` = '$CategoryCode' AND `addon_group_code` = '$AddonGroupCode' " ;
$QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
$NumOfRows = mysqli_num_rows($QueryResult1) ;
if($NumOfRows != 1){
    die("Addon-Group not Found") ;
}





$Query2 = "DELETE FROM `menu_meta_rel_category-addon_table` WHERE `category_code` = '$CategoryCode' AND `addon_group_code` = '$AddonGroupCode'  ";
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