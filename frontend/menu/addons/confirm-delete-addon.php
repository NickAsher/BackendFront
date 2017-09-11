<?php

require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addon_group_rel_id');
$AddonItemId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addon_id') ;

?>


<h2>Are you sure you want to delete this item</h2>

<form method="post" action="process-delete-addon.php">
    <input type="hidden" name="__addon_group_rel_id" value='<?php echo "$AddonGroupRelId" ; ?>' > ;
    <input type="hidden" name="__addon_id" value='<?php echo "$AddonItemId" ;  ?>'> ;

    <input type="submit" name="__is_delete" value="Yes, Delete it">
</form>



<form action="all-addons.php" method="get">
    <input type="submit" value="No, Don't Delete it">
</form>