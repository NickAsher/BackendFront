<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOPDOSqlConnect() ;

$CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code') ;
$SubCategoryDisplayName = isSecure_IsValidText(GetPostConst::Post, '__subcategory_name') ;
$SubCategoryNoOfItems = 0 ;
$SubCategoryIsActive = isSecure_IsYesNo(GetPostConst::Post, '__subcategory_is_active') ;




$Query = "INSERT INTO `menu_meta_rel_category-subcategory_table` (`subcategory_sr_no`, `rel_id`, `category_code`, `subcategory_display_name`, `subcategory_no_of_menuitems`, `subcategory_is_active` )
  SELECT COALESCE( (MAX( `subcategory_sr_no` ) + 1), 1), '', :category_code, :subcategory_display_name, :subcategory_no_of_items, :subcateogry_is_active
  FROM `menu_meta_rel_category-subcategory_table` WHERE `category_code` = :category_code_02    " ;


try {
    $QueryResult = $DBConnectionBackend->prepare($Query);
    $QueryResult->execute([
        'category_code' => $CategoryCode,
        'subcategory_display_name' => $SubCategoryDisplayName,
        'subcategory_no_of_items' => $SubCategoryNoOfItems,
        'subcateogry_is_active' => $SubCategoryIsActive,
        'category_code_02' => $CategoryCode
    ]);

    echo "
        Subcategory Successfully added
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";


} catch (Exception $e) {
    echo "unable to insert the new item  ".$e->getMessage() ;
}






















?>