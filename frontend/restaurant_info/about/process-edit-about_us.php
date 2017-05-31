<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;

$DBConnectionBackend = YOLOSqlConnect() ;

isSecure_checkPostInput('__new_about_us_description') ;



    $Query = "SELECT * FROM `info_about_table` WHERE `restaurant_id` = '1'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    $AboutInfoArray = '' ;
    if($QueryResult) {
        foreach ($QueryResult as $Record) {
            $AboutInfoArray = $Record;
        }

    } else{
        die("Problem in getting the Aboutus info from info_about_table <br> ".mysqli_error($DBConnectionBackend)) ;

    }



$OldDisplayImage_Name = $AboutInfoArray['about_us_image'] ;


$NewAboutUs = $_POST['__new_about_us_description'] ;
$NewAboutUs = mysqli_real_escape_string($DBConnectionBackend, $NewAboutUs) ;
$NewAboutUsImage = $_FILES['__new_about_us_image'] ;



$InsertedDisplayPic_Name = null;

if($NewAboutUsImage['size'] == 0 || $NewAboutUsImage['error'] == 4){
    $NewAboutUsImage_Boolean = false ;
    $InsertedDisplayPic_Name = $OldDisplayImage_Name ;
} else{
    $NewAboutUsImage_Boolean = true ;
    $NewAboutUsImage_Name = moveImageToImageFolder($DBConnectionBackend, $IMAGE_FOLDER_FILE_PATH, $NewAboutUsImage) ;
    if($NewAboutUsImage == -1){
        die("Problem in uploading the new image") ;
    }
    $InsertedDisplayPic_Name = $NewAboutUsImage_Name ;
}




$Query = "UPDATE `info_about_table` 
            SET `about_us1` = '$NewAboutUs', `about_us_image` = '$InsertedDisplayPic_Name' 
          WHERE `restaurant_id` = '1'   " ;


$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
if($QueryResult){
    echo "Successfully updated the about us values " ;


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

    if($NewAboutUsImage_Boolean == true){

        // Inserted Pic is new so delete the old one
        deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $OldDisplayImage_Name) ;
        echo "Old Display Image is deleted" ;
    }else{
        // Inserted Image is old so delete nothing
    }


}


else {
    echo "Error in Setting the new values for the restaurant about us info <br> ".mysqli_error($DBConnectionBackend) ;

    /*
     * Now is the case when a image is update (can be old, can be new, we don't know)
     * But there is a problem in updating the database.
     * So what we have to do is just like a transaction, we roll back any changes
     *
     * So if the inserted image is new, then we delete it
     * but if the inserted image was old, then do nothing
     *
     */

    if($NewAboutUsImage_Boolean == true){
        // inserted image is new, delete it
        deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $InsertedDisplayPic_Name) ;
        echo "New Display Image is deleted" ;

    }else{
        // image uploaded is old so delete nothing
    }



}









?>