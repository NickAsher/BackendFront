<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
//require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
require_once $ROOT_FOLDER_PATH.'/utils/updater-utils.php';


$DBConnectionBackend = YOLOSqlConnect() ;

$ItemId = isSecure_checkPostInput('__item_id') ;
$ItemName = isSecure_checkPostInput('__item_name') ;
$ItemDescription = isSecure_checkPostInput('__item_description') ;
$ItemIsActive = isSecure_checkPostInput('__item_is_active') ;




    $ItemInfoArray = getSingleMenuItemInfoArray($DBConnectionBackend, $ItemId) ;
    $ItemCategoryCode = $ItemInfoArray['item_category_code'] ;
    $OldDisplayPic_Name = $ItemInfoArray['item_image_name'] ;
    $NewDisplayPic = $_FILES['__new_item_image'] ;

    $ImageUpdater = new ImageUpdater($DBConnectionBackend, $IMAGE_FOLDER_FILE_PATH, $OldDisplayPic_Name, $NewDisplayPic) ;

    try{
        $ImageUpdater->update() ;
    }catch (Exception $e){
        die($e->getMessage()) ;
    }

    $InsertedDisplayPic_Name = $ImageUpdater->getInsertedImageName() ;
    $isNewImageInserted = $ImageUpdater->isNewImageInserted() ;







mysqli_begin_transaction($DBConnectionBackend) ;
try{




    $Query = "UPDATE `menu_items_table` SET
                  `item_name` = '$ItemName', `item_description` = '$ItemDescription', `item_image_name` = '$InsertedDisplayPic_Name', `item_is_active` = '$ItemIsActive'
                  WHERE `item_id` = '$ItemId'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("Probelm in the item insert query: ".mysqli_error($DBConnectionBackend)) ;
    }


    $Query2 = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_code` = '$ItemCategoryCode' ORDER BY `size_sr_no` " ;
    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
    if(!$QueryResult2){
        throw new Exception("Probelm in the fetching the different sizes from menu_meta_size_table : ".mysqli_error($DBConnectionBackend)) ;
    }
    foreach ($QueryResult2 as $Record2){
        $SizeId = $Record2['size_id'] ;
        $ItemPriceForThatSize = isSecure_checkPostInput("__item_price_size_$SizeId") ;

        $Query3 = "UPDATE `menu_meta_rel_size-items_table` SET `item_price` = '$ItemPriceForThatSize' WHERE `item_id` = '$ItemId' AND `size_id` = '$SizeId' " ;
        if(!mysqli_query($DBConnectionBackend, $Query3)){
            throw new Exception("Problem in price update query for size code $SizeId : ".mysqli_error($DBConnectionBackend)) ;
        }
    }



    try{
        $ImageUpdater->deleteOldImageIfNeeded() ;
    }catch (Exception $e){
        throw new Exception("Problem in deleting the old image :".$e->getMessage()) ;
    }













    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;

    echo "
            Item Successfully Updated
            <br><br>
            <a href='all-menuitems.php' >Go Back</a>
        " ;







} catch (Exception $j){
    echo $j ;

    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;



    try{
        $ImageUpdater->revertBackChanges() ;
        echo "Reverted Changes" ;
    }catch (Exception $e){
        die("Problem in reverting back the changes: ".$e->getMessage()) ;
    }





}


?>