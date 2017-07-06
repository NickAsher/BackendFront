<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$CategoryCode =  isSecure_IsValidItemCode(GetPostConst::Post, '__category_code');
$AddonItemId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addon_item_id');
$AddonItemName = isSecure_IsValidText(GetPostConst::Post, '__addon_item_name');
$AddonIsActive = isSecure_IsYesNo(GetPostConst::Post, '__addon_is_active') ;

$ItemNoOfSizeVariations = '0' ;



$DBConnectionBackend = YOPDOSqlConnect() ;










try{
    $DBConnectionBackend->beginTransaction() ;

    $Query = "UPDATE `menu_addons_table` SET `item_name` = :item_name, `item_is_active` = :item_is_active WHERE `item_id` = :item_id " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'item_name' => $AddonItemName,
            'item_is_active' => $AddonIsActive,
            'item_id' => $AddonItemId
        ]);
    } catch (Exception $e) {
        throw new Exception("Probelm in the item update query: ".$e) ;
    }


    $AllSizes = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $CategoryCode) ;
    $CaseStatement = '' ;
    $CaseValues =array() ;


    foreach ($AllSizes as $Record2){
        $SizeId = $Record2['size_id'] ;
        $AddonPriceForThatSize = isSecure_IsValidPositiveDecimal(GetPostConst::Post, "__addon_price_size_$SizeId") ;

        $CaseStatement .= "WHEN `size_id` = '$SizeId' THEN ? " ;
        array_push($CaseValues, $AddonPriceForThatSize) ;
    }

    $Query3 = "UPDATE `menu_meta_rel_size-addons_table` SET `addon_price` = CASE $CaseStatement END WHERE `addon_id` = ?  " ;
    array_push($CaseValues, $AddonItemId) ;
    try {
        $QueryResult3 = $DBConnectionBackend->prepare($Query3);
        $QueryResult3->execute($CaseValues);
    } catch (Exception $e) {
        throw new Exception("Problem in price update query  : ".$e) ;
    }




    $DBConnectionBackend->commit() ;



    echo "
        Addon-Item Successfully Updated
        <br><br>
        <a href='all-addons.php?'>Go Back</a>
    " ;







} catch (Exception $e){
    $DBConnectionBackend->rollBack() ;
    echo $e->getMessage() ;









}

?>