<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once '../utils/menu-utils.php';


$DBConnectionBackend = YOLOSqlConnect() ;

$ItemId = isSecure_checkPostInput('__item_id') ;
$ItemName = isSecure_checkPostInput('__item_name') ;
$ItemDescription = isSecure_checkPostInput('__item_description') ;
$NoOfSizeVariations = isSecure_checkPostInput('__category_no_of_size_variations') ;


$ItemPriceSize1 = isSecure_checkPostInput('__item_price_size1') ;
$ItemPriceSize2 = isSecure_checkPostInput('__item_price_size2') ;
$ItemPriceSize3 = isSecure_checkPostInput('__item_price_size3') ;

    $ItemInfoArray = getSingleMenuItemInfoArray($DBConnectionBackend, $ItemId) ;
    $OldDisplayPic_Name = $ItemInfoArray['item_image_name'] ;
    $NewDisplayPic = $_FILES['__new_item_image'] ;




    $InsertedDisplayPic_Name = null;
    $NewDisplayPic_Boolean = null ;

    if($NewDisplayPic['size'] == 0 || $NewDisplayPic['error'] == 4){
        $NewDisplayPic_Boolean = false ;
        $InsertedDisplayPic_Name = $OldDisplayPic_Name ;
    } else{
        $NewDisplayPic_Boolean = true ;
        $NewDisplayPic_Name = moveImageToImageFolder($DBConnectionBackend, $IMAGE_FOLDER_FILE_PATH, $NewDisplayPic) ;
        if($NewDisplayPic_Name == -1){
            die("Problem in uploading the new image") ;
        }
        $InsertedDisplayPic_Name = $NewDisplayPic_Name ;
    }



mysqli_begin_transaction($DBConnectionBackend) ;
try{

    $Query = "UPDATE `menu_items_table` SET
                  `item_name` = '$ItemName', `item_description` = '$ItemDescription', `item_image_name` = '$InsertedDisplayPic_Name'
                  WHERE `item_id` = '$ItemId'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        throw new Exception("Probelm in the item insert query: ".mysqli_error($DBConnectionBackend)) ;
    }




    for($i=1; $i<=$NoOfSizeVariations; $i++){
        $ItemPriceSize = isSecure_checkPostInput("__item_price_size$i") ;

        $Query2 = "UPDATE `menu_meta_rel_size-items_table` SET `item_price` = '$ItemPriceSize' WHERE `item_id` = '$ItemId' AND `size_sr_no` = '$i' " ;
        if(!mysqli_query($DBConnectionBackend, $Query2)){
            throw new Exception("Problem in price size insert query $i : ".mysqli_error($DBConnectionBackend)) ;
        }
    }


    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;



        echo "
            Item Successfully Updated
            <br><br>
            <a href='all-menuitems.php' >Go Back</a>
        " ;

        /*
        * Delete Old Image Files
        */


        /*
         * Now the case here is that an image is updated(can be old, can be new, we don't know)
         * And there is a successfull update in the database.
         * So now there are two cases that arise
         * The inserted image is new(new image was inserted) or the inserted image is old(old image was inserted)
         *
         * If the inserted image is new, then we have to delete the old one
         * If the inserted image is old, then we don't have to do anything
         */

        if($NewDisplayPic_Boolean == true){
            // Inserted Pic is new so delete the old one
            $Del = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $OldDisplayPic_Name) ;
            if($Del){
                echo "Old Display Image is deleted" ;
            }
        }else{
            // Inserted Image is old so delete nothing
        }







} catch (Exception $e){
    echo $e ;

    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;






    /*
         * Now is the case when a image is updated (can be old, can be new, we don't know)
         * But there is a problem in updating the database.
         * SO now the transaction is rolled back, so we have to undo any changes to image
         *
         * So if the inserted image is new, then we delete it
         * but if the inserted image was old, then do nothing
         *
         */

    if($NewDisplayPic_Boolean == true){
        // inserted image is new, delete it
        $Del = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $NewDisplayPic_Name) ;
        if($Del){
            echo "New Display Image is deleted" ;
        }

    }else{
        // image uploaded is old so delete nothing
    }




}


?>