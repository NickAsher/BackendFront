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

    <link rel="stylesheet" href="../../lib/t3/t3.css" />




    <?php
    require_once '../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once 'start_stop_utils.php' ;


    $DBConnectionBackend = YOLOSqlConnect() ;
    $IsStart = SS_isStart($DBConnectionBackend) ;




    ?>



</head>



<body>
<?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/header.php'; ?>


<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12 bg-white">




                <div id="space_below_Header">
                    <br><br><br>
                </div>

                <h1 class="text-center">Start-up Screen</h1>
                <br><br>


                <div id="Div_TurnOnOff">
                <?php
                if($IsStart == true){

                    $AllOrdersAreCompleteCancelled = SS_AreAllOrdersCompleted($DBConnectionBackend) ;
                    if($AllOrdersAreCompleteCancelled){

                        echo "
                            <center>
                                <div>
                                    <h1> Restaurant is on</h1>
                                    <form method='post' action='confirm-stop.php'>
                                        <input type='hidden' name='__make_stop' value='1' >
                                        <button type='submit' class='btn btn-info'>Turn off</button>
                                    </form>
                                </div>
                            </center>
                        " ;

                    } else {
                        echo "
                            <center>
                            <div>
                                <h1> Restaurant is on </h1>
                                <h6>Can't be turned off untill all pending and working orders are either completed or cancelled, refresh the page and try again later</h6>
                                    <button type='button' class='btn btn-lg btn-default' disabled>Turn off</button>
                                
                            </div>
                            </center>
                        " ;
                    }



                } else if($IsStart == false){
                    // This is the case where the restaurant is turned off . So we have to start it
                    echo "
                        <center>
                            <div>
                                <h1> Restaurant is off</h1>
                                <form method='post' action='confirm-start.php'>
                                    <input type='hidden' name='__make_start' value='1' >
                                    <button type='submit' class='btn btn-lg btn-info'>Turn On</button>
                                </form>
                            </div>
                        </center>
                    " ;
                }


                ?>
                </div>

                <br><br><br>
                <div id="Div_SaveData">

                </div>



















                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>




            </div>
        </div>
    </div>
</section>



<!--<div>--><?php //require_once "../../common/includes/footer.php" ?><!--</div>-->


</body>
<script type="text/javascript"  src="../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../lib/t3/t3.js"></script>
</html>