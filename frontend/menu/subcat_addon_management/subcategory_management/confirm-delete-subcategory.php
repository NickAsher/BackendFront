<?php

require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code') ;
$SubCategoryRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__subcategory_rel_id') ;

?>


<h2>Are you sure you want to delete this item</h2>

<form method="post" action="process-delete-subcategory.php">
    <input type="hidden" name="__category_code" value='<?php echo "$CategoryCode" ; ?>'> ;
    <input type="hidden" name="__subcategory_rel_id" value='<?php echo "$SubCategoryRelId" ; ?>'> ;

    <input type="submit" name="__is_delete" value="Yes, Delete it">
</form>


<form action="../all-subcat.php" method="get">
    <input type="submit" value="No, Don't Delete it">
</form>