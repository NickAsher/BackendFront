
var coupon_discount_Percentage = {
    id : 'id',
    name : 1,
    description : '',
    active : 'whether the coupon is on or not, it will be a boolean, default is true' ,
    type : '',
    end_date_timestamp : '',
    min_bill_amt: '',
    max_discount_amt : '',
    items : 'Items on on which the coupon is applicable, default is all',
    valid_user : 'Users for which the coupon is applicable like new user/all users, default is all users',
    made_on_timestamp : 'The day when the coupon was made',

    value_or_percentage : '',

}

var coupon_discount_Money = {
    id : 'id',
    name : 1,
    description : '',
    active : 'whether the coupon is on or not, it will be a boolean, default is true' ,
    type : '',
    start_date : '',
    end_date : '',
    min_bill: '',
    max_discount_amt : '',
    items : 'Items on on which the coupon is applicable, default is all',
    valid_user : 'Users for which the coupon is applicable like new user/all users, default is all users',
    money : '',
}


var coupon_free_MenuItem = {
    id : 'id',
    name : 1,
    description : '',
    active : 'whether the coupon is on or not, it will be a boolean, default is true' ,
    type : '',
    start_date : '',
    end_date : '',
    min_bill: '',
    // max_discount_amt : '',
    items : 'Items on on which the coupon is applicable, default is all',
    valid_user : 'Users for which the coupon is applicable like new user/all users, default is all users',
    menu_item_id : '',
}


// some notes about the coupons
/*
 * You can either make a coupon active or passive
 *
 *
 *
 * Future things
 * Store a list of all deleted coupons so that if a user uses an expired coupon, they will get a message that coupon is no longer valid
 *
 */