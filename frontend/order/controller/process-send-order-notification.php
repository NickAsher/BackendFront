<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php'  ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php';

require_once $ROOT_FOLDER_PATH.'/frontend/notification/utils-notification.php';



        $DBConnectionFCM = YOLOSqlFCMConnect() ;
        $DBConnectionBackend = YOPDOSqlConnect() ;

        $orderId = isSecure_checkGetInput_string('__order_id') ;





        $NotificationOrder = buildNotificationOffer_NewOrderAccept($DBConnectionBackend, $orderId) ;




        $NotificationField = $NotificationOrder->toArray($DBConnectionFCM) ;
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



                echo "Successfully sent the message <br> Saved it to Database <br> No of devices reached is $DevicesReached" ;




        } else {
            echo "PROBLEM IN SENDING THE NOTIFICATION" ;
        }











//        echo $SendNotificationResult ;






?>