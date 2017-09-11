<table class="table table-hover" >

    <tr class="bg-info">
        <th>Order No</th>
        <th>User Details</th>
        <th>User Address</th>
        <th>Total Amount</th>
        <th>Description</th>
        <th>Comments</th>
        <th>Order Time</th>
        <th>Accept</th>
        <th>Accepted Notification</th>
        <th>Cancel</th>
        <th></th>
    </tr>




    <?php




    foreach($QueryResult1 as $Record){
        $OrderId = $Record['order_id'] ;
        $OrderNo = $Record['order_no'] ;

        $UserId = $Record['user_id']   ;
        $UserInformation = getUserProfileInformation($DBConnectionBackend, $UserId) ;
        $UserString = $UserInformation['user_firstname'].'<br>'.$UserInformation['user_phone'].'<br>' ;

        $OrderAddressString =  parseOrderAddress($Record['order_address']  ) ;
        $Order_date = $Record['order_date']   ;
        $Order_time = $Record['order_time']   ;
        $Order_total = $Record['order_total']  ;
        $Order_status = $Record['order_status']   ;

        $CartJson = $Record['cart'] ;
        $CartJsonArray = json_decode($Record['cart'], true) ;
        $DescriptionString = "" ;
        foreach($CartJsonArray as $Record2){
            $DescriptionString .= parseOrderDescriptionString($DBConnectionBackend, $Record2) ;
        }


        echo "<tr>" ;
        echo "<td class='text-size-small'> $OrderNo </td>" ;
        echo "<td class='text-size-small'> $UserString </td>" ;
        echo "<td class='text-size-small'> $OrderAddressString </td>" ;
        echo "<td> $ $Order_total </td>" ;
        echo "<td class='text-size-small'> $DescriptionString </td>" ;
        echo "<td class='text-size-small'> 'comments' </td>" ;
        echo "<td class='text-size-small'> $Order_time </td>" ;
        echo "<td><button id='$OrderId-new_order_accept'  class='btn btn-info btn-sm text-white notf-btn'>Send Notf</button></td>" ;
        echo "<td><button id='$OrderId-new_order_accept'  class='btn btn-info btn-sm text-white order-btn'>Accept</button></td>" ;
        echo "<td><button id='$OrderId-new_order_cancel' class='btn btn-sm btn-danger text-white order-btn' href='#'>Cancel</button></td>" ;
        echo "</tr>" ;





    }


    ?>

</table>
