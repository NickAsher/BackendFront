<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';

$DBConnectionBackend = YOLOSqlConnect() ;

$TaxId = isSecure_checkPostInput('__tax_id') ;
$TaxName = isSecure_checkPostInput('__tax_name') ;
$TaxSrNo = isSecure_checkPostInput('__tax_sr_no') ;
$TaxPercentage = isSecure_checkPostInput('__tax_percentage') ;



$Query = "UPDATE `tax_table` SET `tax_name` = '$TaxName', `tax_percentage` = '$TaxPercentage', `tax_sr_no` = '$TaxSrNo' WHERE `tax_id` = '$TaxId'  " ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
if(!$QueryResult){
    die("Probelm in the update tax_table: <br>".mysqli_error($DBConnectionBackend)."<br><a href='all-taxes.php'>Go back</a>") ;
} else {
    echo "
        Item Successfully Updated
        <br><br>
        <a href='all-taxes.php' >Go Back</a>
    " ;
}





















?>