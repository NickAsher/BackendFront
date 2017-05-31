<?php

require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$CategoryCode = isSecure_checkPostInput('__category_code') ;
$SubCategoryCode = isSecure_checkPostInput('__subcategory_code') ;

?>


<h2>Are you sure you want to delete this item</h2>

<form method="post" action="process-delete-subcategory.php">
    <input type="hidden" name="__category_code" value='<?php echo "$CategoryCode" ; ?>'> ;
    <input type="hidden" name="__subcategory_code" value='<?php echo "$SubCategoryCode" ; ?>'> ;

    <input type="submit" name="__is_delete" value="Yes, Delete it">
</form>


<form action="all-subcat.php" method="get">
    <input type="submit" value="No, Don't Delete it">
</form>