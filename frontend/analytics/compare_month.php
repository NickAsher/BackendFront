<html>
<head>
    <title>Analytics | Compare-Month</title>
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
    require_once $ROOT_FOLDER_PATH.'/utils/analytics_utils/data_analysis_fns/get_plot_compare_month.php' ;


    require_once 'controller/controller_compare_month.php' ;


    $DBConnectionTest = YOLOSqlDemoConnect() ;
    $DBConnectionBackend = YOLOSqlConnect() ;
    $Month1 = '';
    $Year1 = '' ;
    $Month2 = '';
    $Year2 = '' ;





    if( isset($_GET['month1'])  && isset($_GET['month2'])  ){

        $Month_v1 = $_GET['month1'] ;
        $Month_v1 = explode("-", $Month_v1) ;
        $Year1 = $Month_v1[0] ;
        $Month1 = $Month_v1[1] ;

        $Month_v2 = $_GET['month2'] ;
        $Month_v2 = explode("-", $Month_v2) ;
        $Year2 = $Month_v2[0] ;
        $Month2 = $Month_v2[1] ;



    } else {
        $Month1 = '10';
        $Year1 = '2017' ;
        $Month2 = '11';
        $Year2 = '2017' ;
    }




    $MonthlyStats1 = getMonthlyStats($DBConnectionTest, $Month1, $Year1) ;
    $MonthlyStats2 = getMonthlyStats($DBConnectionTest, $Month2, $Year2) ;



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
                            <button type="button" class="btn btn-default">Month1</button>
                            <input type="button" class="btn btn-info" id="monthpicker_input1" value="<?php echo "$Year1-$Month1" ; ?>" />
                            <button type="button" class="btn btn-default" id="btn_CompareMonthPicker_1">Edit</button>
                        </div>

                        <div class="navbar-space"></div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default">Month2</button>
                            <input type="button" class="btn btn-info" id="monthpicker_input2" value="<?php echo "$Year2-$Month2" ; ?>" />
                            <button type="button" class="btn btn-default" id="btn_CompareMonthPicker_2">Edit</button>
                        </div>


                        <div class="navbar-space"></div>
                        <button type="button" class="btn btn-primary" id="btn_Go_CompareMonth"  >Go </button>


                        <div class="btn-group navbar-toggler-right" >
                            <button  class="btn btn-outline-secondary" href="#"><i class="fa fa-cog fa-spin fa-lg "></i></button>
                            <button  class="btn btn-default  mdc-text-black-darker" href="#">Settings</button>
                        </div>



                    </div>



                </header>


                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>





                <div id="DashboardCompareMonth_NumericalStats" class="row" >

                    <div class ="col-md-6">
                        <div class ="card w-90">
                            <div class="card-block">
                                <h3 class="card-title">Total Sale</h3>
                                <hr />
                                <div class="row">
                                    <div class="card-text text-center  col-md-6"><?php echo "$Month1, $Year1" ; ?> </div>
                                    <div class="card-text text-center  col-md-6"><?php echo "$Month2, $Year2" ; ?></div>
                                </div>
                                <hr />
                                <div class="row">

                                    <h3 class="card-title text-center col-md-6"><?php echo getControllerCompareMonth_TotalSale($MonthlyStats1, $MonthlyStats2)[0] ; ?></h3>
                                    <h3 class="card-title text-center col-md-6"><?php echo getControllerCompareMonth_TotalSale($MonthlyStats1, $MonthlyStats2)[1] ; ?></h3>
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
                                    <div class="card-text text-center  col-md-6"><?php echo "$Month1, $Year1" ; ?> </div>
                                    <div class="card-text text-center  col-md-6"><?php echo "$Month2, $Year2" ; ?></div>
                                </div>
                                <hr />
                                <div class="row">
                                    <h3 class="card-title text-center text-success col-md-6"><?php echo getControllerCompareMonth_TotalOrders($MonthlyStats1, $MonthlyStats2)[0] ; ?></h3>
                                    <h3 class="card-title text-center text-danger col-md-6"><?php echo getControllerCompareMonth_TotalOrders($MonthlyStats1, $MonthlyStats2)[1] ; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>




                <br><br>







                <div id="DashboardCompareMonth_MainChart1" class="card">

                    <div id = 'DashboardCompareMonth_MainChart1_Navigation' class = "card-header">


                        <h3 class="ytext-heading">Quick Charts</h3>
                        <hr>


                        <ul  class="nav nav-tabs card-header-tabs nav-tabs-lightblue ">

                            <li class="nav-item">
                                <a id="CompareMonth_MainChart_TotalSale_Day" class="nav-link chart-item-main " href="#" >Total Sale  Per Day</a>
                            </li>
                            <li class="nav-item">
                                <a id="CompareMonth_MainChart_TotalOrder_Day" class="nav-link chart-item-main" href="#">Total Orders Per Day</a>
                            </li>
                            <li class="nav-item">
                                <a id="CompareMonth_MainChart_TotalItemQt_Day" class="nav-link chart-item-main" href="#">Total Item Quantity Sold Per Day</a>
                            </li>

                        </ul>
                    </div>


                    <div id = "DashboardCompareMonth_MainChart1_Chart" class="card-block">
                        <div id = "main_chart_div"  style="height:400px"></div>
                    </div>



                </div>




                <br><br>









                <div id="DashboardCompareMonth_ItemStatChart" class="card">
                    <div class="card-block">

                        <h3 class="ytext-heading">Item stats</h3>
                        <hr><br>

                        <div id = "itemstats_chart_div"  style="height:400px;"></div>

                        <?php plotCompareMonths_ItemStats_ColumnChart($DBConnectionBackend, $DBConnectionTest, $Month1, $Year1, $Month2, $Year2, "itemstats_chart_div") ;
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

                        plotCompareMonths_CategoryStats_ColumnChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, "categorystats_chart_div1") ;
                        plotCompareMonths_CategoryStats_PieChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, "categorystats_chart_div2",
                            "categorystats_chart_div3", $ColorAra1, $ColorAra2) ;


                        ?>


                    </div>

                </div>









                <br><br>




                <div id="DashboardDay_DetailedNumericalStats" class="card">
                    <div class="card-block">


                        <h3 class="ytext-heading">Detailed Stats</h3>
                        <hr><br>

                        <div id = "numericalstats_chart_div"  style="height:400px;"></div>

                        <?php plotCompareMonth_NumericalStats_TableChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, "numericalstats_chart_div") ;
                        ?>

                    </div>
                </div>




                <br><br><br>


                <div id="DashboardCompareMonth_DetailedCharts" class="card" >

                    <div id="DashboardCompareMonth_DetailedCharts_Navigation" class="card-header">

                        <h3 class="ytext-heading"> Detailed Charts</h3>
                        <hr>

                        <ul  class="nav nav-pills card-header-pills nav-tabs-lightblue justify-content-center">

                            <li class="nav-item dropdown">
                                <a id="yolo1" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" >Total Sale</a>
                                <div class="dropdown-menu ">
                                    <a id="CompareMonth_DetailChart_TotalSale_Day" class="dropdown-item chart-item-detail" href="#">Total Sale Per Day</a>
                                    <a id="CompareMonth_DetailChart_AverageOrderPrice_Day" class="dropdown-item chart-item-detail" href="#">Average OrderPrice  Per Day</a>
                                    <a id="CompareMonth_DetailChart_MaxOrderPrice_Day" class="dropdown-item chart-item-detail" href="#">Max  OrderPrice Per Month </a>

                                </div>

                            </li>

                            <li class="nav-item dropdown">
                                <a id="yolo2" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">Total Orders</a>
                                <div class="dropdown-menu">
                                    <a id="CompareMonth_DetailChart_TotalOrder_Day" class="dropdown-item chart-item-detail" href="#">Total Orders Per Day</a>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="yolo3" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">Total Item Quantity Sold</a>
                                <div class="dropdown-menu">
                                    <a id="CompareMonth_DetailChart_TotalItemQt_Day" class="dropdown-item chart-item-detail" href="#">Total Items sold Per Day</a>
                                    <a id="CompareMonth_DetailChart_AverageItemQtPerOrder_Day" class="dropdown-item chart-item-detail" href="#">Average ItemQuantity per Order Per Day</a>
                                    <a id="CompareMonth_DetailChart_MaxItemQtPerOrder_Day" class="dropdown-item chart-item-detail" href="#">Maximum ItemQuantity per Order Per Day</a>

                                </div>
                            </li>

                        </ul>
                    </div>

                    <div id="DashboardCompareMonth_DetailedCharts_Chart" class="card-block">
                        <div id="detail_chart_div" style="height: 600px;" ></div>
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

<script type="text/javascript">
    var YOLO_GLOBAL_MONTH1 = <?php echo "'$Month1'" ; ?> ;
    var YOLO_GLOBAL_YEAR1 = <?php echo "'$Year1'" ; ?> ;
    var YOLO_GLOBAL_MONTH2 = <?php echo "'$Month2'" ; ?> ;
    var YOLO_GLOBAL_YEAR2 = <?php echo "'$Year2'" ; ?> ;

</script>

<script type="text/javascript" src="js/compare_month_charts_ajax.js" ></script>
</html>
