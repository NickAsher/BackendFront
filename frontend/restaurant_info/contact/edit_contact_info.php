<?php

?>
<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-16">
    <link rel="stylesheet" href="../common/css/reset.css" >

    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-reboot.min.css" >


    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../../common/css/classes.css">


    <link rel="stylesheet" href="../css/default_style.css">


    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;

    $DBConnectionBackend = YOLOSqlConnect() ;

    $Query = "SELECT * FROM `info_contact_table` WHERE `restaurant_id` = '1' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;

    $TempArray = '' ;
    if($QueryResult) {
        foreach($QueryResult as $Record){
            $TempArray = $Record ;
        }
    } else {
        echo "Error in getting the variables <br> ".mysqli_error($DBConnectionBackend) ;
    }





    $RestaurantId = $TempArray['restaurant_id'] ;
    $Latitude = $TempArray['latitude'] ;
    $Longitude = $TempArray['longitude'] ;
    $RestaurantName = $TempArray['restaurant_name'] ;
    $ReataurantImage = $TempArray['restaurant_image'] ;
    $RestaurantAddress1 = $TempArray['restaurant_addr_1'] ;
    $RestaurantAddress2 = $TempArray['restaurant_addr_2'] ;
    $RestaurantAddress3 = $TempArray['restaurant_addr_3'] ;
    $RestaurantHoursMonFri = $TempArray['restaurant_hours_monfri'] ;
    $RestaurantHoursSatSat = $TempArray['restaurant_hours_satsun'] ;
    $RestaurantPhoneNum = $TempArray['restaurant_phone'] ;
    $RestaurantFax = $TempArray['restaurant_email'] ;







    ?>


</head>
<body>

<div><?php require_once "../includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12">




                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>

                <div class="row">
                    <div class = col-md-2></div>
                    <div id="Section_AddNewItemForm" class="col-md-9" >


                    <form action="process-edit-contact_info.php" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="ytext-heading">For Google Maps</h3>
                            </div>
                            <div class="card-block">

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Latitude</label>
                                    <div class="col-9">
                                        <input name="__rest_latitude" class="form-control" type="text" placeholder="ex. 94.147" id="input-item-name" value="<?php echo "$Latitude" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Longitude</label>
                                    <div class="col-9">
                                        <input name="__rest_longitude" class="form-control" type="text" placeholder="ex. 120.745" id="input-item-name" value="<?php echo "$Longitude" ?>" >
                                    </div>
                                </div>


                            </div>
                        </div>

                        <br><br>


                        <div class="card">
                            <div class="card-header">
                                <h3 class="ytext-heading">Location Info</h3>
                            </div>
                            <div class="card-block">

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Restaurant Name</label>
                                    <div class="col-9">
                                        <input name="__rest_name" class="form-control" type="text" placeholder="ex. My Restaurant" id="input-item-name" value="<?php echo "$RestaurantName" ?> " >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Restaurant Image</label>
                                    <div class="col-9">
                                        <input name="__rest_image" class="form-control" type="text" placeholder="Ex. 120.745" id="input-item-name" value="<?php echo "$RestaurantName" ?>" >
                                    </div>
                                </div>



                                <br>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Address Line 1 </label>
                                    <div class="col-9">
                                        <input name="__rest_addr1" class="form-control" type="text" placeholder="" id="input-item-name" value="<?php echo "$RestaurantAddress1" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Address Line 2</label>
                                    <div class="col-9">
                                        <input name="__rest_addr2" class="form-control" type="text" placeholder="" id="input-item-name" value="<?php echo "$RestaurantAddress2" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Address Line 3</label>
                                    <div class="col-9">
                                        <input name="__rest_addr3" class="form-control" type="text" placeholder="" id="input-item-name" value="<?php echo "$RestaurantAddress3" ?>" >
                                    </div>
                                </div>


                            </div>
                        </div>




                        <br><br>


                        <div class="card">
                            <div class="card-header">
                                <h3 class="ytext-heading">Opening Hours</h3>
                            </div>
                            <div class="card-block">

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Monday to Friday</label>
                                    <div class="col-9">
                                        <input name="__rest_hours1" class="form-control" type="text" placeholder="ex. 8:00 a.m - 10:30 p.m" id="input-item-name" value="<?php echo "$RestaurantHoursMonFri" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Saturday and Sunday</label>
                                    <div class="col-9">
                                        <input name="__rest_hours2" class="form-control" type="text" placeholder="ex. 8:00 a.m - 10:30 p.m" id="input-item-name" value="<?php echo "$RestaurantHoursSatSat" ?>" >
                                    </div>
                                </div>



                            </div>
                        </div>


                        <br><br>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="ytext-heading">Contact Info</h3>
                            </div>
                            <div class="card-block">

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Phone no</label>
                                    <div class="col-9">
                                        <input name="__rest_phone" class="form-control" type="text" placeholder="ex. 9780045712" id="input-item-name" value="<?php echo "$RestaurantPhoneNum" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Email Id</label>
                                    <div class="col-9">
                                        <input name="__rest_email" class="form-control" type="text" placeholder="ex. example@gmail.com" id="input-item-name" value="<?php echo "$RestaurantFax" ?>" >
                                    </div>
                                </div>



                            </div>
                        </div>

                        <br><br<br><br>



                        <div class="form-group row">
                            <div class="col-4" ></div>
                            <input type="submit" class=" col-4 btn btn-outline-info" value="Save">
                            <div class="col-4" ></div>
                        </div>









                    </form>
                    </div>
                    <div class="col-md-1"></div>
                </div>





                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>






            </div>
        </div>
    </div>
</section>



<div><?php require_once "../../common/includes/footer.php" ?></div>


</body>
<script type="text/javascript"  src="../../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
</html>