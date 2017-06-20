<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOLOSqlConnect() ;

$CategoryCode = isSecure_checkPostInput('__category_code') ;
$SubCategoryDisplayName = isSecure_checkPostInput('__subcategory_name') ;
$SubCategoryNoOfItems = 0 ;
$SubCategoryIsActive = isSecure_checkPostInput('__subcategory_is_active') ;


/*
 *
 * $Query = "INSERT INTO `menu_meta_rel_category-subcategory_table`
      VALUES ('', '$CategoryCode', '$SubCategoryCode', '$SubCategoryDisplayName', '$SubCategorySrNo', '$SubCategoryNoOfItems', '$SubCategoryIsActive')  " ;


 * This is a Old syntax as opposed to the new syntax. The new syntax is used because
 * With this we can get the max(subcategory_sr_no) in one query
 *
 * This is the INSERT INTO SELECT () FROM ``    syntax
 *
 *
 */

$Query = "INSERT INTO `menu_meta_rel_category-subcategory_table` (`subcategory_sr_no`, `rel_id`, `category_code`, `subcategory_display_name`, `subcategory_no_of_menuitems`, `subcategory_is_active` )
  SELECT MAX( `subcategory_sr_no` ) + 1, '', '$CategoryCode', '$SubCategoryDisplayName', '$SubCategoryNoOfItems', '$SubCategoryIsActive'
  FROM `menu_meta_rel_category-subcategory_table` WHERE `category_code` = '$CategoryCode'    " ;


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