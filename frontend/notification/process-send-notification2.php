<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php'  ;
require_once 'utils-notification.php';

if(isset($_POST['__notf_title']) ){
    if(!empty($_POST['__notf_title'])   ){

        $DBConnectionFCM = YOLOSqlFCMConnect() ;

//        $NotificationLabel = $_POST['__notf_label'] ;
                $NotificationLabel = "uo" ;
//
        $NotificationTitle = $_POST['__notf_title'] ;
        $NotificationMessage = $_POST['__notf_message'] ;
        // input type = number still returns a string as there is no concept of datatypes in html and http
        // the input type = number is just there to let the mobile browsers show the right type of numeric keyboard
        // so intval is used to convert string to integer
        $NotificationTimeToLive = intval($_POST['__notf_exp_time']) ;



        $NotificationOffer = new Object_NotificationGeneral($NotificationLabel, $NotificationTitle, $NotificationMessage, $NotificationTimeToLive) ;




        $NotificationField = $NotificationOffer->toArray($DBConnectionFCM) ;
//        print_r($NotificationField) ;


//        $FirebaseServerKey = "AAAAZgNIAsg:APA91bGLRY-RI_BCeU6cYici5dkc3tmPqk2wVlXkMAOD58gY44duS4I-wHbZH77vtFXOIuFRfxE9-Y0q4TNV8mXeMbX7kf5O_UUN817XLlpTOH7fwNmvIrekP-O4Vx6pWnLfWPlo-0SA"  ;
        $FirebaseServerKey = "AAAALmcsK8k:APA91bEK5ca8CiyFeKtLRoazGTMwiMiR4jVdK0oBy_goqY4G0XQARRS8qyZYy91Itm9kVGjIHIk4KUV3lUvMGLPwaiGnYDQ3BsXci5GvaGcosijjTULeZ6tYhKyMHjadi2kYAcaKDKWo" ;

        $headers = array(
            'Authorization: key='.$FirebaseServerKey,
            'Content-Type: application/json'
        );

        $SendNotificationResult = sendNotification($headers, $NotificationField) ;



        $SendNotificationResult = json_decode($SendNotificationResult) ;
        $Success = '' ;

        if($SendNotificationResult->failure == 0){
            $Success = true ;
        } else {
            $Success = false ;
        }

        if($Success){
            $DevicesReached = $SendNotificationResult->success ;

            $StoreMessageResult = StoreNotificationMessageInDB($DBConnectionFCM, $NotificationLabel, $NotificationTitle, $NotificationMessage,
                "", $NotificationTimeToLive, "All", "0", $DevicesReached) ;

            if($StoreMessageResult == 1){
                echo "Successfully sent the message <br> Saved it to Database <br> No of devices reached is $DevicesReached" ;

            } else{
                echo "Successfully sent the message BUT PROBLEM IN SAVING IT TO DATABASE <br> No of devices reached is $DevicesReached" ;
            }


        } else {
            echo "PROBLEM IN SENDING THE NOTIFICATION" ;
        }











//        echo $SendNotificationResult ;





    }
}

?>