<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOPDOSqlConnect() ;

$CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;
$SubCategoryDisplayName = isSecure_IsValidText(GetPostConst::Post, '__subcategory_name') ;
$SubCategoryIsActive = isSecure_IsYesNo(GetPostConst::Post, '__subcategory_is_active') ;




$Query = "INSERT INTO `menu_meta_subcategory_table` (`subcategory_sr_no`, `rel_id`, `category_id`, `subcategory_display_name`, `subcategory_is_active` )
  SELECT COALESCE( (MAX( `subcategory_sr_no` ) + 1), 1), '', :category_id, :subcategory_display_name, :subcateogry_is_active
  FROM `menu_meta_subcategory_table` WHERE `category_id` = :category_id_02    " ;


try {
    $QueryResult = $DBConnectionBackend->prepare($Query);
    $QueryResult->execute([
        'category_id' => $CategoryId,
        'subcategory_display_name' => $SubCategoryDisplayName,
        'subcateogry_is_active' => $SubCategoryIsActive,
        'category_id_02' => $CategoryId
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