<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$CategoryId =  isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id');
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


    $AllSizes = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $CategoryId) ;


    $CaseStatement_Price = '' ;
    $CaseStatement_SizeActive = '' ;
    $CaseValues_Total = array() ;


    foreach ($AllSizes as $Record2){
        $SizeId = $Record2['size_id'] ;
        $AddonPriceForThatSize = isSecure_IsValidPositiveDecimal(GetPostConst::Post, "__addon_price_size_$SizeId") ;

        $CaseStatement_Price .= "WHEN `size_id` = '$SizeId' THEN ? " ;
        array_push($CaseValues_Total, $AddonPriceForThatSize) ;
    }

    foreach ($AllSizes as $Record2){
        $SizeId = $Record2['size_id'] ;
        $ItemActiveForThatSize = isSecure_IsYesNo(GetPostConst::Post, "__addon_size_active_$SizeId") ;

        $CaseStatement_SizeActive .= "WHEN `size_id` = '$SizeId' THEN ? " ;
        array_push($CaseValues_Total, $ItemActiveForThatSize) ;
    }



    $Query2 = "UPDATE `menu_meta_rel_size_addons_table`
        SET `addon_price` = CASE $CaseStatement_Price END, `addon_size_active` = CASE $CaseStatement_SizeActive END
        WHERE `addon_id` = ?  " ;
    array_push($CaseValues_Total, $AddonItemId) ;
    try {
        $QueryResult2 = $DBConnectionBackend->prepare($Query2);
        $QueryResult2a->execute($CaseValues_Total);
    } catch (Exception $e) {
        throw new Exception("Problem in Addon Price Size update query  : ".$e) ;
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