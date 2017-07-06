<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';
require_once $ROOT_FOLDER_PATH.'/vendor/autoload.php' ;

use Respect\Validation\Validator as BV;

$DBConnectionBackend = YOPDOSqlConnect() ;
$DBConnectionBackend_Old = YOLOSqlConnect() ;

//
//$ItemName = isSecure_checkPostInput('__item_name') ;
//$ItemDescription = isSecure_checkPostInput('__item_description') ;
//$ItemCategory = isSecure_checkPostInput('__item_category') ;
//$ItemSubCategoryRelId = isSecure_checkPostInput('__item_subcategory_rel_id') ;
//$ItemIsActive = isSecure_checkPostInput('__item_is_active') ;

$ItemName = isSecure_IsValidText(GetPostConst::Post, '__item_name') ;
$ItemDescription = isSecure_IsValidText(GetPostConst::Post, '__item_description') ;
$ItemCategory = isSecure_IsValidItemCode(GetPostConst::Post, '__item_category') ;
$ItemSubCategoryRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__item_subcategory_rel_id') ;
$ItemIsActive = isSecure_IsYesNo(GetPostConst::Post, '__item_is_active') ;







$ImageFileArrayVariable = $_FILES['__item_image'] ;
$Item_ImageName = moveImageToImageFolder($DBConnectionBackend_Old, "$IMAGE_FOLDER_FILE_PATH/", $ImageFileArrayVariable);
if($Item_ImageName == -1){
    die("error in image uoloading") ;
}




try{
    $DBConnectionBackend->beginTransaction() ;



        $Query = "INSERT INTO `menu_items_table` (`item_sr_no`, `item_id`, `item_name`, `item_description`, `item_image_name`, `item_category_code`, `item_subcategory_rel_id`, `item_is_active` )
      SELECT COALESCE( (MAX( `item_sr_no` ) + 1), 1) , '', :item_name, :item_description, :item_imagename, :item_category, :item_sub_rel_id, :item_is_active
      FROM `menu_items_table` WHERE `item_subcategory_rel_id` = :item_sub_rel_id_02    " ;

    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'item_name' => $ItemName,
            'item_description' => $ItemDescription,
            'item_imagename' => $Item_ImageName,
            'item_category' => $ItemCategory,
            'item_sub_rel_id' => $ItemSubCategoryRelId,
            'item_is_active' => $ItemIsActive,
            'item_sub_rel_id_02' => $ItemSubCategoryRelId
        ]);
    }catch (Exception $e){
        throw new Exception("Probelm in the item insert query: ".$e->getMessage() ) ;
    }


    $NewItemId = $DBConnectionBackend->lastInsertId() ; //this is the last insert id (The item id of new product)






    $AllSizesOfCategory = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $ItemCategory) ;
    $ValuesPrepareString = '' ;
    $ValuesExecuteArray = array() ;

    foreach ($AllSizesOfCategory as $Record2){
        $SizeId = $Record2['size_id'] ;
        $ItemPriceForThatSize = isSecure_IsValidPositiveDecimal(GetPostConst::Post, "__item_price_size_$SizeId") ;

        $ValuesPrepareString .= "('', '$NewItemId',  ?, '$SizeId', ?), " ;
        array_push($ValuesExecuteArray, $ItemPriceForThatSize) ;
        array_push($ValuesExecuteArray, $ItemCategory) ;
    }


    $ValuesPrepareString = rtrim($ValuesPrepareString, ", ") ;
    $Query3 = "INSERT INTO `menu_meta_rel_size-items_table` VALUES $ValuesPrepareString " ;
    try {
        $QueryResult3 = $DBConnectionBackend->prepare($Query3);
        $QueryResult3->execute($ValuesExecuteArray);
    }catch(Exception $e){
        throw new Exception("Problem in price size insert query ".$e->getMessage() ) ;
    }





        $DBConnectionBackend->commit() ;
        echo "
        Item Successfully added
        <br><br>
        <a href='all-menuitems.php' >Go Back</a>
    " ;

} catch (Exception $e){
        echo $e ;

        $DBConnectionBackend->rollBack() ;



        // since we failed to insert the new item in the database,  so here we are deleting the image that we inserted
        $Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $Item_ImageName) ;
        if($Del1){
            echo "<br> unable to insert the new item , so deleted the image  <br>" ;
        } else {
            echo "<br> unable to insert the new item and image deletion also failed <br>" ;
        }
}




























?>