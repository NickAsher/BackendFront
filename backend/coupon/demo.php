<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'utils-apply-coupon.php' ;

$DBConnectionbackend = YOLOSqlConnect() ;

$CouponApplyResult = applyCoupon_CartDiscount($DBConnectionbackend, 650, "DISC100") ;
echo json_encode($CouponApplyResult) ;


?>