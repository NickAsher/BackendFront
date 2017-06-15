<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$RestaurantStop = isSecure_checkPostInput('__make_stop') ;

?>


<h2>Are you sure you want to STOP the Restaurant System</h2>

<form method="post" action="process-stop.php">
    <input type="hidden" name="__make_stop" value='<?php echo "$RestaurantStop"  ?>'>
    <input type="submit" name="__make_confirm_stop" value="Yes, Stop it">
</form>



<form action="start_stop.php" method="get">
    <input type="submit" value="No, Don't Stop it">
</form>