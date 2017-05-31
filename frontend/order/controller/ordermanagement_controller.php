<?php


function NewOrder_AcceptOrder($DBConnection, $OrderId){
    $Query = "SELECT * FROM `daily_order_table` WHERE `order_id` = '$OrderId'   " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){

        $Query2 = "UPDATE `daily_order_table` SET `order_status` = 'Working' WHERE `order_id` = '$OrderId'   " ;
        $QueryResult2 = mysqli_query($DBConnection, $Query2) ;
        if($QueryResult2){
            echo "success-$OrderId" ;


        } else {
            echo "unable to change the order status <br>".mysqli_error($DBConnection) ;
        }

    } else {
        echo "Unable to get the order information <br> ".mysqli_error($DBConnection) ;
    }


}


function NewOrder_CancelOrder($DBConnection, $OrderId){
    $Query = "SELECT * FROM `daily_order_table` WHERE `order_id` = '$OrderId'   " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){

        $Query2 = "UPDATE `daily_order_table` SET `order_status` = 'Cancelled' WHERE `order_id` = '$OrderId'   " ;
        $QueryResult2 = mysqli_query($DBConnection, $Query2) ;
        if($QueryResult2){
            echo "success-$OrderId" ;


        } else {
            echo "unable to change the order status <br>".mysqli_error($DBConnection) ;
        }

    } else {
        echo "Unable to get the order information <br> ".mysqli_error($DBConnection) ;
    }


}


function WorkingOrder_CompleteOrder($DBConnection, $OrderId){
    $Query = "SELECT * FROM `daily_order_table` WHERE `order_id` = '$OrderId'   " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){

        $Query2 = "UPDATE `daily_order_table` SET `order_status` = 'Completed' WHERE `order_id` = '$OrderId'   " ;
        $QueryResult2 = mysqli_query($DBConnection, $Query2) ;
        if($QueryResult2){
            echo "success-$OrderId" ;


        } else {
            echo "unable to change the order status <br>".mysqli_error($DBConnection) ;
        }

    } else {
        echo "Unable to get the order information <br> ".mysqli_error($DBConnection) ;
    }


}


function WorkingOrder_CancelOrder($DBConnection, $OrderId){
    $Query = "SELECT * FROM `daily_order_table` WHERE `order_id` = '$OrderId'   " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){

        $Query2 = "UPDATE `daily_order_table` SET `order_status` = 'Cancelled' WHERE `order_id` = '$OrderId'   " ;
        $QueryResult2 = mysqli_query($DBConnection, $Query2) ;
        if($QueryResult2){
            echo "success-$OrderId" ;


        } else {
            echo "unable to change the order status <br>".mysqli_error($DBConnection) ;
        }

    } else {
        echo "Unable to get the order information <br> ".mysqli_error($DBConnection) ;
    }


}






require_once '../../../sql/sqlconnection.php';
require_once '../../../utils/backend_utils.php';




$DBConnectionBackend = YOLOSqlConnect() ;
//echo "<script>console.log('I am atleast here') </script>" ;


if(  isset($_GET['oper'])  && isset($_GET['order_id'])   && !empty($_GET['oper'])    ){
    $OrderOperation = $_GET['oper'] ;
    $OrderId = $_GET['order_id'] ;

//    echo "<script>console.log('I am here') </script>" ;




    if($OrderOperation == 'new_order_accept'){
//        echo "<script>console.log('Accepted the order') </script>" ;
        NewOrder_AcceptOrder($DBConnectionBackend, $OrderId) ;
    }

    else if($OrderOperation == 'new_order_cancel'){
        NewOrder_CancelOrder($DBConnectionBackend, $OrderId) ;
    }

    else if($OrderOperation == 'working_order_complete'){
        WorkingOrder_CompleteOrder($DBConnectionBackend, $OrderId) ;
    }

    else if($OrderOperation == 'working_order_cancel'){
        WorkingOrder_CancelOrder($DBConnectionBackend, $OrderId) ;
    }



}









?>