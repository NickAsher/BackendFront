<?php
session_start() ;
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once 'receipt_parser.php' ;

$DBConnection = YOPDOSqlConnect() ;


$Date = date('Y-m-d') ;
//$Date = '2017-6-27' ;

$Query = "SELECT * FROM `order_table` WHERE `order_date` = '$Date' AND `order_status` = 'Pending' AND `order_no` > '".$_SESSION['printed_order_no']."' ORDER BY `order_no` ASC"  ;
//$Query = "SELECT * FROM `order_table` WHERE `order_date` = '$Date' AND `order_status` = 'Pending'  ORDER BY `order_no` ASC"  ;

$QueryResult = $DBConnection->query($Query) ;

$OrderArray = $QueryResult->fetchAll() ;



?>
<html>
<head>

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

    <script type="text/javascript"   src="../../../lib/jquery/jquery.js" ></script>
    <script type="text/javascript"   src="../../../lib/jquery/jquery.print.js" ></script>
    <meta http-equiv="refresh" content="10">
</head>
<body>
<div id="hiddendiv">
    <div id="insidediv"></div>
</div>

<script type="text/javascript">
    $('#hiddendiv').hide() ;

</script>

        <?php
        $LastOrderId = null ;
        if(count($OrderArray)>0) {


            foreach ($OrderArray as $Record) {
                $OrderInfo = $Record ;

                $OrderNo = $Record['order_no'];
                $LastOrderId = $OrderNo;
                $OrderInfo['cart_json'] = parseReceipt_Cart($DBConnection, json_decode($Record['cart'], true)) ;
                unset($OrderInfo['cart']) ;
                $OrderInfo['tax_json'] = json_decode($Record['tax_json']) ;
                $OrderInfo['customer_info'] = parseReceipt_User($DBConnection, $OrderInfo['user_id']) ;
                $OrderInfo = json_encode($OrderInfo) ;

                ?>

                <script type="text/javascript">


                    var OrderInfo = '<?php echo "$OrderInfo" ?> ' ;


                    var printdata;
                    $.ajax({
                        url: 'receipt2.php',
                        method: 'POST',
                        data: {'__order_info':OrderInfo},

                        success: function (resp) {
                            printdata = $(resp).find('#inner-box').html();
//                printdata = resp ;
                            console.log("Success is acheived: " + printdata);


                            $('#insidediv').html(printdata);

                            $('#insidediv').print({
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







                </script>

                <?php

            }
            $_SESSION['printed_order_no'] = intval($LastOrderId);
            echo "<h1> Orders Printed upto ".$LastOrderId."</h1><br><br>" ;
        } else {
            echo "<h1> Orders Printed upto ".$_SESSION['printed_order_no']."</h1><br><br>" ;
        }

        ?>





</body>
</html>





