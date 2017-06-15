<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';

$DBConnectionBackend = YOLOSqlConnect() ;

$TaxName = isSecure_checkPostInput('__tax_name') ;
$TaxPercentage = isSecure_checkPostInput('__tax_percentage') ;
$TaxSrNo = isSecure_checkPostInput('__tax_sr_no') ;





$Query = "INSERT INTO `tax_table` VALUES ('', '$TaxName', '$TaxPercentage', '$TaxSrNo')  " ;

$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
if(!$QueryResult) {
    die("Problem in the item insert query:<br>" . mysqli_error($DBConnectionBackend) . "<br><a href='all-taxes.php'>Go Back</a>");
} else {
    echo "
        Successfully inserted item
        <br>
        <a href='all-taxes.php'>Go Back</a>
    " ;
}






























?>