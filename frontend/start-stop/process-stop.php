<?php

require_once '../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once 'start_stop_utils.php' ;

$DBConnectionBackend = YOLOSqlConnect() ;

$RestaurantStop = isSecure_checkPostInput('__make_stop') ;

if(  !isset($_POST['__make_confirm_stop'])  || $RestaurantStop!='1' ){
    $DieMessage = "
                <h2>The page does not have necessary permission to start</h2>
                <br>
                <div>
                    <a  href='start_stop.php'>Go Back</a> 
                </div>
                
                " ;

    die($DieMessage) ;
}







    if(SS_Stop($DBConnectionBackend)) {

        echo "
        Successfully Stopped the system
        <a href='start_stop.php' >Go Back</a>
        ";

    } else {

    echo "
        Error in Stopped the system : 
        <a href='start_stop.php' >Go Back</a>
        " ;

}


