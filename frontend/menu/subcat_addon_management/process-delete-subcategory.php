<?php
require_once '../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_checkPostInput('__category_code');
$SubCategoryCode = isSecure_checkPostInput('__subcategory_code');


$DBConnectionBackend = YOLOSqlConnect() ;

$Query1 = "SELECT * FROM `menu_meta_rel_category-subcategory_table` WHERE `category_code` = '$CategoryCode' AND `subcategory_code` = '$SubCategoryCode' " ;
$QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
$NumOfRows = mysqli_num_rows($QueryResult1) ;
if($NumOfRows != 1){
    die("SubCategory not Found") ;
}





$Query2 = "DELETE FROM `menu_meta_rel_category-subcategory_table` WHERE `category_code` = '$CategoryCode' AND `subcategory_code` = '$SubCategoryCode'  ";
$QueryResult2 = mysqli_query($DBConnectionBackend, $Query2);

if ($QueryResult2) {
    echo "
        Subcategory Successfully deleted
        <br><br>
        <a href='all-subcat.php' >Go Back</a>
    ";

} else {
    echo "error in deleteing item <br>" . mysqli_error($DBConnectionBackend);
}










?>