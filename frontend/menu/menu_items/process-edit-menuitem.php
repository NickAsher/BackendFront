<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;

//require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';
require_once $ROOT_FOLDER_PATH.'/utils/updater-utils.php';


$DBConnectionBackend = YOPDOSqlConnect() ;
$DBConnectionBackend_Old = YOLOSqlConnect() ;

$ItemId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__item_id') ;
$ItemName = isSecure_IsValidText(GetPostConst::Post, '__item_name') ;
$ItemDescription = isSecure_IsValidText(GetPostConst::Post, '__item_description') ;
$ItemIsActive = isSecure_IsYesNo(GetPostConst::Post, '__item_is_active') ;















    $ItemInfoArray = getSingleMenuItemInfoArray_PDO($DBConnectionBackend, $ItemId) ;
    $ItemCategoryCode = $ItemInfoArray['item_category_code'] ;
    $OldDisplayPic_Name = $ItemInfoArray['item_image_name'] ;
    $NewDisplayPic = $_FILES['__new_item_image'] ;

    $ImageUpdater = new ImageUpdater($DBConnectionBackend_Old, $IMAGE_FOLDER_FILE_PATH, $OldDisplayPic_Name, $NewDisplayPic) ;

    try{
        $ImageUpdater->update() ;
    }catch (Exception $e){
        die($e->getMessage()) ;
    }

    $InsertedDisplayPic_Name = $ImageUpdater->getInsertedImageName() ;
    $isNewImageInserted = $ImageUpdater->isNewImageInserted() ;







try{
    $DBConnectionBackend->beginTransaction() ;



    $Query = "UPDATE `menu_items_table` SET
                  `item_name` = :item_name, `item_description` = :item_description, `item_image_name` = :item_imagename, `item_is_active` = :item_is_active
                  WHERE `item_id` = :item_id  " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'item_name' => $ItemName,
            'item_description' => $ItemDescription,
            'item_imagename' => $InsertedDisplayPic_Name,
            'item_is_active' => $ItemIsActive,
            'item_id'=>$ItemId,
        ]);
    }catch(Exception $e){
        throw new Exception("Probelm in the item insert query: ".$e->getMessage()) ;

    }




    $AllSizesList = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $ItemCategoryCode) ;
    foreach ($AllSizesList as $Record2){
        $SizeId = $Record2['size_id'] ;
        $ItemPriceForThatSize = isSecure_IsValidPositiveDecimal(GetPostConst::Post, "__item_price_size_$SizeId") ;




        $Query3 = "UPDATE `menu_meta_rel_size-items_table`
          SET `item_price` = :item_price WHERE `item_id` = :item_id AND `size_id` = :size_id " ;
        try {
            $QueryResult3 = $DBConnectionBackend->prepare($Query3);
            $QueryResult3->execute([
                'item_price' => $ItemPriceForThatSize,
                'item_id' => $ItemId,
                'size_id' => $SizeId
            ]);
        }catch (Exception $e){
            throw new Exception("Problem in price update query for size code $SizeId : ".$e->getMessage()) ;
        }
    }



    try{
        $ImageUpdater->deleteOldImageIfNeeded() ;
    }catch (Exception $e){
        throw new Exception("Problem in deleting the old image :".$e->getMessage()) ;
    }











    $DBConnectionBackend->commit() ;
    echo "
            Item Successfully Updated
            <br><br>
            <a href='all-menuitems.php' >Go Back</a>
        " ;







} catch (Exception $j){
    echo "Unable to update the item".$j->getMessage() ;

    $DBConnectionBackend->rollBack() ;



    try{
        $ImageUpdater->revertBackChanges() ;
        echo "Reverted Changes" ;
    }catch (Exception $e){
        die("Problem in reverting back the changes: ".$e->getMessage()) ;
    }





}


?>