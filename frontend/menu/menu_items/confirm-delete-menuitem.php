<?php

require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$MenuItemId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__menu_item_id') ;

?>


<h2>Are you sure you want to delete this item</h2>

<form method="post" action="process-delete-menuitem.php">
    <input type="hidden" name="__menu_item_id" value='<?php echo "$MenuItemId"  ?>'>

    <input type="submit" name="__is_delete" value="Yes, Delete it">
</form>



<form action="all-menuitems.php" method="get">
    <input type="submit" value="No, Don't Delete it">
</form>