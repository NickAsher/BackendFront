<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



$RestaurantInfo = isSecure_checkPostInput('__restaurant_info') ;
$OrderInfo = isSecure_checkPostInput('__order_info') ;


$RestaurantInfo = json_decode($RestaurantInfo, true) ;
$OrderInfo = json_decode($OrderInfo, true) ;


$Cart = $OrderInfo['cart'] ;
$Tax = $OrderInfo['tax'] ;







?>
<html>
<head>
    <meta charset='utf-8'>
    <title>A simple, clean, and responsive HTML invoice template</title>
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

<br><br>
<div  id="outer-box">
    <div class='invoice-box' id="inner-box">





    <table class='table'>
        <tr>
            <td style='border:none';>
                <img src='<?php echo $RestaurantInfo['rest_image']  ?>'  style='width:100%; max-width:150px;'>

            </td>

            <td style='border:none; text-align: right;'>
                <br>
                <?php echo $RestaurantInfo['rest_name']  ?><br>
                <?php echo $RestaurantInfo['rest_addr_1']  ?><br>
                <?php echo $RestaurantInfo['rest_addr_2']  ?><br>
                <?php echo $RestaurantInfo['rest_addr_3']  ?><br>
            </td>
        </tr>

        <tr>
            <td>
                Order No : <?php echo $OrderInfo['order_num'] ?><br>
                Date: <?php echo $OrderInfo['order_date'] ?><br>
                Time: <?php echo $OrderInfo['order_time'] ?>
            </td>

            <td style='text-align: right;'>
                <?php echo $OrderInfo['customer_name'] ?><br>
                <?php echo $OrderInfo['customer_num'] ?><br>
                <?php echo $OrderInfo['customer_email'] ?>
            </td>
        </tr>
    </table>
    <br>




    <!-- ******************************************************* -->

    <table class='table table-sm '>
        <tr>

            <th>Qty</th>
            <th>Description</th>
            <th class='right'>Price</th>
        </tr>

        <?php
        foreach ($Cart as $Record){
            $ItemQt = $Record['item_qt'] ;
            $ItemName = $Record['item_name'] ;
            $ItemPrice = $Record['item_price'] ;

            echo "
                <tr>
                    <td>$ItemQt</td>
                    <td>$ItemName</td>
                    <td class='right'>$ItemPrice</td>
                </tr>
            
            " ;
        }
        ?>



    </table>
    <br>




    <!-- ******************************************************* -->
    <div class='row' id="pricetable">
        <div class='col-6 col-sm-6 col-md-6'></div>
        <div class=' col-6 col-sm-6 col-md-6'>
            <table class='table table-sm borderless'>
                <tr>

                    <th >Net Price</th>
                    <th class='right'><?php echo $OrderInfo['net_price'] ?></th>

                </tr>

                <tr>
                    <th>Coupon Discount</th>
                    <th  class='right'><?php echo $OrderInfo['coupon_discount'] ?></th>
                </tr>

                <tr>
                    <th>Sub Total</th>
                    <th  class='right'><?php echo $OrderInfo['net_price_after_coupn'] ?></th>
                </tr>

                <?php
                foreach ($Tax as $Record){
                    $TaxName = $Record['tax_name'] ;
                    $TaxPercentage = $Record['tax_percentage'] ;
                    $TaxValue = $Record['tax_value'] ;

                    echo "
                        <tr>
                            <th>$TaxName ($TaxPercentage)</th>
                            <th class='right'>$TaxValue</th>
                        </tr>
                    " ;


                }
                ?>


                <tr>
                    <td colspan='2'></td>
                </tr>


                <tr>
                    <td><h5>Grand Total</h5></td>
                    <td  class='right'><h5><?php echo $OrderInfo['order_total'] ?></h5></td>
                </tr>



            </table>
        </div>

    </div>

    <!-- ******************************************************* -->
    <br>

    <div>
        <center>
            Have a nice day !!
        </center>
    </div>

    </div>

</div>


<br><br>
<button id="mybtn">Click to PRint</button>
</body>
<script type="text/javascript"  src="../../../lib/jquery/jquery.js" ></script>
<script type="text/javascript"  src="../../../lib/jquery/jquery.print.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js"></script>



</html>