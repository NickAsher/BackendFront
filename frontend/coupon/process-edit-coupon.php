<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$DBConnectionBackend = YOPDOSqlConnect() ;



$CouponId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__coupon_id') ;
$CouponName = isSecure_IsValidText(GetPostConst::Post, '__coupon_name') ;
$CouponDescription = isSecure_IsValidText(GetPostConst::Post, '__coupon_description') ;
$CouponLongNotificationMsg = isSecure_IsValidText(GetPostConst::Post, '__coupon_notf_msg_long') ;
$CouponShortNotificationMsg = isSecure_IsValidText(GetPostConst::Post, '__coupon_notf_msg_short') ;
$CouponActive = '1' ;
$CouponType = isSecure_IsValidText(GetPostConst::Post, '__coupon_type') ;

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



$Query = "UPDATE `coupon_coupons_discount_table`
          SET `name` = :cpn_name, `description` = :cpn_desc, `long_notf_msg` = :cpn_lntf,
          `short_notf_msg` = :cpn_sntf, `active` = :cpn_actv, `expiry_timestamp` = :cpn_exp_date,
          `min_bill_amt` = :cpn_min_bill, `max_discount_amt` = :cpn_max_disc, `valid_items` = :cpn_val_item,
          `valid_user` = :cpn_val_user, `max_uses` = :cpn_max_uses, `value` = :cpn_val, `value_text` = :cpn_val_text
           WHERE `id` = :cpn_id " ;




try {
    $QueryResult = $DBConnectionBackend->prepare($Query);
    $QueryResult->execute([
        'cpn_name' => $CouponName,
        'cpn_desc' => $CouponDescription,
        'cpn_lntf' => $CouponLongNotificationMsg,
        'cpn_sntf' => $CouponShortNotificationMsg,
        'cpn_actv' => $CouponActive,
//        'cpn_type' => $CouponType,
//        'cpn_crt_date' => $CouponCreationTimestamp,
        'cpn_exp_date' => $CouponExpiryTimestamp,
        'cpn_min_bill' => $CouponMinBill,
        'cpn_max_disc' => $CouponMaxDiscount,
        'cpn_val_item' => $CouponValidItems,
        'cpn_val_user' => $CouponValidUsers,
        'cpn_max_uses' => $CouponMaxUses,
        'cpn_val' => $CouponValue,
        'cpn_val_text' => $CouponValueText,
        'cpn_id'=>$CouponId

    ]);


    echo "Successfully Updated values into the table 
        <div >
            <a href='all-coupons.php'>
                Show All Coupons
            </a>
        </div> 
        " ;

} catch (Exception $e) {
    echo "Problem in updating values in the coupon_coupons_discount_table <br>".$e ;

}









?>
