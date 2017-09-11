<?php


class Object_Notification{
    var $NotificationTitle ;
    var $notificationLabel ;
    var $notificationMessage ;

    var $notificationPriority ;
    var $notificationTimeToLive ;

    var $isBigImage ;
    var $BigImageLink ;

    var $notificationType ;
    var $notificationTargetEntityKey ;
    var $NotificationTargetEntityValue ;
    var $EntityExtra ;

    var $notificationResultDevicesReadched ;


    function __construct($label, $title, $message, $timeToLive, $isBigImage = false, $bigImageLink = "") {
        $this->notificationLabel   =   $label ;
        $this->NotificationTitle   =   $title ;
        $this->notificationMessage   =   $message ;
        $this->notificationPriority   =   "normal";
        $this->notificationTimeToLive   =   $timeToLive ;
        $this->isBigImage   =   $isBigImage ;
        $this->BigImageLink   =   $bigImageLink ;

    }


    function setNotificationType($DBConnectionFCM, $notificaitonType, $userEmail = null, $groupId = null){
        $this->notificationType = $notificaitonType ;
        switch ($notificaitonType){

            case "all":
                $TokenArray = getAllToken($DBConnectionFCM) ;
                $this->notificationTargetEntityKey = "registration_ids" ;
                $this->NotificationTargetEntityValue = $TokenArray ;
                $this->EntityExtra = "0" ;
                break;

            case "single":
                $UserEmail = $_POST['__notf_user_email'] ;
                $Token = getTokenFromEmail($DBConnectionFCM, $UserEmail) ;
                $this->notificationTargetEntityKey = "to" ;
                $this->NotificationTargetEntityValue = $Token ;
                $this->EntityExtra = $UserEmail ;
                break;

            case "group":
                $Group = $_POST['__notf_groups'] ;
                $this->EntityExtra = $Group ;

                break;
            default:
                $TokenArray = getAllToken($DBConnectionFCM) ;
                $this->notificationTargetEntityKey = "registration_ids" ;
                $this->NotificationTargetEntityValue = $TokenArray ;
                $this->EntityExtra = "0" ;

                break;

        }
    }






    function getTokenFromEmail($DBConnectionFCM, $Email){

        $Temp = '' ;

        $Query = "SELECT * FROM `user_token_table` WHERE `user_email` = '$Email'   " ;
        $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
        if($QueryResult){
            foreach ($QueryResult as $Record){
                $Temp = $Record ;
            }
            $Token = $Temp['user_token'] ;
            return $Token ;

        } else {
            echo " Unable to fetch the token from the database <br>".mysqli_error($DBConnectionFCM) ;
            return "-1" ;
        }

    }




    function toArray(){
        return array(
            $this->notificationTargetEntityKey=>$this->NotificationTargetEntityValue,
            "priority"=>$this->notificationPriority, //priority can be high or normal
            "time_to_live"=>$this->notificationTimeToLive, // time in seconds in which the message is to be delivered after this message won't be delivered
//            "notification"=>array(
//                "title"=>$NotificationTitle,
//                "body"=>"this is the notification body"
//            ),
            "data"=>array(
                "title"=>$this->NotificationTitle,
                "message"=>$this->notificationMessage
//                 "image"=>$this->BigImageLink   // this is used when we want to show a notification with Big Image
            )
        );
    }



    function saveToDatabase($DBConnectionFCM, $NoOfDevicesReached){
        $Date = date("Y-m-d") ;
        $Time = date("H:i:s") ;
        $Query = "INSERT INTO `notifications_table` VALUES ('', '$this->notificationLabel', '$this->NotificationTitle', '$this->notificationMessage', '$this->BigImageLink', '$this->notificationTimeToLive',
      '$Date', '$Time', '$this->$this->notificationType', '$this->EntityExtra', '$NoOfDevicesReached') ;  " ;

        $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
        if($QueryResult){
//        echo "Successfully saved the message in the messages tab" ;
            return true;
        } else {
            echo "Problem in saving this notification in the messages tab <br> ".mysqli_error($DBConnectionFCM) ;
            return false ;
        }

    }


}





class Object_NotificationGeneral{
    var $NotificationTitle ;
    var $notificationLabel ;
    var $notificationMessage ;

    var $notificationPriority ;
    var $notificationTimeToLive ;

    var $date ;
    var $time ;


    var $NOTF_TYPE_GENERAL = "GENERAL" ;
    var $NOTF_TYPE_OFFER = "OFFER" ;
    var $NOTF_TYPE_ORDER = "ORDER" ;




