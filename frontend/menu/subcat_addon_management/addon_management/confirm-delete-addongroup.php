<?php

require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;
$AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addongroup_rel_id') ;

?>


<h2>Are you sure you want to delete this item</h2>

<form method="post" action="process-delete-addongroup.php">
    <input type="hidden" name="__category_id" value='<?php echo "$CategoryId" ; ?>' > ;
    <input type="hidden" name="__addongroup_rel_id" value='<?php echo "$AddonGroupRelId" ;  ?>'> ;

    <input type="submit" name="__is_delete" value="Yes, Delete it">
</form>



<form action="../all-subcat.php" method="get">
    <input type="submit" value="No, Don't Delete it">
</form>