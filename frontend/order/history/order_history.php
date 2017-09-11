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
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php';
//    require_once $ROOT_FOLDER_PATH.'/utils/backend_utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/user-utils.php';

    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/paginator.php' ;
    require_once '../utils/utils-order-parsing.php';



    $DBConnectionBackend = YOPDOSqlConnect() ;


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


    if(isset($_GET['___page_no'])){
        $PageNo = $_GET['___page_no'] ;
    } else {
        $PageNo = 1 ;
    }





    /*
     * Set up the paginator  here.
     */
    $NoOfItemsPerPage = 10 ;
    $Query1 = "SELECT COUNT(*) AS `total` FROM `order_table` WHERE `order_date` = :odate " ;
    try {
        $Queryresult1 = $DBConnectionBackend->prepare($Query1);
        $Queryresult1->execute(['odate' => $Date]);
        $TotalNumOfItems = $Queryresult1->fetch(PDO::FETCH_ASSOC)['total'] ;

    } catch (Exception $e) {
        die("Error in getting the total count of orders : ".$e) ;
    }



    $Paginator = new Paginator($TotalNumOfItems, $NoOfItemsPerPage, $PageNo) ;
    $Offset = $Paginator->getOffset() ;
    $MaxPageNo = $Paginator->getMaxPageNo() ;
    $RealCurrentPageNo = $Paginator->getRealCurrentPageNo() ;







    $Query3 = "SELECT * FROM `order_table` WHERE `order_date` = :odate ORDER BY `order_no` ASC LIMIT :limit OFFSET :offset" ;

//    echo $Query3 ;
    try {
        $QueryResult3 = $DBConnectionBackend->prepare($Query3);
        $QueryResult3->bindParam('odate', $Date, PDO::PARAM_STR);
        $QueryResult3->bindParam('limit', $NoOfItemsPerPage, PDO::PARAM_INT);
        $QueryResult3->bindParam('offset', $Offset, PDO::PARAM_INT);
        $QueryResult3->execute();
        $AllOrders = $QueryResult3->fetchAll() ;
    } catch (Exception $e) {
        die("Error in fetching the Orders from order_table: ".$e) ;
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
                        <input type="hidden" name="date" value='<?php echo "$Date" ?>' >
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

                    foreach($AllOrders as $Record){
                        $OrderId = $Record['order_id'] ;
                        $OrderNo = $Record['order_no'] ;

                        $UserId = $Record['user_id']   ;
                        $UserInformation = getUserProfileInformation_PDO($DBConnectionBackend, $UserId) ;
                        $UserString = $UserInformation['user_name'].'<br>'.$UserInformation['user_phone'].'<br>' ;

                        $OrderAddressString =  parseOrderAddress($Record['order_address']  ) ;
                        $Order_time = $Record['order_time']   ;
                        $Order_total = $Record['order_total']  ;
                        $Order_status = $Record['order_status']   ;

                        $CartJson = $Record['cart'] ;
                        $CartJsonArray = json_decode($Record['cart'], true) ;
                        $DescriptionString = "" ;
//                        foreach($CartJsonArray as $Record2){
//                            $DescriptionString .= parseOrderDescriptionString($DBConnectionBackend, $Record2) ;
//                        }


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