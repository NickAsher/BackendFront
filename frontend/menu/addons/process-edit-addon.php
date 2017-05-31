<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$CategoryCode =  isSecure_checkPostInput('__category_code');
$AddonItemId = isSecure_checkPostInput('__addon_item_id');
$AddonItemName = isSecure_checkPostInput('__addon_item_name');
$AddonPriceSize1 = isSecure_checkPostInput('__addon_price_size1');
$AddonPriceSize2 = isSecure_checkPostInput('__addon_price_size2');
$AddonPriceSize3 = isSecure_checkPostInput('__addon_price_size3');



$DBConnectionBackend = YOLOSqlConnect() ;




$Query = "UPDATE `menu_addons_table`
           SET `item_name` = '$AddonItemName', `item_price_size1` = '$AddonPriceSize1', `item_price_size2` = '$AddonPriceSize2', `item_price_size3` = '$AddonPriceSize3'
           WHERE `item_id` = '$AddonItemId' " ;
//    echo $Query ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
if($QueryResult){
    echo "
        Addon-Item Successfully Updated
        <br><br>
        <a href='all-addons.php?'>Go Back</a>
    " ;
} else {
    echo "Unable to set the new details <br><br>".mysqli_error($DBConnectionBackend) ;
}




?>