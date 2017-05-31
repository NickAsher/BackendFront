<?php

?>
<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-16">
<!--    <link rel="stylesheet" href="../../../lib/reset/reset.css" >-->

    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap_addon.css" >



    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />


    <link rel="stylesheet" href="../../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../../common/css/classes.css">


    <link rel="stylesheet" href="../../common/css/default_style.css">


    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;

    $DBConnectionBackend = YOLOSqlConnect() ;


    $Query = "SELECT * FROM `info_about_table` WHERE `restaurant_id` = '1' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;

    $TempArray = '' ;
    if($QueryResult) {
        foreach($QueryResult as $Record){
            $TempArray = $Record ;
        }
    } else {
        echo "Error in getting the variables <br> ".mysqli_error($DBConnectionBackend) ;
    }





    $AboutUs1 = $TempArray['about_us1'] ;
    $AboutUs2 = $TempArray['about_us2'] ;
    $AboutUsImage = $TempArray['about_us_image'] ;








    ?>


</head>
<body>

<div><?php require_once "../includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12 bg-whitegrey">




                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>



                <div class="row">
                    <div class = col-md-1></div>
                    <div id="Section_AddNewItemForm" class="col-md-10" >


                        <div class="card">
                            <div class="card-header">
                                <h3 class="ytext-heading">About Us Info</h3>
                            </div>
                            <div class="card-block">

                                <br><br>
                                <div>
                                    <label for="input-para1" class="col-3 col-form-label">About Us-Image 1 : </label>
                                    <div class="form-control">
                                        <div class="row">
                                            <div class="col-3"></div>
                                            <div class="col-6 text-center">
                                                <img src='<?php echo "$IMAGE_FOLDER_LINK_PATH/$AboutUsImage" ; ?>' alt='<?php echo "$IMAGE_FOLDER_LINK_PATH/$AboutUsImage" ; ?>' class="img-fluid">
                                            </div>
                                            <div class="col-3"></div>
                                        </div>
                                    </div>
                                </div>


                                <br><br>

                                <div id="Div_BlogContent">
                                    <label for="input-blog-description" class="col-form-label">About Us Description :</label>
                                    <div>
                                        <div class="form-control bg-faded"><?php echo $AboutUs1; ?></div>
                                    </div>
                                </div>




                                <br><br>
                            </div>
                        </div>












                        <br><br<br><br>



                        <div class="form-group row">
                            <div class="col-4" ></div>
                            <a class=" col-4 btn btn-outline-info" href="edit_about_us.php" > Edit </a>
                            <div class="col-4" ></div>
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
<script type="text/javascript"  src="../../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
</html>