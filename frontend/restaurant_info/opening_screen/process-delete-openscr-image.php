<?php

require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'utils-openscr.php' ;


$ItemId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__item_id') ;



$DBConnectionBackend = YOPDOSqlConnect() ;

try{
    $DBConnectionBackend->beginTransaction() ;



    $Query = "SELECT * FROM `opening_screen_images_table` WHERE `item_id` = :item_id " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute(['item_id'=>$ItemId]) ;
        $GalleryInfoArray = $QueryResult->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        throw new Exception("Problem in fetching the Record from opening screen table : ".$e );
    }


    $GalleryItem_ImageName = $GalleryInfoArray['item_image'] ;

    try {
        $Del1 = deleteImageFromImageFolderNew($IMAGE_FOLDER_FILE_PATH, $GalleryItem_ImageName);
    }catch (Exception $e){
        throw new Exception("Unable to delete the image from image folder : ".$e );
    }




    $Query2 = "DELETE FROM `opening_screen_images_table` WHERE `item_id` = :item_id  " ;
    try {
        $QueryResult2 = $DBConnectionBackend->prepare($Query2);
        $QueryResult2->execute(['item_id' => $ItemId]);
    } catch (Exception $e) {
        throw new Exception("Problem in deleting the Record from opening screen table : ".$e );
    }






    $AllOpeningScrImages = getAllOpeningScreenImages($DBConnectionBackend) ;
    if(count($AllOpeningScrImages) != 0 ){


        $CaseStatement = '' ;
        $RealSortNo = 1 ;
        foreach ($AllOpeningScrImages as $Record2){
            $ThisItem_ItemId = $Record2['item_id'] ;
            $CaseStatement .= "WHEN `item_id` = '$ThisItem_ItemId' THEN '$RealSortNo' " ;
            $RealSortNo ++ ;
        }

        $Query3 = "UPDATE `opening_screen_images_table` SET `item_sr_no` = CASE $CaseStatement END   " ;
        try {
            $QueryResult3 = $DBConnectionBackend->query($Query3);
        }catch (Exception $e){
            throw new Exception("Error in sorting the new Opening Screen Images: ". $e->getMessage());
        }
    }


    $DBConnectionBackend->commit() ;







    echo "
    <div >
        <a href='all-openscr-images.php'>
            Show All posts
        </a>
    </div>
    " ;



} catch(Exception $j){
    $DBConnectionBackend->rollBack() ;
    die($j) ;
}





?>


