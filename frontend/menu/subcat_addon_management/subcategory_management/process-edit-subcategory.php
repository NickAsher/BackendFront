<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code');
$SubCategoryCode = isSecure_checkPostInput('__subcategory_code') ;

$SubCategoryName = isSecure_checkPostInput('__subcategory_name') ;
$SubCategoryIsActive = isSecure_checkPostInput('__subcategory_is_active');


$DBConnectionBackend = YOLOSqlConnect() ;

$Query1 = "UPDATE `menu_meta_rel_category-subcategory_table` 
  SET `subcategory_display_name` = '$SubCategoryName' , `subcategory_is_active` = '$SubCategoryIsActive'
  WHERE `category_code` = '$CategoryCode' AND `subcategory_code` = '$SubCategoryCode' " ;

$QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
if($QueryResult1){
    echo "
        Subcategory Successfully Updated
        <br><br>
        <a href='../all-subcat.php' >Go Back</a>
    ";

} else {
    echo "error in Updating Subcategory <br>" . mysqli_error($DBConnectionBackend)."
        
        <br><br>
        <a href='../all-subcat.php' >Go Back</a>
    ";
}














?>