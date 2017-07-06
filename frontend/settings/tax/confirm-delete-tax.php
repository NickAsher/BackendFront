<?php

require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$TaxId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__tax_id') ;
?>


<h2>Are you sure you want to delete this item</h2>

<form method="post" action="process-delete-tax.php">
    <input type="hidden" name="__tax_id" value='<?php echo $TaxId ?>'>
    <input type="submit" name="__is_delete" value="Yes, Delete it">
</form>



<form action="all-taxes.php" method="get">
    <input type="submit" value="No, Don't Delete it">
</form>