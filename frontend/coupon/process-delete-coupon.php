<?php

require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$CouponType = isSecure_checkPostInput('__coupon_type') ;
$CouponId = isSecure_checkPostInput('__coupon_id') ;

$CouponType = "$CouponType" ;

echo $CouponType."<br> CART_DISC_MON <br>" ;

$DBConnectionBackend = YOLOSqlConnect() ;

//echo strcmp($CouponType, "CART_DISC_MON") ;


if(strcmp($CouponType, "CART_DISC_PERC") == 0 || strcmp($CouponType, "CART_DISC_MON") == 0){

    $Query = "DELETE FROM `coupon_coupons_discount_table` WHERE `id` = '$CouponId'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if($QueryResult){
        echo "Succesfully deleted the item " ;
    } else {
        echo "unable to delete the Coupon entry  <br> ".mysqli_error($DBConnectionBackend) ;
    }


} else if ($CouponType == 'PROD_DISC_PERC' || $CouponType == 'PROD_DISC_MON'){

} else {
    echo "Unknown coupon type" ;
}




?>

<div >
    <a href='all-coupons.php'>
        Show All Coupons
    </a>
</div>