<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

isSecure_checkPostInput('__coupon_name') ;

$CouponName = $_POST['__coupon_name'] ;
$CouponDescription = $_POST['__coupon_description'] ;
$CouponLongNotificationMsg = $_POST['__coupon_notf_msg_long'] ;
$CouponShortNotificationMsg = $_POST['__coupon_notf_msg_short'] ;
$CouponActive = '1' ;
$CouponType = $_POST['__coupon_type'] ;



$CouponCreationTimestamp = date('Y-m-d H:i:s') ;
$CouponExpiryTimestamp = $_POST['__coupon_expiry'] ;
$CouponMinBill = $_POST['__coupon_min_bill'] ;
$CouponMaxDiscount = null ;
switch ($CouponType){
    case 'CART_DISC_MON' :
        $CouponMaxDiscount = "0" ;
        break ;
    case 'CART_DISC_PERC' :
        $CouponMaxDiscount = $_POST['__coupon_max_disc_amt'] ;

        break ;
}


$CouponValidItems = $_POST['__coupon_items'] ;
$CouponValidUsers = $_POST['__coupon_valid_user'] ;
$CouponMaxUses = $_POST['__coupon_max_uses'] ;
$CouponValue = $_POST['__coupon_value'] ;


$DBConnectionBackend = YOLOSqlConnect() ;
$Query = "INSERT INTO `coupon_coupons_discount_table` VALUES ('', '$CouponName', '$CouponDescription', '$CouponLongNotificationMsg',
 '$CouponShortNotificationMsg', '$CouponActive', '$CouponType', '$CouponCreationTimestamp', '$CouponExpiryTimestamp',
  '$CouponMinBill', '$CouponMaxDiscount', '$CouponValidItems', '$CouponValidUsers', '$CouponMaxUses',  '$CouponValue' )" ;

$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
if($QueryResult){
    echo "Successfully inserted values into the table ";
    echo "
        <div >
            <a href='all-coupons.php'>
                Show All Coupons
            </a>
        </div> 
        
        " ;

} else {
    echo "Problem in inserting values to the coupon_coupons_discount_table <br>".mysqli_error($DBConnectionBackend) ;
}






?>
