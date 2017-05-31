<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-8">



    <link rel="stylesheet" href="../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap_addon.css" >

    <link rel="stylesheet" href="../../lib/font-awesome/css/font-awesome.css" >


    <link rel="stylesheet" href="../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../common/css/classes.css">


    <link rel="stylesheet" href="../../lib/t3/t3.css" />




    <?php
    require_once '../../utils/constants.php';

    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;

    $DBConnectionBackend = YOLOSqlConnect() ;


    ?>



</head>



<body>

<?php require_once "includes/header.php" ?>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">

            <div class="col-md-12">

                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>






                <table  class="table table-bordered table-hover" >



                    <tr class="table-info">
                        <th>Coupon Name</th>
                        <th>Coupon Description </th>
                        <th>Creation Date</th>
                        <th>Expiry Date </th>
                        <th>Coupon Type </th>
                        <th>Edit </th>
                        <th>Delete</th>


                    </tr>




                    <?php

                    $Query = "SELECT * FROM `coupon_coupons_discount_table` WHERE `active` = '1' " ;
                    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
                    if($QueryResult){
                        foreach($QueryResult as $Record){
                            $CouponId = $Record['id'] ;
                            $CouponName = $Record['name'] ;
                            $CouponDescription = $Record['description'] ;
                            $CreationDate = $Record['creation_timestamp'] ;
                            $ExpiryDate = $Record['expiry_timestamp'] ;
                            $CouponType = $Record['type'] ;

                            $ShowCouponLink = "show-coupon-cart.php?___coupon_id=$CouponId" ;

                            echo "
                                <tr>
                                    <td class='addon-link' data-href='$ShowCouponLink'>$CouponName </td>
                                    <td class='addon-link' data-href='$ShowCouponLink'>$CouponDescription </td>
                                    <td class='addon-link' data-href='$ShowCouponLink'>$CreationDate </td>
                                    <td class='addon-link' data-href='$ShowCouponLink'>$ExpiryDate </td>
                                    <td class='addon-link' data-href='$ShowCouponLink'>$CouponType </td>
                                    
                                    <td>
                                        <form action='edit-coupon-cart.php' method='post'>
                                            <input type='hidden' name='__coupon_id' value='$CouponId'>
                                            <button type='submit' class='btn btn-info' >
                                                <span><i class='fa fa-edit'></i></span> &nbsp; | &nbsp; Edit
                                            </button>
                                           
                                        </form>      
                                    </td>
                                    <td>
                                        <form action='confirm-delete-coupon.php' method='post'>
                                            <input type='hidden' name='__coupon_id' value='$CouponId'>
                                            <input type='hidden' name='__coupon_type' value='$CouponType'>
                                            <button type='submit' class='btn btn-danger' >
                                                <span><i class='fa fa-trash'></i></span> &nbsp; | &nbsp; Delete
                                            </button>
                                        </form>  
                                    </td>

                                    

                                </tr>" ;


                        }
                    } else {
                        echo "Problem in fetching entries from coupon_table <br>".mysqli_error($DBConnectionBackend) ;
                    }


                    ?>

                </table>






                <br><br>



                <div class="row">
                    <div class="col-4"></div>
                    <a class="col-4 btn btn-outline-info" href="add-coupon-cart.php">
                        Add New Item
                    </a>
                    <div class="col-4"></div>
                </div>







                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>





            </div>
        </div>
    </div>
</section>



<?php require_once "../common/includes/footer.php" ?>



</body>
<script type="text/javascript" src="../../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript" src="../../lib/t3/t3.js"></script>




</html>
