<?php


require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'utils/gallery-utils.php';

$GalleryItemId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__gallery_id') ;

$DBConnectionBackend = YOPDOSqlConnect() ;

/*
 *  The item image name is taken from database instead of directly sending through post
 *  so that no one justs sends a post request to this page and deletes the photo.
 *  Because gallery item id is used afterwards, firstly the photo name is used to delete the photo.
 *  So that's why we fetch this.
*/







try{
    $DBConnectionBackend->beginTransaction() ;

    $GalleryInfoArray = getGalleryItemInfo($DBConnectionBackend, $GalleryItemId) ;

    $GalleryItem_ImageName = $GalleryInfoArray['gallery_item_image_name'] ;


    $Del1 = deleteImageFromImageFolderNew($IMAGE_FOLDER_FILE_PATH, $GalleryItem_ImageName) ;



    $Query = "DELETE FROM `gallery_table` WHERE `gallery_item_id` = :gallery_item_idd  " ;
    $QueryResult = $DBConnectionBackend->prepare($Query) ;
    $QueryResult->execute(['gallery_item_idd'=>"$GalleryItemId"]) ;






    // Now we are going to sort the gallery items after an item is deleted
    // Since there is no user input in sorting the items,
    // we don't have to use prepared statements here
    $ListOfAllGalleryItems = getListOfAllGalleryItems($DBConnectionBackend) ;
    $CaseStatement = '' ;
    $RealSortNo = 1 ;
    foreach ($ListOfAllGalleryItems as $Record2){
        $ThisGalleryItem_ItemId = $Record2['gallery_item_id'] ;
        $CaseStatement .= "WHEN `gallery_item_id` = '$ThisGalleryItem_ItemId' THEN '$RealSortNo' " ;
        $RealSortNo ++ ;
    }

    $Query3 = "UPDATE `gallery_table` SET `gallery_item_sr_no` = CASE $CaseStatement END   " ;
    $DBConnectionBackend->query($Query3) ;








    $DBConnectionBackend->commit() ;
    echo "Successfully deleted the item and sorted the others <a href='all-gallery-items.php'>Go Back</a>" ;
}catch(Exception $e) {
    $DBConnectionBackend->rollBack() ;
    echo "unable to delete the gallery item but the image is deleted <br> ".$e->getMessage() ;
}






?>

