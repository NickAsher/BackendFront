<html>
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

    <?php     require_once '../../utils/constants.php'; ?>



</head>
<body>

<div><?php require_once "includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12" style="background-color: #fcfcfc" >


                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>



                <form action="process-add-coupon-cart.php" method="post">
                    <div class="row">
                        <div class="col-md-12" >
                            <center>


                                <div class="card w-75">
                                    <div class="card-header">
                                        <h3 class="ytext-heading text-left">General Information</h3>
                                    </div>
                                    <div class="card-block">
                                        <div class="form-group row">
                                            <label for="input-cpn-name" class="col-3 col-form-label">Coupon Name</label>
                                            <div class="col-9">
                                                <input name = '__coupon_name' id="input-cpn-name" class="form-control" type="text" placeholder="Name of the Coupon ex : BOGO50" >
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="input-cpn-description" class="col-3 col-form-label">Coupon Description</label>
                                            <div class="col-9">
                                                <input name = '__coupon_description' id="input-cpn-description" class="form-control" type="text" placeholder="Description for the Coupon" >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="input-cpn-notf-msg-long" class="col-3 col-form-label">Coupon Success Notification Message(Long)</label>
                                            <div class="col-9">
                                                <input name = '__coupon_notf_msg_long' id="input-cpn-notf-msg-long" class="form-control" type="text" placeholder="Hurray, you discount has been applied" >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="input-cpn-notf-msg-short" class="col-3 col-form-label">Coupon Success Notification Message(Short)</label>
                                            <div class="col-9">
                                                <input name = '__coupon_notf_msg_short' id="input-cpn-notf-msg-short" class="form-control" type="text" placeholder="20 off" >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="input-cpn-description" class="col-3 col-form-label">Coupon Type</label>
                                            <div class="col-9">
                                                <select name = "__coupon_type" class="form-control" id="input-item-category" onchange="handleCouponTypeDiv()" >
                                                    <option selected disabled>Choose an Coupon Category</option>
                                                    <option value="CART_DISC_PERC">Cart Discount Percentage</option>
                                                    <option value="CART_DISC_MON">Cart Discount Money</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="input-cpn-amount" class="col-3 col-form-label">Amount</label>
                                            <div class="col-9">
                                                <input name = '__coupon_value' id="input-cpn-amount" class="form-control" type="text" placeholder="value of the coupon" >
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
                                            <label for="input-cpn-expiry" class="col-3 col-form-label">Expiry Time</label>
                                            <div class="col-9 input-group">
                                                <input name = '__coupon_expiry' id="input-cpn-expiry" class="form-control" type="text" placeholder="Message of the Notification" >
                                                <button id="btn-input-choose-expiry-time" class="input-group-addon">Choose</button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="input-cpn-min-bill" class="col-3 col-form-label">Min Bill Amount</label>
                                            <div class="col-9">
                                                <input name = '__coupon_min_bill' id="input-cpn-min-bill" class="form-control" type="text" placeholder="Min cart value for the discount to be applicable" >
                                            </div>
                                        </div>

                                        <div id="Div_MaxDiscount" class="form-group row">
                                            <label for="input-cpn-min-bill" class="col-3 col-form-label">Max Discount Amount</label>
                                            <div class="col-9">
                                                <input name = '__coupon_max_disc_amt' id="input-cpn-min-bill" class="form-control" type="text" placeholder="Min cart value for the discount to be applicable" >
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
                                            <div class="col-9">
                                                <input name = '__coupon_items' id="input-cpn-valid-items" class="form-control" type="text" placeholder="Items for which the coupon is valid" >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="input-cpn-valid-users" class="col-3 col-form-label">User Validity</label>
                                            <div class="col-9">
                                                <div id="input-cpn-valid-users" class="form-check">
                                                    <label class="form-check-label">
                                                        <input name = '__coupon_valid_user'  class="form-check-inline" type="radio" value="NEW_USERS">New Users
                                                    </label>
                                                    <label class="form-check-label">
                                                        <input name = '__coupon_valid_user'  class="form-check-inline" type="radio" value="ALL_USERS">All Users
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="input-cpn-max-uses" class="col-3 col-form-label">Uses per Coupon</label>
                                            <div class="col-9">
                                                <input name = '__coupon_max_uses' id="input-cpn-max-uses" class="form-control" type="number" placeholder="No. of times the coupon can be used" >

                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <br><br>


                                <div class="form-group row">
                                    <div class="col-4" ></div>
                                    <input type="submit" class=" col-4 btn btn-outline-info" value="Add Coupon">
                                    <div class="col-4" ></div>
                                </div>



                            </center>
                        </div>
                    </div>
                </form>




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

    function handleCouponTypeDiv(){
        var CouponType = $('#input-item-category').val() ;

        switch(CouponType){
            case 'CART_DISC_PERC' :
                $('#Div_MaxDiscount').show() ;
                break ;

            case 'CART_DISC_MON' :
                $('#Div_MaxDiscount').hide() ;
                break ;

            default :
                $('#Div_MaxDiscount').show() ;
                break ;
        }
    } handleCouponTypeDiv() ;






</script>

</html>