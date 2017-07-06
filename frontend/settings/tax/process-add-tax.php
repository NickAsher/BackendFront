<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;

$DBConnectionBackend = YOPDOSqlConnect() ;

$TaxName = isSecure_IsValidText(GetPostConst::Post, '__tax_name') ;
$TaxPercentage = isSecure_IsValidPositiveDecimal(GetPostConst::Post, '__tax_percentage') ;





$Query = "INSERT INTO `tax_table` (`tax_sr_no`, `tax_id`, `tax_name`, `tax_percentage`)
  SELECT COALESCE( (MAX( `tax_sr_no` ) + 1), 1), '', :tax_name, :tax_percentage " ;

try {
    $QueryResult = $DBConnectionBackend->prepare($Query);
    $QueryResult->execute([
        'tax_name' => $TaxName,
        'tax_percentage' => $TaxPercentage,
    ]);

    echo "
            Successfully inserted item
            <br>
            <a href='all-taxes.php'>Go Back</a>
        ";
} catch (Exception $e) {
    die("Problem in the tax insert query:<br>" . $e . "<br><a href='all-taxes.php'>Go Back</a>");
}





























?>