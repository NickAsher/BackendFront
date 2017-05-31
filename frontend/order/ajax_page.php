<?php

require_once '../../sql/sqlconnection.php';
require_once '../../utils/backend_utils.php';
require_once 'utils/utils-order-parsing.php';
require_once '../menu2/utils/menu-utils.php' ;


$DBConnectionBackend = YOLOSqlConnect() ;
//$DBConnectionTry = YOLOSqlTryConnect() ;


$Date = '' ;
if(isset($_GET['date']) && !empty($_GET['date']) ){
    $Date = $_GET['date'] ;
} else {
//    $Date = date('Y-m-d') ;
    $Date = '2017-03-11' ;

}


$Query1 = "SELECT * FROM `order_daily_table` WHERE `order_date` = '$Date' AND `order_status` = 'Pending' ORDER BY `order_no` DESC  " ;
$QueryResult1 = mysqli_query($DBConnectionBackend, $Query1) ;
if($QueryResult1){
    $NoOfNewOrders =  mysqli_num_rows($QueryResult1);
} else {
    echo "problem in fetching data from order table(New Orders)  <br>".mysqli_error($DBConnectionBackend) ;
}


$Query2 = "SELECT * FROM `order_daily_table` WHERE `order_date` = '$Date' AND `order_status` = 'Working' ORDER BY `order_no` DESC " ;
$QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
if($QueryResult2){
    $NoOfWorkingOrders =  mysqli_num_rows($QueryResult2);
} else {
    echo "problem in fetching data from order table (Working Orders)  <br>".mysqli_error($DBConnectionBackend) ;
}


$Query3 = "SELECT * FROM `order_daily_table` WHERE `order_date` = '$Date' AND `order_status` = 'Completed' ORDER BY `order_no` DESC " ;
$QueryResult3 = mysqli_query($DBConnectionBackend, $Query3) ;
if($QueryResult3){
    $NoOfCompletedOrders =  mysqli_num_rows($QueryResult3);
} else {
    echo "problem in fetching data from order table (Completed Orders) <br>".mysqli_error($DBConnectionBackend) ;
}

$Query4 = "SELECT * FROM `order_daily_table` WHERE `order_date` = '$Date' AND `order_status` = 'Cancelled' ORDER BY `order_no` DESC " ;
$QueryResult4 = mysqli_query($DBConnectionBackend, $Query4) ;
if($QueryResult4){
    $NoOfCancelledOrders =  mysqli_num_rows($QueryResult4);
} else {
    echo "problem in fetching data from order table  (Finished Orders) <br>".mysqli_error($DBConnectionBackend) ;
}

?>





    <div>
        <a id="TitleBadgeNo"><?php echo "$NoOfNewOrders" ; ?></a>


        <a id="Ajax_navTab_NewOrders" >
            New orders &nbsp; &nbsp; <span class="badge badge-info"><?php echo $NoOfNewOrders ; ?></span> &nbsp; &nbsp;
        </a>

        <a id="Ajax_navTab_WorkingOrders" >
            Working orders &nbsp; &nbsp; <span class="badge badge-warning"><?php echo $NoOfWorkingOrders ; ?></span> &nbsp; &nbsp;
        </a>

        <a id="Ajax_navTab_CompletedOrders" >
            Completed orders &nbsp; &nbsp; <span class="badge badge-success"><?php echo $NoOfCompletedOrders ; ?></span> &nbsp; &nbsp;
        </a>

        <a id="Ajax_navTab_CancelledOrders" >
            Cancelled orders &nbsp; &nbsp; <span class="badge badge-danger"><?php echo $NoOfCancelledOrders ; ?></span> &nbsp; &nbsp;
        </a>



    </div>









    <div >
        <div id="Ajax_new_orders">
            <?php require_once 'new_orders.php'; ?>
        </div>
        <div id="Ajax_working_orders">
            <?php require_once 'working_order.php' ?>
        </div>
        <div id="Ajax_cancelled_orders">
            <?php require_once 'cancelled_orders.php' ?>
        </div>
        <div id="Ajax_complete_orders">
            <?php require_once 'completed_orders.php' ?>
        </div>

    </div>















