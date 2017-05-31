<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

isSecure_checkPostInput('__coupon_name') ;

$CouponId = $_POST['__coupon_id'] ;
$CouponName = $_POST['__coupon_name'] ;
$CouponDescription = $_POST['__coupon_description'] ;
$CouponLongNotificatioMsg = $_POST['__coupon_notf_msg_long'] ;
$CouponShortNotificatioMsg = $_POST['__coupon_notf_msg_short'] ;
$CouponActive = '1' ;
$CouponType =  $_POST['__coupon_type'] ;


$CouponExpiryTimestamp = $_POST['__coupon_expiry'] ;
$CouponMinBill = $_POST['__coupon_min_bill'] ;
$CouponMaxDiscount = null ;
switch ($CouponType){
    case 'CART_DISC_MON' :
        $CouponMaxDiscount = "0" ;
        break ;
    case 'CART_DISC_PERC' :
        $CouponMaxDiscount = $_POST['__coupon_max_discount'] ;

        break ;
}




$CouponValidItems = $_POST['__coupon_items'] ;
$CouponValidUsers = $_POST['__coupon_valid_user'] ;
$CouponMaxUses = $_POST['__coupon_max_uses'] ;
$CouponValue = $_POST['__coupon_value'] ;


$DBConnectionBackend = YOLOSqlConnect() ;
$Query = "UPDATE `coupon_coupons_discount_table`
          SET `name` = '$CouponName', `description` = '$CouponDescription', `long_notf_msg` = '$CouponLongNotificatioMsg',
          `short_notf_msg` = '$CouponShortNotificatioMsg', `active` = '$CouponActive', `expiry_timestamp` = '$CouponExpiryTimestamp',
          `min_bill_amt` = '$CouponMinBill', `max_discount_amt` = '$CouponMaxDiscount', `valid_items` = '$CouponValidItems',
          `valid_user` = '$CouponValidUsers', `max_uses` = '$CouponMaxUses', `value` = '$CouponValue'
           WHERE `id` = '$CouponId' " ;

//echo $Query ;




$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
if($QueryResult){
    echo "Successfully Updated the coupon values ";
    echo "
        <div >
            <a href='all-coupons.php'>
                Show All Coupons
            </a>
        </div> 
    ";

} else {
    echo "Problem in inserting values to the coupon_coupons_discount_table <br>".mysqli_error($DBConnectionBackend) ;
}






?>
