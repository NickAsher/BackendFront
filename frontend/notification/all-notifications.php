<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-8">



    <link rel="stylesheet" href="../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-reboot.min.css" >

    <link rel="stylesheet" href="../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../common/css/classes.css">


    <link rel="stylesheet" href="css/default_style.css">



    <?php
    require_once '../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php'  ;

    $DBConnectionFCM = YOPDOSqlFCMConnect() ;


    ?>



</head>



<body>

<?php require_once "includes/header.php" ?>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12" style="background-color: #fff">

            <div id="space_below_header">
                <br><br><br><br><br>
            </div>






            <table  class="table table-bordered table-hover" >



                <!--                <thead class="thead-inverse">-->
                <tr class="table-info">
                    <th>Label</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Image</th>
                    <th>Expiry Time</th>
                    <th>Date / Time</th>
                    <th>Target</th>
                    <th>Target-Extra</th>
                    <th>Devices Reached</th>
                </tr>
                <!--                </thead>-->




                <?php

                $Query = "SELECT * FROM `notifications_table` ORDER BY `date` DESC, `time` DESC" ;
                $QueryResult = $DBConnectionFCM->query($Query) ;
                if($QueryResult){

                    foreach($QueryResult as $Record){
                        $NotificationLabel = $Record['label'] ;
                        $NotificationTitle = $Record['title'] ;
                        $NotificationMessage = $Record['message'] ;
                        $NotificationImage = $Record['image'] ;
                        $NotificationExpiryTime = $Record['expiry_time'] ;
                        $NotificationDate = $Record['date'] ;
                        $NotificationTime = $Record['time'] ;
                        $NotificationTarget = $Record['target'] ;
                        $NotificationTargetExtra = $Record['target_extra'] ;
                        $NotificationDevicesReached = $Record['devices_reached'] ;



                        echo "
                            <tr>
                                <td> $NotificationLabel </td>
                                <td> $NotificationTitle </td>
                                <td> $NotificationMessage </td>
                                <td> $NotificationImage </td>
                                <td> $NotificationExpiryTime </td>
                                <td> $NotificationDate <br> $NotificationTime </td>
                                <td> $NotificationTarget </td>
                                <td> $NotificationTargetExtra </td>
                                <td> $NotificationDevicesReached </td>
                            </tr>
                        " ;
                    }
                }


                ?>

            </table>






            <br><br>



            <div class="row">
                <div class="col-4"></div>
                <a href="legacy-send-new-notification.php" class="col-4 btn btn-outline-info" >
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
<script type="text/javascript" src="../../lib/t3/t3.js"></script>





</html>
