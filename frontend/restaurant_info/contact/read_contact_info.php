<?php

?>
<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-16">
    <link rel="stylesheet" href="../../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-reboot.min.css" >

    <link rel="stylesheet" href="../../../lib/toastr/toastr.min.css">

    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />


    <link rel="stylesheet" href="../../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../../common/css/classes.css">




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
    $RestaurantImage = $TempArray['restaurant_image'] ;
    $ReataurantLogo = $TempArray['restaurant_logo'] ;
    $RestaurantAddress1 = $TempArray['restaurant_addr_1'] ;
    $RestaurantAddress2 = $TempArray['restaurant_addr_2'] ;
    $RestaurantAddress3 = $TempArray['restaurant_addr_3'] ;
    $RestaurantHoursMonFri = $TempArray['restaurant_hours_monfri'] ;
    $RestaurantHoursSatSat = $TempArray['restaurant_hours_satsun'] ;
    $RestaurantPhoneNum = $TempArray['restaurant_phone'] ;
    $RestaurantEmail = $TempArray['restaurant_email'] ;







    ?>


</head>
<body>

<div><?php require_once "../includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12 " style="background-color: #eee">




                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>



                <div class="row">
                    <div class = col-md-2></div>
                    <div id="Section_AddNewItemForm" class="col-md-9" >

                        <div class="card">
                            <div class="card-header">
                                <h3 class="ytext-heading">For Google Maps</h3>
                            </div>
                            <div class="card-block">

                                <div class="form-group row">
                                    <label for="input-rest-latitude" class="col-3 col-form-label">Latitude</label>
                                    <div class="col-md-9">
                                        <input name="__" class="form-control" type="text" placeholder="ex. 94.147" id="input-rest-latitude" value="<?php echo "$Latitude" ?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-longitude" class="col-3 col-form-label">Longitude</label>
                                    <div class="col-md-9">
                                        <input name="__" class="form-control" type="text" placeholder="ex. 120.745" id="input-rest-longitude" value="<?php echo "$Longitude" ?>" disabled>
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
                                    <label for="input-rest-name" class="col-3 col-form-label">Restaurant Name</label>
                                    <div class="col-md-9">
                                        <input name="__restaurant_image" class="form-control" type="text" placeholder="ex. My Restaurant" id="input-rest-name" value="<?php echo "$RestaurantName" ?> " disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-photo" class="col-3 col-form-label">Restaurant Image</label>
                                    <div class="col-md-9 ">
                                        <div class="col-6 form-control">
                                            <center><img src="<?php echo "$IMAGE_BACKENDFRONT_LINK_PATH/$RestaurantImage "; ?>" class="img-fluid" width='180'></center>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="input-rest-photo" class="col-3 col-form-label">Restaurant Logo</label>
                                    <div class="col-md-9 ">
                                        <div class="col-6 form-control">
                                            <center><img src="<?php echo "$IMAGE_BACKENDFRONT_LINK_PATH/$ReataurantLogo "; ?>" class="img-fluid" width='180'></center>
                                        </div>
                                    </div>
                                </div>



                                <br>

                                <div class="form-group row">
                                    <label for="input-rest-addr1" class="col-3 col-form-label">Address Line 1 </label>
                                    <div class="col-md-9">
                                        <input name="__newitem_name" class="form-control" type="text" placeholder="" id="input-rest-addr1" value="<?php echo "$RestaurantAddress1" ?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-addr2" class="col-3 col-form-label">Address Line 2</label>
                                    <div class="col-md-9">
                                        <input name="__" class="form-control" type="text" placeholder="" id="input-rest-addr2" value="<?php echo "$RestaurantAddress2" ?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-addr3" class="col-3 col-form-label">Address Line 3</label>
                                    <div class="col-md-9">
                                        <input name="__newitem_name" class="form-control" type="text" placeholder="" id="input-rest-addr3" value="<?php echo "$RestaurantAddress3" ?>" disabled>
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
                                    <label for="input-rest-hours1" class="col-3 col-form-label">Monday to Friday</label>
                                    <div class="col-md-9">
                                        <input name="__" class="form-control" type="text" placeholder="ex. 8:00 a.m - 10:30 p.m" id="input-rest-hours1" value="<?php echo "$RestaurantHoursMonFri" ?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-hours2" class="col-3 col-form-label">Saturday and Sunday</label>
                                    <div class="col-md-9">
                                        <input name="__newitem_name" class="form-control" type="text" placeholder="ex. 8:00 a.m - 10:30 p.m" id="input-rest-hours2" value="<?php echo "$RestaurantHoursSatSat" ?>" disabled>
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
                                    <label for="input-rest-phone" class="col-3 col-form-label">Phone no</label>
                                    <div class="col-md-9">
                                        <input name="__" class="form-control" type="text" placeholder="ex. 9780045712" id="input-rest-phone" value="<?php echo "$RestaurantPhoneNum" ?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-email" class="col-3 col-form-label">Email Id</label>
                                    <div class="col-md-9">
                                        <input name="__newitem_name" class="form-control" type="text" placeholder="ex. example@gmail.com" id="input-rest-email" value="<?php echo "$RestaurantEmail" ?>" disabled>
                                    </div>
                                </div>



                            </div>
                        </div>

                        <br><br<br><br>



                            <div class="form-group row">
                                <div class="col-4" ></div>
                                <a class="col-4 btn btn-outline-info" href="edit_contact_info.php" > Edit</a>
                                <div class="col-4" ></div>
                            </div>






                        <div id="space_before_footer">
                            <br><br><br><br><br>
                        </div>




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
<script type="text/javascript" src="../../../lib/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../../lib/toastr/toastr.min.js" ></script>

<script type="text/javascript" src="../../../lib/t3/t3.js"></script>


<script type="text/javascript">
    function makeToast(toastStyle, toastMessage) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        } ;

        toastr[toastStyle](toastMessage) ;
    }



</script>


</html>