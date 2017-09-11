<?php

require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$ItemId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__gallery_id') ;

?>


<h2>Are you sure you want to delete this item</h2>

<form method="post" action="process-delete-gallery-item.php">
    <input type="hidden" name="__gallery_id" value="<?php echo $ItemId ; ?> ">
    <input type="submit" name="__is_delete" value="Yes, Delete it">
</form>



<form method='post' action="all-gallery-items.php">
    <input type="submit" value="No, don't Delete it">
</form>