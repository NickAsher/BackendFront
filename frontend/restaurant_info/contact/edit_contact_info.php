<?php

?>
<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-16">
<!--    <link rel="stylesheet" href="../common/css/reset.css" >-->

    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-reboot.min.css" >


    <link rel = "stylesheet" href="../../../lib/jquery_ui/jquery-ui.css" >
    <link rel = "stylesheet" href="../../../lib/jquery_ui/jquery-ui.structure.css" >
    <link rel = "stylesheet" href="../../../lib/jquery_ui/jquery-ui.theme.css" >

    <link rel = "stylesheet" href="../../../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.css" />



    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../../common/css/classes.css">


    <link rel="stylesheet" href="../css/default_style.css">


    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;

    $DBConnectionBackend = YOPDOSqlConnect() ;



    $Query = "SELECT * FROM `info_contact_table` WHERE `restaurant_id` = '1' " ;
    try{
        $QueryResult = $DBConnectionBackend->query($Query) ;
        $TempArray = $QueryResult->fetch(PDO::FETCH_ASSOC) ;
    }catch (Exception $e){
        throw new Exception("Error in getting the contact information: ".$e->getMessage()) ;
    }





    $RestaurantId = $TempArray['restaurant_id'] ;
    $Latitude = $TempArray['latitude'] ;
    $Longitude = $TempArray['longitude'] ;
    $RestaurantName = $TempArray['restaurant_name'] ;
    $RestaurantImage = $TempArray['restaurant_image'] ;
    $RestaurantLogo = $TempArray['restaurant_logo'] ;

    $RestaurantAddress1 = $TempArray['restaurant_addr_1'] ;
    $RestaurantAddress2 = $TempArray['restaurant_addr_2'] ;
    $RestaurantAddress3 = $TempArray['restaurant_addr_3'] ;

    $RestHours = json_decode($TempArray['restaurant_hours'], true) ;

    $RestHours_MonStart = $RestHours[0]['start_time'] ;
    $RestHours_MonEnd = $RestHours[0]['end_time'] ;
    $RestHours_TueStart = $RestHours[1]['start_time'] ;
    $RestHours_TueEnd = $RestHours[1]['end_time'] ;
    $RestHours_WedStart = $RestHours[2]['start_time'] ;
    $RestHours_WedEnd = $RestHours[2]['end_time'] ;
    $RestHours_ThuStart = $RestHours[3]['start_time'] ;
    $RestHours_ThuEnd = $RestHours[3]['end_time'] ;
    $RestHours_FriStart = $RestHours[4]['start_time'] ;
    $RestHours_FriEnd = $RestHours[4]['end_time'] ;
    $RestHours_SatStart = $RestHours[5]['start_time'] ;
    $RestHours_SatEnd = $RestHours[5]['end_time'] ;
    $RestHours_SunStart = $RestHours[6]['start_time'] ;
    $RestHours_SunEnd = $RestHours[6]['end_time'] ;

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





                        <form action="process-edit-contact_info2.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="__rest_old_main_image" value="<?php echo $RestaurantImage ?>" >
                            <input type="hidden" name="__rest_old_logo_image" value="<?php echo $RestaurantLogo ?>" >

                        <div class="card">
                            <div class="card-header">
                                <h3 class="ytext-heading">For Google Maps</h3>
                            </div>
                            <div class="card-block">

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Latitude</label>
                                    <div class="col-md-9">
                                        <input name="__rest_latitude" class="form-control" type="text" placeholder="ex. 94.147" id="input-item-name" value="<?php echo "$Latitude" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Longitude</label>
                                    <div class="col-md-9">
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
                                    <div class="col-md-9">
                                        <input name="__rest_name" class="form-control" type="text"  id="input-item-name" value="<?php echo "$RestaurantName" ?> " >
                                    </div>
                                </div>




                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Restaurant Image</label>
                                    <div class="col-md-9">
                                        <div class="row form-control">
                                            <div class="col-6">
                                                <img src="<?php echo "$IMAGE_BACKENDFRONT_LINK_PATH/$RestaurantImage "; ?>" class="img-fluid" width="180" >
                                            </div>
                                            <div class="col-6 ">
                                                <br><br><br><br>
                                                <div class="row input-group">
                                                    <button id="btn-file-choose-main_image" class="input-group-addon">Change Image</button>
                                                    <input type="file" name="__rest_main_image" style="width:0;" id="hidden-file-chooser-main_image">
                                                    <input type="text" id="presentation-only-field-main_image" class="form-control" >
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Restaurant Logo</label>
                                    <div class="col-md-9">
                                        <div class="row form-control">
                                            <div class="col-6">
                                                <img src="<?php echo "$IMAGE_BACKENDFRONT_LINK_PATH/$RestaurantLogo "; ?>" class="img-fluid" width="180" >
                                            </div>
                                            <div class="col-6 ">
                                                <br><br><br><br>
                                                <div class="row input-group">
                                                    <button id="btn-file-choose-logo_image" class="input-group-addon">Change Image</button>
                                                    <input type="file" name="__rest_logo_image" style="width:0;" id="hidden-file-chooser-logo_image">
                                                    <input type="text" id="presentation-only-field-logo_image" class="form-control" >
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                                <br>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Address Line 1 </label>
                                    <div class="col-md-9">
                                        <input name="__rest_addr1" class="form-control" type="text" id="input-item-name" value="<?php echo "$RestaurantAddress1" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Address Line 2</label>
                                    <div class="col-md-9">
                                        <input name="__rest_addr2" class="form-control" type="text" placeholder="" id="input-item-name" value="<?php echo "$RestaurantAddress2" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Address Line 3</label>
                                    <div class="col-md-9">
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
                                    <label for="input-rest-hours-mon" class="col-3 col-form-label">Monday</label>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_mon_start" id="input-rest-hours-mon-start" class="form-control timopicker" type="text" value="<?php echo "$RestHours_MonStart" ?>" >
                                    </div>
                                    <div class="col-md-3 text-center">To
                                    </div>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_mon_end" id="input-rest-hours-mon-end" class="form-control timopicker" type="text"  value="<?php echo "$RestHours_MonEnd" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-hours-tue" class="col-3 col-form-label">Tuesday</label>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_tue_start" id="input-rest-hours-tue-start" class="form-control timopicker" type="text" value="<?php echo "$RestHours_TueStart" ?>" >
                                    </div>
                                    <div class="col-md-3 text-center">To
                                    </div>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_tue_end" id="input-rest-hours-tue-end" class="form-control timopicker" type="text"  value="<?php echo "$RestHours_TueEnd" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-hours-wed" class="col-3 col-form-label">Wednesday</label>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_wed_start" id="input-rest-hours-wed-start" class="form-control timopicker" type="text" value="<?php echo "$RestHours_WedStart" ?>" >
                                    </div>
                                    <div class="col-md-3 text-center">To
                                    </div>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_wed_end" id="input-rest-hours-wed-end" class="form-control timopicker" type="text"  value="<?php echo "$RestHours_WedEnd" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-hours-thu" class="col-3 col-form-label">Thursday</label>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_thu_start" id="input-rest-hours-thu-start" class="form-control timopicker" type="text" value="<?php echo "$RestHours_ThuStart" ?>" >
                                    </div>
                                    <div class="col-md-3 text-center">To
                                    </div>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_thu_end" id="input-rest-hours-thu-end" class="form-control timopicker" type="text"  value="<?php echo "$RestHours_ThuEnd" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-hours-fri" class="col-3 col-form-label">Friday</label>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_fri_start" id="input-rest-hours-fri-start" class="form-control timopicker" type="text" value="<?php echo "$RestHours_FriStart" ?>" >
                                    </div>
                                    <div class="col-md-3 text-center">To
                                    </div>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_fri_end" id="input-rest-hours-fri-end" class="form-control timopicker" type="text"  value="<?php echo "$RestHours_FriEnd" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-hours-sat" class="col-3 col-form-label">Saturday</label>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_sat_start" id="input-rest-hours-sat-start" class="form-control timopicker" type="text" value="<?php echo "$RestHours_SatStart" ?>" >
                                    </div>
                                    <div class="col-md-3 text-center">To
                                    </div>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_sat_end" id="input-rest-hours-sat-end" class="form-control timopicker" type="text"  value="<?php echo "$RestHours_SatEnd" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-rest-hours-sun" class="col-3 col-form-label">Sunday</label>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_sun_start" id="input-rest-hours-mon-start" class="form-control timopicker" type="text" value="<?php echo "$RestHours_SunStart" ?>" >
                                    </div>
                                    <div class="col-md-3 text-center">To
                                    </div>
                                    <div class="col-md-3">
                                        <input name="__rest_hours_sun_end" id="input-rest-hours-mon-end" class="form-control timopicker" type="text"  value="<?php echo "$RestHours_SunEnd" ?>" >
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
                                    <div class="col-md-9">
                                        <input name="__rest_phone" class="form-control" type="text" placeholder="ex. 9780045712" id="input-item-name" value="<?php echo "$RestaurantPhoneNum" ?>" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-item-name" class="col-3 col-form-label">Email Id</label>
                                    <div class="col-md-9">
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
<script type="text/javascript"  src="../../../bower_components/jquery-ui/jquery-ui.js" ></script>
<script type="text/javascript"  src="../../../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.js"></script>