    function __construct($label, $title, $message, $timeToLive, $isBigImage = false, $bigImageLink = "") {
        $this->notificationLabel   =   $label ;
        $this->NotificationTitle   =   $title ;
        $this->notificationMessage   =   $message ;
        $this->notificationPriority   =   "normal";
        $this->notificationTimeToLive   =   $timeToLive ;
        $this->isBigImage   =   $isBigImage ;
        $this->BigImageLink   =   $bigImageLink ;
        $this->date   =   date('Y-m-d') ;
        $this->time   =   date('H:i:s') ;


    }




    function getAllToken($DBConnectionFCM){

        $TokenArray = '' ;
        $i = 0 ;

        $Query = "SELECT * FROM `user_token_table`   " ;
        $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
        if($QueryResult){
            foreach ($QueryResult as $Record){
                $TokenArray[$i] = $Record['user_token'] ;
                $i ++ ;
            }

            return $TokenArray ;

        } else {
            echo " Unable to fetch the tokens from the database <br>".mysqli_error($DBConnectionFCM) ;
            return "-1" ;
        }
    }











    function toArray($DBConnectionFCM){
        return array(
            "registration_ids"=>getAllToken($DBConnectionFCM),
            "priority"=>$this->notificationPriority, //priority can be high or normal
            "time_to_live"=>$this->notificationTimeToLive, // time in seconds in which the message is to be delivered after this message won't be delivered

            "data"=>array(
                "title"=>$this->NotificationTitle,
                "message"=>$this->notificationMessage,
                "date"=>$this->date,
                "time"=>$this->time,
                "type"=>$this->NOTF_TYPE_GENERAL
//                 "image"=>$this->BigImageLink   // this is used when we want to show a notification with Big Image
            )
        );
    }



    function saveToDatabase($DBConnectionFCM, $NoOfDevicesReached){
        $Query = "INSERT INTO `notifications_table` VALUES ('', '$this->notificationLabel', '$this->NotificationTitle', '$this->notificationMessage', '$this->BigImageLink', '$this->notificationTimeToLive',
      '$this->date', '$this->tim$this->e', '$NoOfDevicesReached') ;  " ;

        $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
        if($QueryResult){
//        echo "Successfully saved the message in the messages tab" ;
            return true;
        } else {
            echo "Problem in saving this notification in the messages tab <br> ".mysqli_error($DBConnectionFCM) ;
            return false ;
        }

    }


}






class Object_NotificationOrder{
    var $NotificationTitle ;
    var $notificationMessage ;

    var $notificationPriority ;
    var $notificationTimeToLive ;

    var $userEmail ;

    var $date ;
    var $time ;


    var $NOTF_TYPE_GENERAL = "GENERAL" ;
    var $NOTF_TYPE_OFFER = "OFFER" ;
    var $NOTF_TYPE_ORDER = "ORDER" ;







    function __construct($title, $message, $userEmail) {
        $this->NotificationTitle   =   $title ;
        $this->notificationMessage   =   $message ;
        $this->notificationPriority   =   "normal";
        $this->notificationTimeToLive   =   3600 ;
        $this->userEmail = $userEmail ;
        $this->date   =   date('Y-m-d') ;
        $this->time   =   date('H:i:s') ;

    }






    function getTokenFromEmail($DBConnectionFCM, $Email){

        $Temp = '' ;

        $Query = "SELECT * FROM `user_token_table` WHERE `user_email` = '$Email'   " ;
        $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
        if($QueryResult){
            foreach ($QueryResult as $Record){
                $Temp = $Record ;
            }
            $Token = $Temp['user_token'] ;
            return $Token ;

        } else {
            echo " Unable to fetch the token from the database <br>".mysqli_error($DBConnectionFCM) ;
            return "-1" ;
        }

    }







    function toArray($DBConnectionFCM){
        return array(
            "to"=>$this->getTokenFromEmail($DBConnectionFCM, $this->userEmail),
            "priority"=>$this->notificationPriority, //priority can be high or normal
            "time_to_live"=>$this->notificationTimeToLive, // time in seconds in which the message is to be delivered. After this time window, message won't be delivered

            "data"=>array(
                "title"=>$this->NotificationTitle,
                "message"=>$this->notificationMessage,
                "date"=>$this->date,
                "time"=>$this->time,
                "type"=>$this->NOTF_TYPE_ORDER
            )
        );
    }




}









