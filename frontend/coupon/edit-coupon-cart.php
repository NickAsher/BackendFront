0<html>
<head>
    <title>SendToken | Single</title>

    <link rel="stylesheet" href="../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-reboot.min.css" >

    <link rel="stylesheet" href="../../lib/jquery_ui/jquery-ui.css">
    <link rel="stylesheet" href="../../lib/jquery_ui/jquery-ui.structure.css">
    <link rel="stylesheet" href="../../lib/jquery_ui/jquery-ui.theme.css">

    <link rel="stylesheet" href="../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../common/css/classes.css">

    <?php
    require_once '../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php'  ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


    $DBConnectionBackend = YOLOSqlConnect() ;
    $CouponId = isSecure_checkPostInput('__coupon_id') ;
    $Query = "SELECT * FROM `coupon_coupons_discount_table` WHERE `id` = '$CouponId'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    $Temp = '' ;
    if($QueryResult) {
        foreach ($QueryResult as $Record) {
            $Temp = $Record;
        }

    } else{
        die("Problem in getting the blogpost from blogs_table <br> ".mysqli_error($DBConnectionBackend)) ;

    }



    $CouponId = $Temp['id'];
    $CouponName = $Temp['name'] ;
    $CouponDescription = $Temp['description'] ;
    $CouponLongNotificatopnMsg = $Temp['long_notf_msg'] ;
    $CouponShortNotificatopnMsg = $Temp['short_notf_msg'] ;
    $CouponActive = $Temp['active'] ;
    $CouponType = 'Cart Discount Percent' ;
    $CouponCreationTimestamp = $Temp['creation_timestamp'] ;
    $CouponExpiryTimestamp = $Temp['expiry_timestamp'] ;
    $CouponMinBill = $Temp['min_bill_amt'] ;
    $CouponMaxDiscount = $Temp['max_discount_amt'] ;
    $CouponValidItems = $Temp['valid_items'] ;
    $CouponValidUsers = $Temp['valid_user'] ;
    $CouponMaxUses = $Temp['max_uses'] ;
    $CouponValue = $Temp['value'] ;
    $CouponValidUsers_Formatted = '' ;



    switch ($CouponValidUsers){
        case 'NEW_USERS' :
            $CouponValidUsers_Formatted = "New Users" ;
            break ;
        case 'ALL_USERS' :
            $CouponValidUsers_Formatted = "All Users" ;
            break ;
    }
















    ?>



</head>
<body>

<div><?php require_once "includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12 bg-grey" >


                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>



                <div class="row">
                    <div class="col-md-12" >
                        <center><form action="process-edit-coupon.php" method="post">


                            <div class="card w-75">
                                <div class="card-header">
                                    <h3 class="ytext-heading text-left">General Information</h3>
                                </div>
                                <div class="card-block">

                                    <input name='__coupon_id' type="hidden" value="<?php echo $CouponId ; ?>">

                                    <div class="form-group row">
                                        <label for="input-cpn-name" class="col-3 col-form-label">Coupon Name</label>
                                        <div class="col-md-9">
                                            <input name = '__coupon_name' id="input-cpn-name" class="form-control" type="text" value="<?php echo $CouponName ; ?>" >
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="input-cpn-description" class="col-3 col-form-label">Coupon Description</label>
                                        <div class="col-md-9">
                                            <input name = '__coupon_description' id="input-cpn-description" class="form-control" value="<?php echo $CouponDescription ; ?>" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="input-cpn-description" class="col-3 col-form-label">Coupon Long Notification Message</label>
                                        <div class="col-md-9">
                                            <input name = '__coupon_notf_msg_long' id="input-cpn-description" class="form-control" value="<?php echo $CouponLongNotificatopnMsg ; ?>" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="input-cpn-description" class="col-3 col-form-label">Coupon Short Notification Message</label>
                                        <div class="col-md-9">
                                            <input name = '__coupon_notf_msg_short' id="input-cpn-description" class="form-control" value="<?php echo $CouponShortNotificatopnMsg ; ?>" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="input-cpn-type" class="col-3 col-form-label">Coupon Type</label>
                                        <div class="col-md-9">
                                            <input name='__coupon_type' id="input-cpn-type" class="form-control" value="<?php echo $CouponType ; ?>" readonly >
                                        </div>
                                    </div>

                                </div>
                            </div>




                            <br><br>
                            <div class="card w-75">
                                <div class="card-header">
                                    <h3 class="ytext-heading text-left">Usage Restriction</h3>
                                </div>
                                <div class="card-block">
                                    <div class="form-group row">
                                        <label for="input-cpn-amount" class="col-3 col-form-label">Amount</label>
                                        <div class="col-md-9">
                                            <input name = '__coupon_value' id="input-cpn-amount" class="form-control" value="<?php echo $CouponValue ; ?>" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="input-cpn-expiry" class="col-3 col-form-label">Expiry Time</label>
                                        <div class="col-md-9 input-group">
                                            <input name = '__coupon_expiry' id="input-cpn-expiry" class="form-control" value="<?php echo $CouponExpiryTimestamp ; ?>" >
                                            <button id="btn-input-choose-expiry-time" class="input-group-addon">Choose</button>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="input-cpn-min-bill" class="col-3 col-form-label">Min Bill Amount</label>
                                        <div class="col-md-9">
                                            <input name = '__coupon_min_bill' id="input-cpn-min-bill" class="form-control" value="<?php echo $CouponMinBill ; ?>" >
                                        </div>
                                    </div>

                                </div>
                            </div>



                            <br><br>
                            <div class="card w-75">
                                <div class="card-header align-content-start">
                                    <h3 class="ytext-heading text-left">Usage Limits</h3>
                                </div>
                                <div class="card-block">
                                    <div class="form-group row">
                                        <label for="input-cpn-valid-items" class="col-3 col-form-label">Valid Items</label>
                                        <div class="col-md-9">
                                            <input name = '__coupon_items' id="input-cpn-valid-items" class="form-control" value="<?php echo $CouponValidItems ; ?>" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="input-cpn-valid-users" class="col-3 col-form-label">User Validity</label>
                                        <div class="col-md-9">
                                            <input name = '__coupon_valid_user' id="input-cpn-valid-users" class="form-control" value="<?php echo $CouponValidUsers_Formatted ; ?>" readonly >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="input-cpn-no-uses" class="col-3 col-form-label">Uses per Coupon</label>
                                        <div class="col-md-9">
                                            <input name = '__coupon_max_uses' id="input-cpn-no-uses" class="form-control" value="<?php echo $CouponMaxUses ; ?>" >

                                        </div>
                                    </div>


                                </div>
                            </div>


                            <br><br>
                            <div class="form-group row">
                                <div class="col-4" ></div>
                                <input type="submit" class=" col-4 btn btn-outline-info" value="Save Coupon" >
                                <div class="col-4" ></div>
                            </div>



                        </form></center>
                    </div>
                </div>




                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>



            </div>
        </div>
    </div>
</section>



<div><?php require_once "../common/includes/footer.php" ?></div>
</body>
<script type="text/javascript" src="../../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../../lib/jquery_ui/jquery-ui.js" ></script>
<script type="text/javascript" src="../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../lib/t3/t3.js"></script>

<script type="text/javascript">

    $("#input-cpn-expiry").datepicker({
        dateFormat: 'yy-mm-dd',

        onSelect: function(dateText) {
            console.log("Date 1 is " + dateText) ;

        }
    });
    $("#btn-input-choose-expiry-time").click(function(event) {
        event.preventDefault() ;
        $("#input-cpn-expiry").datepicker( "show" );

    });



</script>

</html>