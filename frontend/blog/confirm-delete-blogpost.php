<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$BlogId = isSecure_checkPostInput('__blog_id') ;

?>


<h2>Are you sure you want to delete this item</h2>

<form method="post" action="process-delete-blogpost.php">
    <input type="hidden" name="__blog_id" value="<?php echo $BlogId ; ?> ">
    <input type="submit" name="__is_delete" value="Yes, Delete it">
</form>



<form method='post' action="all-blogpost.php">
    <input type="submit" value="No, don't Delete it">
</form>