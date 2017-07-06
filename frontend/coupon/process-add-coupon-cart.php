<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CouponName = isSecure_IsValidText(GetPostConst::Post, '__coupon_name') ;
$CouponDescription = isSecure_IsValidText(GetPostConst::Post, '__coupon_description') ;
$CouponLongNotificationMsg = isSecure_IsValidText(GetPostConst::Post, '__coupon_notf_msg_long') ;
$CouponShortNotificationMsg = isSecure_IsValidText(GetPostConst::Post, '__coupon_notf_msg_short') ;
$CouponActive = '1' ;
$CouponType = isSecure_IsValidText(GetPostConst::Post, '__coupon_type') ;



$CouponCreationTimestamp = date('Y-m-d H:i:s') ;
$CouponExpiryTimestamp = isSecure_IsValidText(GetPostConst::Post, '__coupon_expiry') ;
$CouponMinBill = isSecure_IsValidPositiveDecimal(GetPostConst::Post, '__coupon_min_bill') ;


$CouponMaxDiscount = null ;
switch ($CouponType){
    case 'CART_DISC_MON' :
        $CouponMaxDiscount = "0" ;
        break ;
    case 'CART_DISC_PERC' :
        $CouponMaxDiscount = isSecure_IsValidPositiveDecimal(GetPostConst::Post, '__coupon_max_disc_amt') ;
        break ;
}


$CouponValidItems = isSecure_IsValidText(GetPostConst::Post, '__coupon_items');
$CouponValidUsers = isSecure_IsValidText(GetPostConst::Post, '__coupon_valid_user') ;
$CouponMaxUses = isSecure_isValidPositiveInteger(GetPostConst::Post, '__coupon_max_uses') ;
$CouponValue = isSecure_IsValidPositiveDecimal(GetPostConst::Post, '__coupon_value') ;
$CouponValueText = "Abc" ;



$DBConnectionBackend = YOPDOSqlConnect() ;

$Query = "INSERT INTO `coupon_coupons_discount_table` VALUES ('', :cpn_name, :cpn_desc, :cpn_lntf,
  :cpn_sntf, :cpn_actv, :cpn_type, :cpn_crt_date, :cpn_exp_date,
  :cpn_min_bill, :cpn_max_disc, :cpn_val_item, :cpn_val_user, :cpn_max_uses,  :cpn_val, :cpn_val_text )" ;

try {
    $QueryResult = $DBConnectionBackend->prepare($Query);
    $QueryResult->execute([
        'cpn_name' => $CouponName,
        'cpn_desc' => $CouponDescription,
        'cpn_lntf' => $CouponLongNotificationMsg,
        'cpn_sntf' => $CouponShortNotificationMsg,
        'cpn_actv' => $CouponActive,
        'cpn_type' => $CouponType,
        'cpn_crt_date' => $CouponCreationTimestamp,
        'cpn_exp_date' => $CouponExpiryTimestamp,
        'cpn_min_bill' => $CouponMinBill,
        'cpn_max_disc' => $CouponMaxDiscount,
        'cpn_val_item' => $CouponValidItems,
        'cpn_val_user' => $CouponValidUsers,
        'cpn_max_uses' => $CouponMaxUses,
        'cpn_val' => $CouponValue,
        'cpn_val_text' => $CouponValueText

    ]);


    echo "Successfully inserted values into the table 
        <div >
            <a href='all-coupons.php'>
                Show All Coupons
            </a>
        </div> 
        " ;

} catch (Exception $e) {
    echo "Problem in inserting values to the coupon_coupons_discount_table <br>".$e ;

}






?>
