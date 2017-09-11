<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$RestaurantStart = isSecure_checkPostInput('__make_start') ;

?>


<h2>Are you sure you want to Start the Restaurant</h2>

<form method="post" action="process-start.php">
    <input type="hidden" name="__make_start" value='<?php echo "$RestaurantStart"  ?>'>
    <input type="submit" name="__make_confirm_start" value="Yes, Start it">
</form>



<form action="start_stop.php" method="get">
    <input type="submit" value="No, Don't Delete it">
</form>