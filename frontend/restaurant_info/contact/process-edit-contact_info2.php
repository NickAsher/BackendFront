<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once $ROOT_FOLDER_PATH.'/utils/updater-utils.php';


$DBConnectionBackend = YOLOSqlConnect() ;



$NewLatitude = isSecure_checkPostInput('__rest_latitude') ;
$NewLongitude = isSecure_checkPostInput('__rest_longitude') ;
$NewRestaurantName = isSecure_checkPostInput('__rest_name') ;
$NewRestaurantAddress1 = isSecure_checkPostInput('__rest_addr1') ;
$NewRestaurantAddress2 = isSecure_checkPostInput('__rest_addr2') ;
$NewRestaurantAddress3 = isSecure_checkPostInput('__rest_addr3') ;
$NewRestaurantHoursMonFri = isSecure_checkPostInput('__rest_hours1') ;
$NewRestaurantHoursSatSat = isSecure_checkPostInput('__rest_hours2') ;
$NewRestaurantPhoneNum = isSecure_checkPostInput('__rest_phone') ;
$NewRestaurantEmail = isSecure_checkPostInput('__rest_email') ;


$OldRestaurantMainImage_Name = isSecure_checkPostInput('__rest_old_main_image') ;
$OldRestaurantLogoImage_Name = isSecure_checkPostInput('__rest_old_logo_image') ;

$NewRestaurantMainImage = $_FILES['__rest_main_image'] ;
$NewRestaurantLogoImage = $_FILES['__rest_logo_image'] ;


$ImageUpdater1 = new ImageUpdater($DBConnectionBackend, $IMAGE_FOLDER_FILE_PATH, $OldRestaurantMainImage_Name, $NewRestaurantMainImage) ;
$ImageUpdater2 = new ImageUpdater($DBConnectionBackend, $IMAGE_FOLDER_FILE_PATH, $OldRestaurantLogoImage_Name, $NewRestaurantLogoImage) ;


try{
    $ImageUpdater1->update() ;
}catch (Exception $e1){
    die($e1->getMessage()) ;
}

try{
    $ImageUpdater2->update() ;
}catch (Exception $e2){
    $ImageUpdater1->revertBackChanges() ;
    die($e2->getMessage()) ;
}


$InsertedDisplayPic_Name1 = $ImageUpdater1->getInsertedImageName() ;
$isNewImageInserted1 = $ImageUpdater1->isNewImageInserted() ;


$InsertedDisplayPic_Name2 = $ImageUpdater2->getInsertedImageName() ;
$isNewImageInserted2 = $ImageUpdater2->isNewImageInserted() ;




mysqli_begin_transaction($DBConnectionBackend) ;
try {


    $Query = "UPDATE `info_contact_table` SET `latitude` = '$NewLatitude', `longitude` = '$NewLongitude',
          `restaurant_name` = '$NewRestaurantName', `restaurant_image` = '$InsertedDisplayPic_Name1', `restaurant_logo`='$InsertedDisplayPic_Name2',
          `restaurant_addr_1` = '$NewRestaurantAddress1', `restaurant_addr_2` = '$NewRestaurantAddress2', `restaurant_addr_3` = '$NewRestaurantAddress3',
          `restaurant_hours_monfri` = '$NewRestaurantHoursMonFri', `restaurant_hours_satsun` = '$NewRestaurantHoursSatSat',
          `restaurant_phone` = '$NewRestaurantPhoneNum', `restaurant_email` = '$NewRestaurantEmail'
           WHERE `restaurant_id` = '1'   ";

    $QueryResult = mysqli_query($DBConnectionBackend, $Query);
    if (!$QueryResult) {
        throw new Exception("Error in Setting the new values for the restaurant contact info <br> " . mysqli_error($DBConnectionBackend)) ;
    }






    mysqli_commit($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;

    echo "
            Item Successfully Updated
            <br><br>
            <a href='read_contact_info.php' >Go Back</a>
        " ;

    try{
        $ImageUpdater1->deleteOldImageIfNeeded() ;
    }catch (Exception $e){
        throw new Exception("Problem in deleting the old image for main :".$e->getMessage()) ;
    }

    try{
        $ImageUpdater2->deleteOldImageIfNeeded() ;
    }catch (Exception $e){
        throw new Exception("Problem in deleting the old image for logo but deleted it for main:".$e->getMessage()) ;
    }







} catch (Exception $j){
    echo $j ;

    mysqli_rollback($DBConnectionBackend) ;
    mysqli_autocommit($DBConnectionBackend, true) ;



    try{
        $ImageUpdater1->revertBackChanges() ;
        echo "Reverted Changes" ;
    }catch (Exception $e){
        die("Problem in reverting back the changes for main: ".$e->getMessage()) ;
    }

    try{
        $ImageUpdater2->revertBackChanges() ;
        echo "Reverted Changes" ;
    }catch (Exception $e){
        die("Problem in reverting back the changes for logo but did it right for main: ".$e->getMessage()) ;
    }





}

?>