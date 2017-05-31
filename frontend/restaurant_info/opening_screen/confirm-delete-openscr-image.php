<?php

require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$ItemId = isSecure_checkPostInput('__item_id') ;

?>


<h2>Are you sure you want to delete this item</h2>

<form method="post" action="process-delete-openscr-image.php">
    <input type="hidden" name="__item_id" value="<?php echo $ItemId ; ?> ">
    <input type="submit" name="__is_delete" value="Yes, Delete it">
</form>



<form method='post' action="all-openscr-images.php">
    <input type="submit" value="No, don't Delete it">
</form>