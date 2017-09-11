<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$RelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__rel_id');

$SubCategoryName = isSecure_IsValidText(GetPostConst::Post, '__subcategory_name') ;
$SubCategoryIsActive = isSecure_IsYesNo(GetPostConst::Post, '__subcategory_is_active');


$DBConnectionBackend = YOPDOSqlConnect() ;

$Query1 = "UPDATE `menu_meta_subcategory_table` 
  SET `subcategory_display_name` = :subcategory_display_name , `subcategory_is_active` = :subcategory_is_active
  WHERE `rel_id` = :rel_id " ;

try {
    $QueryResult1 = $DBConnectionBackend->prepare($Query1);
    $QueryResult1->execute([
        'subcategory_display_name' => $SubCategoryName,
        'subcategory_is_active' => $SubCategoryIsActive,
        'rel_id' => $RelId
    ]);

    echo "
        Subcategory Successfully Updated
        <br><br>
        <a href='../all-subcat.php' >Go Back</a>
    ";

} catch (Exception $e) {
    echo "error in Updating Subcategory <br>" . $e->getMessage()."
        
        <br><br>
        <a href='../all-subcat.php' >Go Back</a>
    ";
}
















?>