<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;

$DBConnectionBackend = YOPDOSqlConnect() ;

$TaxId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__tax_id') ;
$TaxName = isSecure_IsValidText(GetPostConst::Post, '__tax_name') ;
$TaxPercentage = isSecure_IsValidPositiveDecimal(GetPostConst::Post, '__tax_percentage') ;



$Query = "UPDATE `tax_table` 
    SET `tax_name` = :tax_name, `tax_percentage` = :tax_percentage
    WHERE `tax_id` = :tax_id  " ;

try {
    $QueryResult = $DBConnectionBackend->prepare($Query);
    $QueryResult->execute([
        'tax_name' => $TaxName,
        'tax_percentage' => $TaxPercentage,
        'tax_id'=>$TaxId
    ]);

    echo "
            Successfully updated item
            <br>
            <a href='all-taxes.php'>Go Back</a>
        ";
} catch (Exception $e) {
    die("Problem in the tax update query:<br>" . $e . "<br><a href='all-taxes.php'>Go Back</a>");
}























?>