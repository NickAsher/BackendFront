<html>
<head>
    <title>Analytics | Compare-Day</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../common/css/reset.css" >

    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-reboot.min.css" >


    <link rel="stylesheet" href="../../lib/jquery_ui/jquery-ui.css">
    <link rel="stylesheet" href="../../lib/jquery_ui/jquery-ui.structure.css">
    <link rel="stylesheet" href="../../lib/jquery_ui/jquery-ui.theme.css">


    <link rel="stylesheet" href="../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../lib/material_color/material-design-color-palette.css">

    <link rel="stylesheet" href="../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../common/css/default_style.css">
    <link rel="stylesheet" href="../common/css/my_general_classes.css">



    <script type="text/javascript" src="../../lib/chartlibrary/loader.js"></script>
<!--    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
    <script>google.charts.load('current', {'packages':['corechart','line', 'table']});</script>


    <?php
    require_once '../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/analytics_utils/data_analysis_fns/get_plot_compare_day.php' ;
    require_once 'controller/controller_compare_day.php' ;


    $DBConnectionTest = YOLOSqlDemoConnect() ;
    $DBConnectionBackend = YOLOSqlConnect() ;


    $Day1 = '' ;
    $Day2 = '' ;

    if( isset($_GET['day1'])  && isset($_GET['day2'])  ){
        $Day1 = $_GET['day1'] ;
        $Day2 = $_GET['day2'] ;

    } else {
        $Day1 = '2017-01-02' ;
        $Day2 = '2017-01-04' ;
    }

    $DailyStats1 = getDailyStats($DBConnectionTest, $Day1) ;
    $DailyStats2 = getDailyStats($DBConnectionTest, $Day2) ;


    ?>






</head>
<body>



<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12">

                <header>


                    <div id="header" class="navbar fixed-top navbar-toggleable-md" style="background-color: #222;">

                        <div>
                            <button type="button" class="btn btn-success t3-btn is-close">&#9776; open</button>
                        </div>


<!--                        <div class="navbar-space"></div>-->


                        <a class="navbar-brand text-white" href="#">Homeflavour Analytics</a>


<!--                        <div class="navbar-space"></div>-->

                        <div class="btn-group">
                            <button type="button" class="btn btn-default">Day1</button>
                            <input type="button" class="btn btn-info" id="datepicker_input1" value="<?php echo $Day1 ?>" >
                            <button type="button" class="btn btn-default" id="btn_CompareDatePicker_1" >Edit</button>
                        </div>

                        <div class="navbar-space"></div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default">Day2</button>
                            <input type="button" class="btn btn-info" id="datepicker_input2" value="<?php echo $Day2 ?>" >
                            <button type="button" class="btn btn-default" id="btn_CompareDatePicker_2" >Edit</button>
                        </div>


                        <div class="navbar-space"></div>
                        <button type="button" class="btn btn-primary" id="btn_Go_CompareDay"  >Go </button>


                        <div class="btn-group navbar-toggler-right" >
                            <button  class="btn btn-outline-secondary" href="#"><i class="fa fa-cog fa-spin fa-lg "></i></button>
                            <button  class="btn btn-default  mdc-text-black-darker" href="#">Settings</button>
                        </div>



                    </div>



                </header>


                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>







                <div id="DashboardDay_NumericalStats" class="row" >

                    <div class ="col-md-6">
                        <div class ="card w-90">
                            <div class="card-block">
                                <h3 class="card-title">Total Sale</h3>
                                <hr />
                                <div class="row">
                                    <div class="card-text text-center  col-md-6"><?php echo $Day1 ; ?> </div>
                                    <div class="card-text text-center  col-md-6"><?php echo $Day2 ; ?></div>
                                </div>
                                <hr />
                                <div class="row">

                                    <h3 class="card-title text-center col-md-6"><?php echo getControllerCompareDay_TotalSale($DailyStats1, $DailyStats2)[0] ; ?></h3>
                                    <h3 class="card-title text-center col-md-6"><?php echo getControllerCompareDay_TotalSale($DailyStats1, $DailyStats2)[1] ; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class ="col-md-6">
                        <div class ="card w-90">
                            <div class="card-block">
                                <h3 class="card-title">Total Orders</h3>
                                <hr />
                                <div class="row">
                                    <div class="card-text text-center  col-md-6"><?php echo $Day1 ; ?> </div>
                                    <div class="card-text text-center  col-md-6"><?php echo $Day2 ; ?></div>
                                </div>
                                <hr />
                                <div class="row">
                                    <h3 class="card-title text-center text-success col-md-6">214</h3>
                                    <h3 class="card-title text-center text-danger col-md-6">198</h3>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>




                <br><br>





                <div id="DashboardDay_MainChart1_Chart" class="card">
                    <div class="card-block">

                        <h3 class="ytext-heading">Order-Sale </h3>
                        <hr><br>

                        <div id = "main_chart_div"  style="height:400px;"></div>

                        <?php plotCompareDay_OrdersSale_LineChart($DBConnectionTest, $Day1, $Day2, "main_chart_div") ;
                        ?>

                    </div>

                </div>




                <br><br>









                <div id="DashboardDay_ItemStatChart" class="card">
                    <div class="card-block">

                        <h3 class="ytext-heading">Item stats</h3>
                        <hr><br>

                        <div id = "itemstats_chart_div"  style="height:400px;"></div>

                        <?php plotCompareDay_ItemStats_ColumnChart($DBConnectionBackend, $DBConnectionTest, $Day1, $Day2, "itemstats_chart_div") ;
                        ?>

                    </div>

                </div>










                <br><br>




                <div id="DashboardDay_CategoryStatChart" class="card" >
                    <div class="card-block">

                        <h3 class="ytext-heading">Category Stats</h3>
                        <hr><br>

                        <div id="categorystats_chart_div_col" class="row">

                            <div id = "categorystats_chart_div1"  class= "col-md-4" style="height:400px;"></div>
                            <div id = "categorystats_chart_div2"  class= "col-md-4" style="height:400px;"></div>
                            <div id = "categorystats_chart_div3"  class= "col-md-4" style="height:400px;"></div>


                        </div>

                        <?php
                        $ColorAra1 = getBlueColorArray() ;
                        $ColorAra2 = getRedColorArray() ;


                        plotCompareDay_CategoryStats_ColumnChart($DBConnectionTest, $Day1, $Day2, "categorystats_chart_div1") ;
                        plotCompareDay_CategoryStats_PieChart($DBConnectionTest, $Day1, $Day2, "categorystats_chart_div2",
                            "categorystats_chart_div3", $ColorAra1, $ColorAra2) ;

                        ?>


                    </div>

                </div>









                <br><br>




                <div id="DashboardDay_DetailedStats_NumericalStats" class="card">
                    <div class="card-block">


                        <h3 class="ytext-heading">Numerical Stats</h3>
                        <hr><br>

                        <div id = "numericalstats_chart_div"  style="height:400px;"></div>

                            <?php plotCompareDay_NumericalStats_TableChart($DBConnectionTest, $Day1, $Day2, "numericalstats_chart_div") ;
                            ?>

                        </div>
                    </div>


                <div id="space_before_header">
                    <br><br><br><br><br>
                </div>




                </div>
        </div>
    </div>
</section>






<div><?php require_once "includes/footer.php" ?></div>

</body>
<script type="text/javascript" src="../../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../../lib/jquery_ui/jquery-ui.js" ></script>

<script src="../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../lib/t3/t3.js"></script>


<script type="text/javascript" src="js/custom_datepicker.js"></script>
</html>