<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
<script type="text/javascript">
    function handleBrowseButton(ButtonId, HiddenInputId, PresentationInputId){
        $('#'+ButtonId).click(function (event) {
            event.preventDefault() ;
            $('#'+HiddenInputId).click();

            $('#'+HiddenInputId).change(function(){
                $('#'+PresentationInputId).val($(this).val());
                return false ;
            });


        }) ;
    }

    handleBrowseButton("btn-file-choose-main_image","hidden-file-chooser-main_image","presentation-only-field-main_image") ;
    handleBrowseButton("btn-file-choose-logo_image","hidden-file-chooser-logo_image","presentation-only-field-logo_image") ;





    var RestHours_MonStart = '<?php echo "$RestHours_MonStart" ?>' ;
    var RestHours_MonEnd = '<?php echo "$RestHours_MonEnd" ?>' ;
    var RestHours_TueStart = '<?php echo "$RestHours_TueStart" ?>' ;
    var RestHours_TueEnd = '<?php echo "$RestHours_TueEnd" ?>' ;
    var RestHours_WedStart = '<?php echo "$RestHours_WedStart" ?>' ;
    var RestHours_WedEnd = '<?php echo "$RestHours_WedEnd" ?>' ;
    var RestHours_ThuStart = '<?php echo "$RestHours_ThuStart" ?>' ;
    var RestHours_ThuEnd = '<?php echo "$RestHours_ThuEnd" ?>' ;
    var RestHours_FriStart = '<?php echo "$RestHours_FriStart" ?>' ;
    var RestHours_FriEnd = '<?php echo "$RestHours_FriEnd" ?>' ;
    var RestHours_SatStart = '<?php echo "$RestHours_SatStart" ?>' ;
    var RestHours_SatEnd = '<?php echo "$RestHours_SatEnd" ?>' ;
    var RestHours_SunStart = '<?php echo "$RestHours_SunStart" ?>' ;
    var RestHours_SunEnd = '<?php echo "$RestHours_SunEnd" ?>' ;




    $('.timopicker').timepicker({
        timeFormat: "hh:mm tt"
    });

    $('#input-rest-hours-mon-start').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-mon-end').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-tue-start').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-tue-end').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-wed-start').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-wed-end').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-thu-start').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-thu-end').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-fri-start').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-fri-end').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-sat-start').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-sat-end').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-sun-start').timepicker({
        timeFormat: "hh:mm tt"
    });
    $('#input-rest-hours-sun-end').timepicker({
        timeFormat: "hh:mm tt"
    });




    $('#input-rest-hours-mon-start').datetimepicker('setDate', ("2017 12 12 " + RestHours_MonStart ) );
    $('#input-rest-hours-mon-end').datetimepicker('setDate', ("2017 12 12 " + RestHours_MonEnd ) );
    $('#input-rest-hours-tue-start').datetimepicker('setDate', ("2017 12 12 " + RestHours_TueStart ) );
    $('#input-rest-hours-tue-end').datetimepicker('setDate', ("2017 12 12 " + RestHours_TueEnd ) );
    $('#input-rest-hours-wed-start').datetimepicker('setDate', ("2017 12 12 " + RestHours_WedStart ) );
    $('#input-rest-hours-wed-end').datetimepicker('setDate', ("2017 12 12 " + RestHours_WedEnd ) );
    $('#input-rest-hours-thu-start').datetimepicker('setDate', ("2017 12 12 " + RestHours_ThuStart ) );
    $('#input-rest-hours-thu-end').datetimepicker('setDate', ("2017 12 12 " + RestHours_ThuEnd ) );
    $('#input-rest-hours-fri-start').datetimepicker('setDate', ("2017 12 12 " + RestHours_FriStart ) );
    $('#input-rest-hours-fri-end').datetimepicker('setDate', ("2017 12 12 " + RestHours_FriEnd ) );
    $('#input-rest-hours-sat-start').datetimepicker('setDate', ("2017 12 12 " + RestHours_SatStart ) );
    $('#input-rest-hours-sat-end').datetimepicker('setDate', ("2017 12 12 " + RestHours_SatEnd ) );
    $('#input-rest-hours-sun-start').datetimepicker('setDate', ("2017 12 12 " + RestHours_SunStart ) );
    $('#input-rest-hours-sun-end').datetimepicker('setDate', ("2017 12 12 " + RestHours_SunEnd ) );

































</script>
</html>