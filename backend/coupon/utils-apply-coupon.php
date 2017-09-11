<?php


class CouponResult implements JsonSerializable {
    private $Status ;
    private $NotificationMessage ;
    private $Data ;

    private $CartDetails ;
    private $CouponDetails ;

    function __construct() {
        $this->CartDetails = new stdClass() ;
        $this->CouponDetails = new stdClass() ;

    }


    function setStatus($Status){
        $this->Status = $Status ;
    }

    function setNotificationMessage($msg){
        $this->NotificationMessage = $msg ;
    }

    function setData_CartDetails($OriginalOrderAmount, $CouponDiscount){
        $NewOrderAmount = $OriginalOrderAmount - $CouponDiscount ;

        $this->CartDetails->OrigianlOrderAmount = $OriginalOrderAmount ;
        $this->CartDetails->CouponDiscount = $CouponDiscount ;
        $this->CartDetails->NewOrderAmount = $NewOrderAmount ;
        $this->CartDetails->NewVat = $NewOrderAmount * 0.1 ;
        $this->CartDetails->NewServiceTax= $NewOrderAmount * 0.15 ;
        $this->CartDetails->NewTotalOrderAmount = $NewOrderAmount + $this->CartDetails->NewVat + $this->CartDetails->NewServiceTax ;

    }

    function setData_CouponDetails($CouponCode, $ShortMessage){
        $this->CouponDetails->CouponCode = $CouponCode ;
        $this->CouponDetails->ShortMessage = $ShortMessage ;

    }

    function jsonSerialize() {
        if($this->Status == false) {
            return[
                'status'=>false,
                'notf_msg'=>$this->NotificationMessage
            ] ;
        } else {
            return[
                'status'=>true,
                'notf_msg'=>$this->NotificationMessage,
                'data'=> array(
                    'cart_details'=>array(
                        'original_order_amt'=>$this->CartDetails->OrigianlOrderAmount,
                        'coupon_discount'=>$this->CartDetails->CouponDiscount,
                        'new_price'=>$this->CartDetails->NewOrderAmount,
                        'new_vat'=>$this->CartDetails->NewVat,
                        'new_service_tax'=>$this->CartDetails->NewServiceTax,
                        'new_order_amt'=>$this->CartDetails->NewTotalOrderAmount,
                    ),
                    'coupon_details'=>array(
                        'coupon_code'=>$this->CouponDetails->CouponCode,
                        'coupon_msg'=>$this->CouponDetails->ShortMessage
                    )
                )
            ] ;
        }

    }

}



function isCouponActive($CouponArrayObject){
    if($CouponArrayObject['active'] == 1) {
        return true ;
    } else {
        return false ;
    }
}




function getCouponErrorMessage($CouponArrayObject){
    return 'This coupon is expired' ;
}

function isCouponExpired($CouponArrayObject){
    $CurrentTimestamp = date('Y-m-d H:i:s') ;
    $ExpiryTimestamp = $CouponArrayObject['expiry_timestamp'] ;

    if( strtotime($CurrentTimestamp) < strtotime($ExpiryTimestamp) ){
        return false ;
    } else {
        return true ;
    }
}



function isOrderPasses_MinBillAmount($OrderAmount, $MinBillAmount){
    if($OrderAmount >= $MinBillAmount){
        return true;
    } else{
        return false ;
    }
}


/* **************************************** Cart Discount Functions ************************************************* */






function isCouponValid_CartDiscount($DBConnectionBackend, $CouponCode){
    /*
     * This function checks whether the coupon code is valid or not.
     * It does not check whether the coupon active or not.
     * If the coupon exists, it return the Coupon in Coupon array object
     */
    $Temp = null ;
    $Query = "SELECT * FROM `coupon_coupons_discount_table` WHERE `name` = '$CouponCode' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if($QueryResult){
        if(mysqli_num_rows($QueryResult) == 1){
//            echo "Coupon code exists <br> " ;
            foreach ($QueryResult as $Record){
                $Temp = $Record ;
            }
            return $Temp ;
        } else {
            //echo " coupon is invalid" ;
            return 0 ;
        }

    } else {
        echo "Problem in fetching the coupon <br>".mysqli_error($DBConnectionBackend) ;
        return -1 ;
    }
}
















function applyDiscount2_CartDiscountMoney($OrderAmount, $CouponArrayObject){
    $DiscountAmount = floatval($CouponArrayObject['value']) ;

    $AfterCouponObject = new CouponResult() ;
    $AfterCouponObject->setStatus(true) ;
    $AfterCouponObject->setNotificationMessage($CouponArrayObject['long_notf_msg']) ;
    $AfterCouponObject->setData_CartDetails($OrderAmount, $DiscountAmount) ;
    $AfterCouponObject->setData_CouponDetails($CouponArrayObject['name'], $CouponArrayObject['short_notf_msg']) ;
    return $AfterCouponObject ;
}




function applyDiscount2_CartDiscountPercentage($OrderAmount, $CouponArrayObject){
    $DiscountPercentage = floatval($CouponArrayObject['value']) ;

    $DiscountAmount = ($DiscountPercentage * $OrderAmount)/100 ;
    $MaxDiscountAllowed = floatval($CouponArrayObject['max_discount_amt']) ;
    /*
     * Check whether there is a limit on max discount that can be applied
     */
    if($MaxDiscountAllowed == 0){
        // this means unlimited discount
    } else {
        $DiscountAmount = min($DiscountAmount, $MaxDiscountAllowed) ;

    }


    $AfterCouponObject = new CouponResult() ;
    $AfterCouponObject->setStatus(true) ;
    $AfterCouponObject->setNotificationMessage($CouponArrayObject['long_notf_msg']) ;
    $AfterCouponObject->setData_CartDetails($OrderAmount, $DiscountAmount) ;
    $AfterCouponObject->setData_CouponDetails($CouponArrayObject['name'], $CouponArrayObject['short_notf_msg']) ;
    return $AfterCouponObject ;


}












function applyCoupon_CartDiscount($DBConnectionBackend, $OrderAmount, $CouponCode){
    $AfterCouponObject = new CouponResult() ;
    $CouponArrayObject = isCouponValid_CartDiscount($DBConnectionBackend, $CouponCode) ;

    if($CouponArrayObject == 0 || $CouponArrayObject == 1){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("Coupon code is not valid") ;
        return $AfterCouponObject;
    }

    if(isCouponActive($CouponArrayObject) == false){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("This coupon is expired") ;
        return $AfterCouponObject;
    }

    if(isOrderPasses_MinBillAmount($OrderAmount, $CouponArrayObject['min_bill_amt']) == false){
        $AfterCouponObject->setStatus(false) ;
        $AfterCouponObject->setNotificationMessage("Invalid Use : There should be a min bill of".$CouponArrayObject['min_bill_amt']) ;
        return $AfterCouponObject;

    }
    $CouponType = $CouponArrayObject['type'] ;

    switch ($CouponType){
        case 'CART_DISC_PERC' :
            $AfterCouponObject = applyDiscount2_CartDiscountPercentage($OrderAmount, $CouponArrayObject) ;
            break ;
        case 'CART_DISC_MON' :
            $AfterCouponObject = applyDiscount2_CartDiscountMoney($OrderAmount, $CouponArrayObject) ;
            break ;

    }

    return $AfterCouponObject ;
}




?>