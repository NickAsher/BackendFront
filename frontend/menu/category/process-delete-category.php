<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;


$DBConnectionBackend = YOPDOSqlConnect() ;



function deleteFromTableWhereCategoryId($DBConnection, $TableName, $CategoryColumnName, $CategoryId){
    $Query = "DELETE FROM `$TableName` WHERE `$CategoryColumnName` = :category_id " ;
    $QueryResult = $DBConnection->prepare($Query) ;
    $QueryResult->execute(['category_id'=>$CategoryId]) ;
}


try{
    $DBConnectionBackend->beginTransaction() ;

    deleteFromTableWhereCategoryId($DBConnectionBackend, "menu_meta_category_table", "category_id", $CategoryId) ;

    deleteFromTableWhereCategoryId($DBConnectionBackend, "menu_items_table", "item_category_id", $CategoryId) ;
    deleteFromTableWhereCategoryId($DBConnectionBackend, "menu_addons_table", "item_category_id", $CategoryId) ;

    deleteFromTableWhereCategoryId($DBConnectionBackend, "menu_meta_subcategory_table", "category_id", $CategoryId) ;
    deleteFromTableWhereCategoryId($DBConnectionBackend, "menu_meta_addongroups_table", "category_id", $CategoryId) ;

    deleteFromTableWhereCategoryId($DBConnectionBackend, "menu_meta_size_table", "size_category_id", $CategoryId) ;
    deleteFromTableWhereCategoryId($DBConnectionBackend, "menu_meta_rel_size_items_table", "item_category_id", $CategoryId) ;
    deleteFromTableWhereCategoryId($DBConnectionBackend, "menu_meta_rel_size_addons_table", "category_id", $CategoryId) ;




    $DBConnectionBackend->commit() ;

    echo "
        Addon-Item Successfully deleted
        <br><br>
        <a href='all-category.php'>Go Back</a>
    " ;

} catch (Exception $e){
    $DBConnectionBackend->rollBack() ;
    echo $e;



}







?>