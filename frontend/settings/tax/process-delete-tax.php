<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOPDOSqlConnect() ;


$TaxId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__tax_id') ;


$Query = "DELETE FROM `tax_table` WHERE `tax_id` = :tax_id " ;
try {
    $QueryResult = $DBConnectionBackend->prepare($Query);
    $QueryResult->execute(['tax_id' => $TaxId]);

    echo "
        Item Successfully deleted
        <br><br>
        <a href='all-taxes.php'>Go Back</a>
    " ;


} catch (Exception $e) {
    die("Unable to delete the item from tax_table:<br>" . $e . "<br><a href='all-taxes.php'>Go Back</a>");
}



















?>