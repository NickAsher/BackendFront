<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$CategoryId =  isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id');
$CategoryName = isSecure_IsValidText(GetPostConst::Post, '__category_name');
$CategoryIsActive = isSecure_IsYesNo(GetPostConst::Post, '__category_is_active') ;
$CategoryImageCode = isSecure_IsValidText(GetPostConst::Post, '__category_image') ;




$DBConnectionBackend = YOPDOSqlConnect() ;










try{


    $Query = "UPDATE `menu_meta_category_table` 
        SET `category_name` = :category_name, `category_is_active` = :category_is_active, `category_image` = :category_image WHERE `category_id` = :category_id " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'category_name' => $CategoryName,
            'category_is_active' => $CategoryIsActive,
            'category_image' => $CategoryImageCode,
            'category_id' => $CategoryId
        ]);
    } catch (Exception $e) {
        throw new Exception("Probelm in the item update query: ".$e) ;
    }










    echo "
        Category Successfully Updated
        <br><br>
        <a href='all-category.php?'>Go Back</a>
    " ;







} catch (Exception $e){
    echo $e ;









}

?>