<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$DBConnectionBackend = YOPDOSqlConnect() ;

$CategoryName = isSecure_IsValidText(GetPostConst::Post, '__category_name') ;
$CategoryActive = isSecure_IsYesNo(GetPostConst::Post, '__category_is_active') ;
$CategoryImageCode = isSecure_IsValidText(GetPostConst::Post, '__category_image') ;

try{

    $DBConnectionBackend->beginTransaction() ;

    $Query = "INSERT INTO `menu_meta_category_table` (`category_sr_no`, `category_id`, `category_name`, `category_image`, `category_is_active` )
      SELECT COALESCE( (MAX( `category_sr_no` ) + 1), 1), '', :category_name, :category_image, :category_is_active
      FROM `menu_meta_category_table`  " ;


    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'category_name'=>$CategoryName,
            'category_image'=>$CategoryImageCode,
            'category_is_active'=>$CategoryActive


        ]);
    } catch (Exception $e) {
        throw new Exception("Probelm in the addon insert query: ".$e) ;
    }



    $NewItemId = $DBConnectionBackend->lastInsertId() ; //this is the last insert id
    try {
        $Query2 = "INSERT INTO `menu_meta_subcategory_table` VALUES ('', '$NewItemId', 'Default-Subcategory', '1', 'yes' )";
        $QueryResult2 = $DBConnectionBackend->query($Query2);


        $Query3 = "INSERT INTO `menu_meta_addongroups_table` VALUES ('', '$NewItemId', 'Default-Addon-Group', 'checkbox', '1', 'yes' )";
        $QueryResult3 = $DBConnectionBackend->query($Query3);

        $Query4 = "INSERT INTO `menu_meta_size_table` VALUES ('', '1', '$NewItemId', 'Default-Size', 'DS', 'yes', 'yes',  'none' )";
        $QueryResult4 = $DBConnectionBackend->query($Query4);
    }catch (Exception $e){
        throw new Exception("Problem in in the add category defaults : ".$e) ;
    }














    $DBConnectionBackend->commit() ;
    echo "
        Addon Item Successfully added
        <br><br>
        <a href='all-category.php?'>Go Back</a>
    " ;

} catch (Exception $e){
    $DBConnectionBackend->rollBack() ;
    echo $e ;

}

















?>