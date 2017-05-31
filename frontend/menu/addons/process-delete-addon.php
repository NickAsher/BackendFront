<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code');
$AddonItemId = isSecure_checkPostInput('__addon_id');


$DBConnectionBackend = YOLOSqlConnect() ;


$Query1 = "SELECT * FROM `menu_addons_table` WHERE `item_category_code` = '$CategoryCode' AND `item_id` = '$AddonItemId' " ;
$QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
$NumOfRows = mysqli_num_rows($QueryResult1) ;
if($NumOfRows != 1){
    die("Addon-Item not Found") ;
}



$Query2 = "DELETE FROM `menu_addons_table` WHERE `item_category_code` = '$CategoryCode' AND `item_id` = '$AddonItemId'  ";
$QueryResult2 = mysqli_query($DBConnectionBackend, $Query2);

if ($QueryResult2) {
    echo "
        Addon-Item Successfully deleted
        <br><br>
        <a href='all-addons.php?'>Go Back</a>
    
    
    " ;

} else {
    echo "error in deleteing item <br>" . mysqli_error($DBConnectionBackend);
}










?>