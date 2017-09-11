<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once $ROOT_FOLDER_PATH.'/utils/updater-utils.php';


$DBConnectionBackend = YOPDOSqlConnect() ;
$DBConnectionBackend_Old = YOLOSqlConnect() ;



$NewLatitude = isSecure_isValidDecimal(GetPostConst::Post, '__rest_latitude') ;
$NewLongitude = isSecure_isValidDecimal(GetPostConst::Post, '__rest_longitude') ;
$NewRestaurantName = isSecure_IsValidText(GetPostConst::Post, '__rest_name') ;
$NewRestaurantAddress1 = isSecure_IsValidText(GetPostConst::Post, '__rest_addr1') ;
$NewRestaurantAddress2 = isSecure_IsValidText(GetPostConst::Post, '__rest_addr2') ;
$NewRestaurantAddress3 = isSecure_IsValidText(GetPostConst::Post, '__rest_addr3') ;

$NewRestaurantPhoneNum = isSecure_isValidPhoneNum(GetPostConst::Post, '__rest_phone') ;
$NewRestaurantEmail = isSecure_isValidEmail(GetPostConst::Post, '__rest_email') ;


$RestHours = array(

        array(
           'start_time'=>isSecure_checkPostInput('__rest_hours_mon_start'),
           'end_time'=>isSecure_checkPostInput('__rest_hours_mon_end')
        ),
        array(
            'start_time'=>isSecure_checkPostInput('__rest_hours_tue_start'),
            'end_time'=>isSecure_checkPostInput('__rest_hours_tue_end')
        ),
        array(
            'start_time'=>isSecure_checkPostInput('__rest_hours_wed_start'),
            'end_time'=>isSecure_checkPostInput('__rest_hours_wed_end')
        ),
        array(
            'start_time'=>isSecure_checkPostInput('__rest_hours_thu_start'),
            'end_time'=>isSecure_checkPostInput('__rest_hours_thu_end')
        ),
        array(
            'start_time'=>isSecure_checkPostInput('__rest_hours_fri_start'),
            'end_time'=>isSecure_checkPostInput('__rest_hours_fri_end')
        ),
        array(
            'start_time'=>isSecure_checkPostInput('__rest_hours_sat_start'),
            'end_time'=>isSecure_checkPostInput('__rest_hours_sat_end')
        ),
        array(
            'start_time'=>isSecure_checkPostInput('__rest_hours_sun_start'),
            'end_time'=>isSecure_checkPostInput('__rest_hours_sun_end')
        )

) ;

$RestHours = json_encode($RestHours) ;


$OldRestaurantMainImage_Name = isSecure_checkPostInput('__rest_old_main_image') ;
$OldRestaurantLogoImage_Name = isSecure_checkPostInput('__rest_old_logo_image') ;

$NewRestaurantMainImage = $_FILES['__rest_main_image'] ;
$NewRestaurantLogoImage = $_FILES['__rest_logo_image'] ;


$ImageUpdater1 = new ImageUpdater($DBConnectionBackend_Old, $IMAGE_FOLDER_FILE_PATH, $OldRestaurantMainImage_Name, $NewRestaurantMainImage) ;
$ImageUpdater2 = new ImageUpdater($DBConnectionBackend_Old, $IMAGE_FOLDER_FILE_PATH, $OldRestaurantLogoImage_Name, $NewRestaurantLogoImage) ;


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




try {
    $DBConnectionBackend->beginTransaction() ;


    $Query = "UPDATE `info_contact_table` SET `latitude` = :latitude, `longitude` = :longitude,
          `restaurant_name` = :rest_name, `restaurant_image` = :rest_image, `restaurant_logo`= :rest_logo,
          `restaurant_addr_1` = :rest_addr1, `restaurant_addr_2` = :rest_addr2, `restaurant_addr_3` = :rest_addr3,
          `restaurant_hours` = :rest_hours,
          `restaurant_phone` = :rest_phone, `restaurant_email` = :rest_email
           WHERE `restaurant_id` = '1'   ";

    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'latitude' => $NewLatitude,
            'longitude' => $NewLongitude,
            'rest_name' => $NewRestaurantName,
            'rest_image' => $InsertedDisplayPic_Name1,
            'rest_logo' => $InsertedDisplayPic_Name2,
            'rest_addr1' => $NewRestaurantAddress1,
            'rest_addr2' => $NewRestaurantAddress2,
            'rest_addr3' => $NewRestaurantAddress3,
            'rest_hours' => $RestHours,
            'rest_phone' => $NewRestaurantPhoneNum,
            'rest_email' => $NewRestaurantEmail


        ]);
    } catch (Exception $e) {
        throw new Exception("Error in Setting the new values for the restaurant contact info <br> " . $e) ;
    }






    $DBConnectionBackend->commit() ;

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

    $DBConnectionBackend->rollBack() ;



    try{
        $ImageUpdater1->revertBackChanges() ;
        echo "Reverted Changes for image updater 1" ;
    }catch (Exception $e){
        die("Problem in reverting back the changes for updater 1: ".$e->getMessage()) ;
    }

    try{
        $ImageUpdater2->revertBackChanges() ;
        echo "Reverted Changes for image updater 2" ;
    }catch (Exception $e){
        die("Problem in reverting back the changes for updater 2 but did it right for updater 1: ".$e->getMessage()) ;
    }





}

?>