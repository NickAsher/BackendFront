<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'utils-apply-coupon.php' ;

$couponCode = isSecure_checkPostInput('__coupon_code') ;
$orderId = isSecure_checkPostInput('__order_id') ;
$DBConnectionBackend = YOLOSqlConnect() ;
$DBConnectionClient = YOLOSqlClientConnect() ;
$DBConnectionEmbedded = YOLOSqlEmbeddedConnect() ;


$Query = "SELECT * FROM `current_order_table` WHERE `order_id` = '$orderId' " ;
$QueryResult = mysqli_query($DBConnectionEmbedded, $Query) ;

$CartPrice = '' ;
if($QueryResult){
    foreach($QueryResult as $Record) {
        $CartPrice = $Record['order_total'] ;
    }
    $ReturnObject = applyCoupon_CartDiscount($DBConnectionBackend, floatval($CartPrice), $couponCode) ;
    echo json_encode($ReturnObject) ;



} else{
    $ErrorMessage = "Problem in retreiving the Order information <br> ".mysqli_error($DBConnectionEmbedded) ;
    $Error_AfterCouponObject = new CouponResult() ;
    $Error_AfterCouponObject->setStatus(false) ;
    $Error_AfterCouponObject->setNotificationMessage($ErrorMessage) ;

    echo json_encode($Error_AfterCouponObject) ;
}









