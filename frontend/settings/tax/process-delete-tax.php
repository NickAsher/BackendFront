<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';

$DBConnectionBackend = YOLOSqlConnect() ;


$TaxId = isSecure_checkPostInput('__tax_id') ;


$Query = "DELETE FROM `tax_table` WHERE `tax_id` = '$TaxId' " ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query);
if(!$QueryResult){
    die("Unable to delete the item from tax_table:<br>".mysqli_error($DBConnectionBackend)."<br><a href='all-taxes.php'>Go Back</a>" ) ;
} else {
    echo "
        Item Successfully deleted
        <br><br>
        <a href='all-taxes.php'>Go Back</a>
    " ;

}



















?>