/**
 * Created by root on 26/3/17.
 */
var after_coupon_applied_object = {
    success: true,
    coupon_code: 'OLO20',
    discount_amount: '88',
    notification_message: "Successfully applied DISC100, 20% discount applied on your order, max 100rs ",
    small_message: "20% off",
    original_order_amt: '440',
    final_order_amt: '354',
    error: null
}






var dominos_OLO20_object = {
    /*
     * Request URL:https://pizzaonline.dominos.co.in/redeem/coupon
     * Request Method:POST
     *
     * FORM DATA
     *      coupon_code:OLO20
     *
     *
     *
     */

    status: true,

    msg: ["Hurrah!!! enjoy your pizza."],

    data: {
        cart_amt_details: {
            net_price: "352.00",
            service_tax: "21.12",
            vat: "50.34",
            tax_price: "71.46",
            total_price: "423.00"
        },

        count: 1,

        coupon_info: {
            applied_coupon_line_id: "118196046",
            coupon_code: "OLO20",
            coupon_details: "[OLO20] 20% off!",
            discount_price: "88.00",
            product_level_coupon_line_id: "118196046",
        },

        html : "< some html for the cart item>"


    }

} ;

var dominos_OLO20_Remove = {
    /*
     * Request URL: https://pizzaonline.dominos.co.in/reverse/coupon
     * Request Method:POST
     */

    status : true,

    msg : "Coupon successfully removed.",

    data : {
        cart_amt_details: {
            net_price: "440.00",
            service_tax: "26.40",
            vat: "62.92",
            tax_price: "89.32",
            total_price: "529.00"
        },

        count: 1,

        coupon_info: { // all 5 fields are empty
            applied_coupon_line_id: "",
            coupon_code: "",
            coupon_details: "",
            discount_price: "",
            product_level_coupon_line_id: "",
        },

        html : "<html for the cart item>"

    }



}


var dominos_OLO20_Error = {
    status : false ,

    msg : "This coupon is not applicable today",

    data : {
        cart_amt_details : {}

    }
}



var myCoupon = {

    status : true,

    notf_msg : "hurray, successfully applied the coupon",

    data : {
        cart_details : {
            original_price : 120,
            coupon_discount : 20,
            new_price : 100,
            vat : 20,
            service_tax : 30,
            total_amount : 150
        },

        coupon_details : {
            coupon_code : 'DISC20',
            coupon_msg : '[DISC20] 20/- off '
        }
    }
}