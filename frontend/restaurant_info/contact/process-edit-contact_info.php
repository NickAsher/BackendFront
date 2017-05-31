<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;

$DBConnectionBackend = YOLOSqlConnect() ;

if (  isset($_POST['__rest_latitude'])  && !empty($_POST['__rest_latitude'])  ){
    $NewLatitude = $_POST['__rest_latitude'] ;
    $NewLongitude = $_POST['__rest_longitude'] ;
    $NewRestaurantName = $_POST['__rest_name'] ;
    $NewRestaurantImage = $_POST['__rest_image'] ;
    $NewRestaurantAddress1 = $_POST['__rest_addr1'] ;
    $NewRestaurantAddress2 = $_POST['__rest_addr2'] ;
    $NewRestaurantAddress3 = $_POST['__rest_addr3'] ;
    $NewRestaurantHoursMonFri = $_POST['__rest_hours1'] ;
    $NewRestaurantHoursSatSat = $_POST['__rest_hours2'] ;
    $NewRestaurantPhoneNum = $_POST['__rest_phone'] ;
    $NewRestaurantEmail = $_POST['__rest_email'] ;



    $Query = "UPDATE `info_contact_table` SET `latitude` = '$NewLatitude', `longitude` = '$NewLongitude',
          `restaurant_name` = '$NewRestaurantName', `restaurant_image` = '$NewRestaurantImage',
          `restaurant_addr_1` = '$NewRestaurantAddress1', `restaurant_addr_2` = '$NewRestaurantAddress2', `restaurant_addr_3` = '$NewRestaurantAddress3',
          `restaurant_hours_monfri` = '$NewRestaurantHoursMonFri', `restaurant_hours_satsun` = '$NewRestaurantHoursSatSat',
          `restaurant_phone` = '$NewRestaurantPhoneNum', `restaurant_email` = '$NewRestaurantEmail'
           WHERE `restaurant_id` = '1'   " ;

    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;

    if($QueryResult) {

        echo "Successfully update the Contact info values " ;
        echo "
        <div>
            <a href='read_contact_info.php' >Go back</a>
        </div>
        ";

    } else {
        echo "Error in Setting the new values for the restaurant contact info <br> ".mysqli_error($DBConnectionBackend) ;
    }
}


?>