<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$DBConnectionBackend = YOPDOSqlConnect() ;

$AddonName = isSecure_IsValidText(GetPostConst::Post, '__addon_name') ;
$AddonImage = "empty";

$AddonCategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__addon_category_code') ;
$AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '___addongroup_rel_id') ;
$AddonIsActive = isSecure_IsYesNo(GetPostConst::Post, '__addon_is_active') ;

$AddonIsDefault = 'no' ;







try{

    $DBConnectionBackend->beginTransaction() ;

    $Query = "INSERT INTO `menu_addons_table` (`item_sr_no`, `item_id`, `item_name`, `item_image`, `item_category_code`, `item_addon_group_rel_id`, `item_is_default`, `item_is_active` )
      SELECT COALESCE( (MAX( `item_sr_no` ) + 1), 1), '', :item_name, :item_image, :item_category_code, :item_addon_group_rel_id, :item_is_default, :item_is_active
      FROM `menu_addons_table` WHERE `item_category_code` = :item_category_code_02    " ;


    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'item_name'=>$AddonName,
            'item_image'=>$AddonImage,
            'item_category_code'=>$AddonCategoryCode,
            'item_addon_group_rel_id'=>$AddonGroupRelId,
            'item_is_default'=>$AddonIsDefault,
            'item_is_active'=>$AddonIsActive,
            'item_category_code_02'=>$AddonCategoryCode
        ]);
    } catch (Exception $e) {
        throw new Exception("Probelm in the addon insert query: ".$e) ;
    }



    $NewItemId = $DBConnectionBackend->lastInsertId() ; //this is the last insert id


    $AllSizes = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $AddonCategoryCode) ;

    $VALUES = '' ;
    $ValuesArray = array() ;
    foreach ($AllSizes as $Record2){
        $SizeId = $Record2['size_id'] ;
        $AddonPriceForThatSize = isSecure_IsValidPositiveDecimal(GetPostConst::Post, "__addon_price_size_$SizeId") ;
        $VALUES .= "('', '$NewItemId',  ?, '$SizeId', ?), " ;
        array_push($ValuesArray, $AddonPriceForThatSize , $AddonCategoryCode) ;
    }
    $VALUES = rtrim($VALUES, ", ") ;

    $Query3 = "INSERT INTO `menu_meta_rel_size-addons_table` VALUES $VALUES " ;
    try {
        $QueryResult3 = $DBConnectionBackend->prepare($Query3);
        $QueryResult3->execute($ValuesArray);
    } catch (Exception $e) {
        throw new Exception("Problem in price size insert query ".$e) ;
    }








    $DBConnectionBackend->commit() ;
    echo "
        Addon Item Successfully added
        <br><br>
        <a href='all-addons.php?'>Go Back</a>
    " ;

} catch (Exception $e){
    $DBConnectionBackend->rollBack() ;
    echo $e ;

}

















?>