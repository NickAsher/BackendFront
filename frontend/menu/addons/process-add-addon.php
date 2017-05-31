<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$DBConnectionBackend = YOLOSqlConnect() ;

$AddonName = isSecure_checkPostInput('__addon_name') ;
$AddonImage = "empty";

$AddonCategoryCode = isSecure_checkPostInput('__addon_category_code') ;
$AddonGroupCode = isSecure_checkPostInput('__addon_group_code') ;

$AddonIsDefault = 'no' ;
$AddonPriceSize1 = isSecure_checkPostInput('__addon_price_size1') ;
$AddonPriceSize2 = isSecure_checkPostInput('__addon_price_size2') ;
$AddonPriceSize3 = isSecure_checkPostInput('__addon_price_size3') ;








$Query = "INSERT INTO `menu_addons_table` 
            VALUES ('', '$AddonName', '$AddonImage', '$AddonCategoryCode', '$AddonGroupCode', '$AddonIsDefault',
            '$AddonPriceSize1', '$AddonPriceSize2', '$AddonPriceSize3')  " ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;

if($QueryResult){
    echo "
        Addon Item Successfully added
        <br><br>
        <a href='all-addons.php?'>Go Back</a>
    " ;
} else {
    echo "unable to insert the new addon item  <br><br>".mysqli_error($DBConnectionBackend) ;
}





















?>