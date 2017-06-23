<?php

require_once '../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once 'start_stop_utils.php' ;

$DBConnectionBackend = YOLOSqlConnect() ;

$RestaurantStart = isSecure_checkPostInput('__make_start') ;

if(  !isset($_POST['__make_confirm_start'])  || $RestaurantStart!='1' ){
    $DieMessage = "
                <h2>The page does not have necessary permission to start</h2>
                <br>
                <div>
                    <a  href='start_stop.php'>Go Back</a> 
                </div>
                
                " ;

    die($DieMessage) ;
}






try{
    SS_Start($DBConnectionBackend) ;
    echo "
        Successfully Started the system
        <a href='start_stop.php' >Go Back</a>
        " ;

} catch (Exception $e){
    echo $e ;
    echo "
        Error in starting the system : 
        <a href='start_stop.php' >Go Back</a>
        " ;

}


