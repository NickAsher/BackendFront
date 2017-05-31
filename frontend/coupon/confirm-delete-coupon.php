<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$CouponType = isSecure_checkPostInput('__coupon_type') ;
$CouponId = isSecure_checkPostInput('__coupon_id') ;
?>


<h2>Are you sure you want to delete this item</h2>

<form method="post" action="process-delete-coupon.php">
    <input type="hidden" name="__coupon_id" value="<?php echo $CouponId ; ?> ">
    <input type="hidden" name="__coupon_type" value="<?php echo $CouponType ; ?> ">

    <input type="submit" name="__is_delete" value="Yes, Delete it">
</form>



<form method='post' action="all-coupons.php">
    <input type="submit" value="No, don't Delete it">
</form>