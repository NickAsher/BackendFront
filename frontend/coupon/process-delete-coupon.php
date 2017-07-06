<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CouponType = isSecure_IsValidText(GetPostConst::Post, '__coupon_type') ;
$CouponId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__coupon_id') ;


$DBConnectionBackend = YOPDOSqlConnect() ;




    $Query = "DELETE FROM `coupon_coupons_discount_table` WHERE `id` = :cpn_id " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute(['cpn_id' => $CouponId]);


        echo "Successfully deleted values from the table 
        <div >
            <a href='all-coupons.php'>
                Show All Coupons
            </a>
        </div> 
        " ;
    } catch (Exception $e) {
        die("unable to delete the Coupon entry: " .$e) ;
    }




?>
