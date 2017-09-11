<?php
$RestaurantInfo = array() ;
$OrderInfo = array() ;

$RestaurantInfo['rest_name']  = 'RestaurantName' ;
$RestaurantInfo['rest_addr_1']  = 'Next Step Webs, Inc.' ;
$RestaurantInfo['rest_addr_2']  = '12345 Sunny Road' ;
$RestaurantInfo['rest_addr_3']  = 'Sunnyville, TX 12345 ' ;
$RestaurantInfo['rest_image']  = '../../../images/restaurant_logo.png' ;




$OrderInfo['order_num'] = '123' ;
$OrderInfo['order_date'] = 'January 1, 2015' ;
$OrderInfo['order_time'] = '7:00 PM' ;

$OrderInfo['customer_name'] = "Rafique Gagneja" ;
$OrderInfo['customer_num'] = "9780673002" ;
$OrderInfo['customer_email'] = "john@gmail.com" ;

$OrderInfo['cart'] = array(
    array(
        'item_qt'=>'1',
        'item_name'=>'XL Reg Dbl Cheese Marg.',
        'item_price'=>'350'
    ),
    array(
        'item_qt'=>'1',
        'item_name'=>'S Reg Cheese Marg.',
        'item_price'=>'150'
    ),
    array(
        'item_qt'=>'3',
        'item_name'=>'Coke',
        'item_price'=>'105'
    ),
    array(
        'item_qt'=>'2',
        'item_name'=>'Reg Burger',
        'item_price'=>'200'
    )
) ;


$OrderInfo['net_price'] = '805' ;
$OrderInfo['coupon_discount'] = '105' ;
$OrderInfo['net_price_after_coupn'] = '700' ;
$OrderInfo['tax'] = array(
    array(
        'tax_name'=>'Service Tax',
        'tax_percentage'=>'6',
        'tax_value'=>'25'
    ),
    array(
        'tax_name'=>'VAT',
        'tax_percentage'=>'12',
        'tax_value'=>'50'
    )
) ;
$OrderInfo['order_total'] = '775.145' ;


$OrderInfo = json_encode($OrderInfo) ;
$RestaurantInfo = json_encode($RestaurantInfo) ;



?>


<html>
<head>
    <title>Some yolo </title>
    <link rel='stylesheet' href='../../../lib/bootstrap4/bootstrap-reboot.min.css' type="text/css" media='all'>
    <link rel='stylesheet' href='../../../lib/bootstrap4/bootstrap.min.css' type="text/css" media='all'>
    <link rel='stylesheet' href='../../../lib/bootstrap4/bootstrap-grid.min.css' type="text/css" media='all'>

    <style media='all'>
        .invoice-box{
            max-width:800px;
            margin:auto;
            padding:30px;
            border:1px solid #eee;
            box-shadow:0 0 10px rgba(0, 0, 0, .15);
            font-size:16px;
            line-height:24px;
            font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color:#555;
        }

        .left{
            text-align: left;  }
        .center{
            text-align: center;  }
        .right{
            text-align: right;  }



        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td{
                width:100%;
                display:block;
                text-align:center;
            }


        }
    </style>
</head>
<body>
<!--    <iframe src="receipt_23.php" name="frame"></iframe>-->
<!--    <input type="button" onclick="frames['frame'].print()" value="printletter">-->

    <button id="somebtn">Click this to Add things to below div</button>
    <div id="outerdiv">
        <div id="getcontentdiv"></div>
    </div>
</body>
<script type="text/javascript"   src="../../../lib/jquery/jquery.js" ></script>
<script type="text/javascript"   src="../../../lib/jquery/jquery.print.js" ></script>
<script type="text/javascript">



    $('#outerdiv').hide() ;




    $('#somebtn').click(function () {

        var RestaurantInfo = '<?php echo "$RestaurantInfo" ?> ' ;
        var OrderInfo = '<?php echo "$OrderInfo" ?> ' ;


        var printdata;
        $.ajax({
            url: 'receipt2.php',
            method: 'POST',
            data: {'__restaurant_info':RestaurantInfo, '__order_info':OrderInfo},

            success: function (resp) {
                printdata = $(resp).find('#inner-box').html();
//                printdata = resp ;
                console.log("Success is acheived: " + printdata);


                $('#getcontentdiv').html(printdata);

                $('#getcontentdiv').print({
                    globalStyles: true,
                    mediaPrint: false,
                    stylesheet: null,
                    noPrintSelector: ".no-print",
                    iframe: true,
                    append: null,
                    prepend: null,
                    manuallyCopyFormValues: true,
                    deferred: $.Deferred(),
                    timeout: 750,
                    title: null,
                    doctype: '<!doctype html>'
                });

            },
            error: function(xhr, status, msg){
                alert("msg") ;
            }
        });

    });
//        $("<iframe>")                             // create a new iframe element
//            .hide()                               // make it invisible
//            .attr("src", "/url/to/page/to/print") // point the iframe to the page you want to print
//            .appendTo("body");    }) ;

</script>
</html>