function buildNotificationOffer_NewOrderAccept($DBConnection, $orderId){
    $Query = "SELECT * FROM `order_table` WHERE `order_id` = :order_id  " ;
    $QueryResult = $DBConnection->prepare($Query) ;
    $QueryResult->execute(['order_id'=>$orderId]) ;
    $AllResult = $QueryResult->fetch(PDO::FETCH_ASSOC) ;

    $orderNo = $AllResult['order_no'] ;
    $totalPrice = $AllResult['order_total'] ;
    $userId = $AllResult['user_id'] ;


    $Query2 = "SELECT * FROM `users_profile_table` WHERE `user_id` = :user_id ";
    $QueryResult2 = $DBConnection->prepare($Query2) ;
    $QueryResult2->execute(['user_id'=>$userId]) ;
    $userData = $QueryResult2->fetch(PDO::FETCH_ASSOC) ;

    $userName = $userData['user_firstname'] ;
    $userEmail = $userData['user_email'] ;

    $message = "Hey $userName  !, Your order is successfully placed at Bominos. Your order no is $orderNo amounting to a total of \$ $totalPrice " ;
    $NotificationOrderObject = new Object_NotificationOrder( "Order Accepted", $message, $userEmail) ;
    return $NotificationOrderObject ;

}


















function isEmailExists($DBConnectionFCM, $Email){
    $Query = "SELECT * FROM `user_token_table` WHERE `user_email` = '$Email'  " ;
    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){

        $NoOfRows = mysqli_num_rows($QueryResult) ;
        if($NoOfRows == 1){
            return true ;
        } else {
            return false ;
        }



    } else{
        echo "Efrror in checking whether the email exisits or not. <br> ".mysqli_error($DBConnectionFCM) ;
        return false ;
    }



}

function RegisterDevice($DBConnectionFCM, $Email, $Token){
    $Query = "INSERT INTO `user_token_table` VALUES ('', '$Email', '$Token') " ;
    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){
//        echo "Success" ;
        return 1 ;
    } else{
        echo "Error in inserting the values to the table <br> ".mysqli_error($DBConnectionFCM) ;
        return -1 ;
    }
}



function updateToken($DBConnectionFCM, $Email, $Token){
    $Query = "UPDATE `user_token_table` SET `user_token` = '$Token' WHERE `user_email` = '$Email'   " ;
    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){
//        echo "Successfully updated token" ;
        return 1 ;
    } else{
        echo "Error in updating the token in the table <br> ".mysqli_error($DBConnectionFCM) ;
        return -1 ;
    }

}


function getTokenFromEmail($DBConnectionFCM, $Email){

    $Temp = '' ;

    $Query = "SELECT * FROM `user_token_table` WHERE `user_email` = '$Email'   " ;
    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){
        foreach ($QueryResult as $Record){
            $Temp = $Record ;
        }
        $Token = $Temp['user_token'] ;
        return $Token ;

    } else {
        echo " Unable to fetch the token from the database <br>".mysqli_error($DBConnectionFCM) ;
        return "-1" ;
    }

}


function getAllToken($DBConnectionFCM){

    $TokenArray = '' ;
    $i = 0 ;

    $Query = "SELECT * FROM `user_token_table`   " ;
    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){
        foreach ($QueryResult as $Record){
            $TokenArray[$i] = $Record['user_token'] ;
            $i ++ ;
        }

        return $TokenArray ;

    } else {
        echo " Unable to fetch the tokens from the database <br>".mysqli_error($DBConnectionFCM) ;
        return "-1" ;
    }
}



function sendNotification($Headers, $NotificationPostFieldsArray){
    $url = "https://fcm.googleapis.com/fcm/send" ;

    $ch = curl_init();

//Setting the curl url
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($NotificationPostFieldsArray));

//finally executing the curl request
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }

//Now close the connection
    curl_close($ch);

    return $result ;
}



function StoreNotificationMessageInDB($DBConnectionFCM, $Label, $Title, $Message, $Image, $Expiry, $Target, $TargetExtra, $DevicesReached){
    $Date = date("Y-m-d") ;
    $Time = date("H:i:s") ;
    $Query = "INSERT INTO `notifications_table` VALUES ('', '$Label', '$Title', '$Message', '$Image', '$Expiry',
      '$Date', '$Time', '$Target', '$TargetExtra', '$DevicesReached') ;  " ;

    $QueryResult = mysqli_query($DBConnectionFCM, $Query) ;
    if($QueryResult){
//        echo "Successfully saved the message in the messages tab" ;
        return 1;
    } else {
        echo "Problem in saving this notification in the messages tab <br> ".mysqli_error($DBConnectionFCM) ;
        return -1 ;
    }

}






?>