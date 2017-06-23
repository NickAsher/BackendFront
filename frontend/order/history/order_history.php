<html>
<head>
    <title> Vesu Online Ordering Cms</title>
    <link rel="stylesheet" href="../../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-reboot.min.css" >


    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />


    <link rel="stylesheet" href="../css/index.css" >
    <link rel="stylesheet" href="../css/menu.css" >
    <link rel="stylesheet" href="../css/tables.css" >

    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php';
    require_once $ROOT_FOLDER_PATH.'/utils/backend_utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/paginator.php' ;
    require_once '../utils/utils-order-parsing.php';



    $DBConnectionBackend = YOLOSqlConnect() ;


    /*
     * Get the data here
     */
    $Date = '' ;
    if(isset($_GET['date']) && !empty($_GET['date']) ){
        $Date = $_GET['date'] ;
    } else {
//    $Date = date('Y-m-d') ;
        $Date = '2017-03-11' ;

    }



    /*
     * Set up the paginator  here.
     */
    $Query1 = "SELECT COUNT(*) AS `total` FROM `order_table` WHERE `order_date` = '$Date' " ;
    $Queryresult1 = mysqli_query($DBConnectionBackend, $Query1) ;
    if(!$Queryresult1){
        die("Error fetch count <br>".mysqli_error($DBConnectionBackend)) ;
    }
    $TotalNumOfItems = mysqli_fetch_assoc($Queryresult1)['total'] ;
    $NoOfItemsPerPage = 10 ;

    if(isset($_GET['___page_no'])){
        $PageNo = $_GET['___page_no'] ;
    } else {
        $PageNo = 1 ;
    }

    $Paginator = new Paginator($TotalNumOfItems, $NoOfItemsPerPage, $PageNo) ;
    $Offset = $Paginator->getOffset() ;
    $MaxPageNo = $Paginator->getMaxPageNo() ;
    $RealCurrentPageNo = $Paginator->getRealCurrentPageNo() ;






    $Query3 = "SELECT * FROM `order_table` WHERE `order_date` = '$Date' ORDER BY `order_no` ASC LIMIT $NoOfItemsPerPage OFFSET $Offset" ;
    $QueryResult3 = mysqli_query($DBConnectionBackend, $Query3) ;
    if(!$QueryResult3){
        echo "problem in fetching data from order table (Completed Orders) <br>".mysqli_error($DBConnectionBackend) ;
    }





    ?>

</head>
<body>


<?php //require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/header.php'; ?>



<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12 bg-grey" >


                <div id="space_below_header">
                    <br><br><br>
                </div>




                <div>
                    <form method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="___page_no" >
                                    <?php
                                    $SelectString = null ;


                                    for($i=1;$i<=$MaxPageNo;$i++){
                                        if ($i == $RealCurrentPageNo){
                                            $SelectString = "selected" ;
                                        }else {
                                            $SelectString = "" ;
                                        }
                                        echo "
                                            <option value='$i' $SelectString>$i</option>
                                        " ;
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Go">
                            </div>
                        </div>



                    </form>
                </div>

















            <div  id="complete_orders">
                <table class="table table-hover" >

                    <tr class="bg-info">
                        <th>Order No</th>
                        <th>Order Id</th>
                        <th>User Details</th>
                        <th>User Address</th>
                        <th>Total Amount</th>
                        <th>Description</th>
                        <th>Comments</th>
                        <th>Order Time</th>
                        <th>Order Description</th>
                        <th></th>
                    </tr>




                    <?php

                    foreach($QueryResult3 as $Record){
                        $OrderId = $Record['order_id'] ;
                        $OrderNo = $Record['order_no'] ;

                        $UserId = $Record['user_id']   ;
                        $UserInformation = getUserProfileInformation($DBConnectionBackend, $UserId) ;
                        $UserString = $UserInformation['user_name'].'<br>'.$UserInformation['user_phone'].'<br>' ;

                        $OrderAddressString =  parseOrderAddress($Record['order_address']  ) ;
                        $Order_time = $Record['order_time']   ;
                        $Order_total = $Record['order_total']  ;
                        $Order_status = $Record['order_status']   ;

                        $CartJson = $Record['cart'] ;
                        $CartJsonArray = json_decode($Record['cart'], true) ;
                        $DescriptionString = "" ;
                        foreach($CartJsonArray as $Record2){
                            $DescriptionString .= parseOrderDescriptionString($DBConnectionBackend, $Record2) ;
                        }


                        echo "
                            <tr>
                                <td class='text-size-small'>".$OrderNo."</td>
                                <td class='text-size-small'>".$OrderId."</td>
                                <td class='text-size-small'>".$UserString."</td>
                                <td class='text-size-small'>".$OrderAddressString."</td>
                                <td> $".$Order_total."</td>
                                <td class='text-size-small'>".$DescriptionString."</td>
                                <td class='text-size-small'>".'comments'."</td>
                                <td class='text-size-small'>".$Order_time."</td>
                                <td class='text-size-small'>".$Order_status."</td>
                              

                            </tr>
                        " ;





                    }


                    ?>

                </table>

            </div>




                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>





            </div>
        </div>
    </div>
</section>



<?php //require_once "includes/footer.php" ?>


</body>
<script type="text/javascript"  src="../../../lib/jquery/jquery.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../lib/toastr/toastr.min.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>

<script type="text/javascript" >




















</script>

</html>