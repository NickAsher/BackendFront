<?php


function SS_isStart($DBConnection){
    $Query = "SELECT * FROM `start_stop_table` WHERE `rest_id` = '1' " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if(!$QueryResult){
        throw new Exception("Unable to fetch the data from start_stop_table: ".mysqli_error($DBConnection)) ;
    }


    $Value = mysqli_fetch_assoc($QueryResult)['start'] ;
    if($Value == '1'){
        return true ;
    } else if ($Value == '0'){
        return false ;
    } else {
        throw new Exception("Unknown value of 'start' column in start_stop_table") ;
    }


}



function SS_AreAllOrdersCompleted($DBConnection){
    $Date = '2017-03-11' ;

    try{

        $Query1 = "SELECT * FROM `order_daily_table` WHERE `order_date` = '$Date' AND `order_status` = 'Pending'   " ;
        $QueryResult1 = mysqli_query($DBConnection, $Query1) ;
        if(!$QueryResult1){
            throw new Exception("Unable to fetch Pending orders: ".mysqli_error($DBConnection)) ;
        }
        $NoOfNewOrders =  mysqli_num_rows($QueryResult1);


        $Query2 = "SELECT * FROM `order_daily_table` WHERE `order_date` = '$Date' AND `order_status` = 'Working'  " ;
        $QueryResult2 = mysqli_query($DBConnection, $Query2) ;
        if(!$QueryResult2){
            throw new Exception("Unable to fetch working orders: ".mysqli_error($DBConnection)) ;
        }
        $NoOfWorkingOrders =  mysqli_num_rows($QueryResult2);


        if($NoOfNewOrders == 0 && $NoOfWorkingOrders == 0){
//            echo "New Order : $NoOfNewOrders <br> Working Order: $NoOfWorkingOrders" ;
            return true ;
        } else {
            return false ;
        }

    } catch (Exception $e){
        echo  $e ;
        return false ;
    }


}




function SS_Start($DBConnection){
    $Query = "UPDATE `start_stop_table` SET `start` = '1' WHERE `rest_id` = '1' " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
        return true ;
    } else {
        throw new Exception("Unable to update the start value from start_stop_table: ".mysqli_error($DBConnection)) ;
    }
}


function SS_Stop($DBConnection){

    mysqli_begin_transaction($DBConnection) ;
    try{
        $Query1 = "INSERT INTO `order_table` 
          SELECT `order_id`, `order_no`, `user_id`, `order_address`, `cart`, `order_date`, `order_time`, `order_total_quantity`, `net_price`, `use_coupon`, `coupon_code`, `coupon_discount`, `vat`, `service_tax`, `order_total`, `order_status` FROM `order_daily_table` " ;
        $QueryResult1 = mysqli_query($DBConnection, $Query1) ;
        if(!$QueryResult1){
            throw new Exception("Unable to do step 1 in moving rows ".mysqli_error($DBConnection)) ;
        }


        $Query2 = "DELETE FROM `order_daily_table` " ;
        $QueryResult2 = mysqli_query($DBConnection, $Query2) ;
        if(!$QueryResult2){
            throw new Exception("Unable to do step 2 (delete) of moving rows".mysqli_error($DBConnection)) ;
        }



        $Query3 = "ALTER TABLE `order_daily_table` AUTO_INCREMENT = 1 " ;
        $QueryResult3 = mysqli_query($DBConnection, $Query3) ;
        if(!$QueryResult3){
            throw new Exception("Unable to do step 3 (aut-increment) of moving rows".mysqli_error($DBConnection)) ;
        }


        $Query4 = "UPDATE `start_stop_table` SET `start` = '0' WHERE `rest_id` = '1' " ;
        $QueryResult4 = mysqli_query($DBConnection, $Query4) ;
        if(!$QueryResult4){
            throw new Exception("Unable to update the start value from start_stop_table: ".mysqli_error($DBConnection)) ;
        }




        mysqli_commit($DBConnection) ;
        mysqli_autocommit($DBConnection, true) ;
        return true ;

    } catch (Exception $e){
        echo $e ;
        mysqli_rollback($DBConnection) ;
        mysqli_autocommit($DBConnection, true) ;
        return false ;
    }




}



function SS_moveDailyDataToMainData($DBConnection){

    mysqli_begin_transaction($DBConnection) ;
    try{
        $Query1 = "INSERT INTO `order_table` 
          SELECT `order_id`, `order_no`, `user_id`, `order_address`, `cart`, `order_date`, `order_time`, `order_total_quantity`, `net_price`, `use_coupon`, `coupon_code`, `coupon_discount`, `vat`, `service_tax`, `order_total`, `order_status` FROM `order_daily_table` " ;
        $QueryResult1 = mysqli_query($DBConnection, $Query1) ;
        if(!$QueryResult1){
            throw new Exception("Unable to do step 1 in moving rows ".mysqli_error($DBConnection)) ;
        }


        $Query2 = "DELETE FROM `order_daily_table` " ;
        $QueryResult2 = mysqli_query($DBConnection, $Query2) ;
        if(!$QueryResult2){
            throw new Exception("Unable to do step 2 (delete) of moving rows".mysqli_error($DBConnection)) ;
        }



        $Query3 = "ALTER TABLE `order_daily_table` AUTO_INCREMENT = 1 " ;
        $QueryResult3 = mysqli_query($DBConnection, $Query3) ;
        if(!$QueryResult3){
            throw new Exception("Unable to do step 3 (aut-increment) of moving rows".mysqli_error($DBConnection)) ;
        }




        mysqli_commit($DBConnection) ;
        mysqli_autocommit($DBConnection, true) ;
        echo "Successfuly moved" ;

    } catch (Exception $e){
        echo $e ;
        mysqli_rollback($DBConnection) ;
        mysqli_autocommit($DBConnection, true) ;
    }

}