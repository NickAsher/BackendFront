<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOLOSqlConnect() ;

$CategoryCode = isSecure_checkPostInput('__category_code') ;
$SubCategoryCode = isSecure_checkPostInput('__subcategory_code') ;
$SubCategoryDisplayName = isSecure_checkPostInput('__subcategory_name') ;
$SubCategoryOrderingNo = isSecure_checkPostInput('__subcategory_ordering_no') ;
$SubCategoryNoOfItems = 0 ;
$SubCategoryIsActive = isSecure_checkPostInput('__subcategory_is_active') ;






$Query = "INSERT INTO `menu_meta_rel_category-subcategory_table` 
      VALUES ('', '$CategoryCode', '$SubCategoryCode', '$SubCategoryDisplayName', '$SubCategoryOrderingNo', '$SubCategoryNoOfItems', '$SubCategoryIsActive')  " ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;

if($QueryResult){
    echo "
        Subcategory Successfully added
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    
    
    ";
} else {
    echo "unable to insert the new item  <br><br>".mysqli_error($DBConnectionBackend) ;
}





















?>