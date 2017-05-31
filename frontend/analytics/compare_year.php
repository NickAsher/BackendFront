<html>
<head>
    <title>Analytics | Compare-Year</title>
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
    require_once $ROOT_FOLDER_PATH.'/utils/analytics_utils/data_analysis_fns/get_plot_compare_year.php' ;

    require_once 'controller/controller_compare_year.php' ;


    $DBConnectionTest = YOLOSqlDemoConnect() ;
    $DBConnectionBackend = YOLOSqlConnect() ;



    $Year1 = '' ;
    $Year2 = '' ;

    if( isset($_GET['year1'])  && isset($_GET['year2'])  ){
        $Year1 = $_GET['year1'] ;
        $Year2 = $_GET['year2'] ;

    } else {
        $Year1 = '2017' ;
        $Year2 = '2017' ;
    }


    $YearlyStats1 = getYearlyStats($DBConnectionTest, $Year1) ;
    $YearlyStats2 = getYearlyStats($DBConnectionTest, $Year2) ;



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


<!--                            <div class="navbar-space"></div>-->

                            <a class="navbar-brand text-white" href="#">Homeflavour Analytics</a>


<!--                            <div class="navbar-space"></div>-->

                            <div class="btn-group">
                                <button type="button" class="btn btn-default">Year1</button>
                                <input type="button" class="btn btn-info" id="yearpicker_input1" value="<?php echo $Year1 ?>" >
                                <button type="button" class="btn btn-default" id="btn_CompareYearPicker_1" >Edit</button>
                            </div>

                            <div class="navbar-space"></div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-default">Year2</button>
                                <input type="button" class="btn btn-info" id="yearpicker_input2" value="<?php echo $Year2 ?>" >
                                <button type="button" class="btn btn-default" id="btn_CompareYearPicker_2" >Edit</button>
                            </div>

                            <div class="navbar-space"></div>
                            <button type="button" class="btn btn-info" id="btn_Go_CompareYear"  >Go </button>


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
                                    <div class="card-text text-center  col-md-6"><?php echo "$Year1" ; ?> </div>
                                    <div class="card-text text-center  col-md-6"><?php echo "$Year2" ; ?></div>
                                </div>
                                <hr />
                                <div class="row">

                                    <h3 class="card-title text-center col-md-6"><?php echo getControllerCompareYear_TotalSale($YearlyStats1, $YearlyStats2)[0] ; ?></h3>
                                    <h3 class="card-title text-center col-md-6"><?php echo getControllerCompareYear_TotalSale($YearlyStats1, $YearlyStats2)[1] ; ?></h3>
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
                                    <div class="card-text text-center  col-md-6"><?php echo "$Year1" ; ?> </div>
                                    <div class="card-text text-center  col-md-6"><?php echo "$Year2" ; ?></div>
                                    <script>
                                        console.log("year1 is " + '<?php echo "$Year1" ; ?>' + "year2 is " + '<?php echo "$Year2" ; ?>' ) ;
                                    </script>
                                </div>
                                <hr />
                                <div class="row">
                                    <h3 class="card-title text-center text-success col-md-6"><?php echo getControllerCompareYear_TotalOrders($YearlyStats1, $YearlyStats2)[0] ; ?></h3>
                                    <h3 class="card-title text-center text-danger col-md-6"><?php echo getControllerCompareYear_TotalOrders($YearlyStats1, $YearlyStats2)[1] ; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>




                <br><br>





                <div id="DashboardCompareYear_MainChart1" class="card">

                    <div id = 'DashboardCompareYear_MainChart1_Navigation' class = "card-header">


                        <h3 class="ytext-heading">Quick Charts</h3>
                        <hr>


                        <ul  class="nav nav-tabs card-header-tabs nav-tabs-lightblue ">

                            <li class="nav-item">
                                <a id="CompareYear_MainChart_TotalSale_Day" class="nav-link chart-item-main " href="#" >Total Sale  Per Day</a>
                            </li>
                            <li class="nav-item">
                                <a id="CompareYear_MainChart_TotalOrder_Day" class="nav-link chart-item-main" href="#">Total Orders Per Day</a>
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

                        <?php plotCompareYear_ItemStats_ColumnChart($DBConnectionBackend, $DBConnectionTest, $Year1, $Year2, "itemstats_chart_div") ;
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

                        plotCompareYear_CategoryStats_ColumnPieChart($DBConnectionTest, $Year1, $Year2,
                            "categorystats_chart_div1", "categorystats_chart_div2", "categorystats_chart_div3", $ColorAra1, $ColorAra2) ;
    //


                        ?>


                    </div>

                </div>









                <br><br>






                <div id="DashboardDay_DetailedStats_NumericalStats" class="card">
                    <div class="card-block">


                        <h3 class="ytext-heading">Category Stats</h3>
                        <hr><br>

                        <div id = "numericalstats_chart_div"  style="height:400px;"></div>

                        <?php plotCompareYear_NumericalStats_TableChart($DBConnectionTest, $Year1, $Year2, "numericalstats_chart_div") ;
                        ?>

                    </div>
                </div>








                <br><br><br>









                <div id="DashboardCompareYear_DetailedCharts" class="card" >

                    <div id="DashboardCompareYear_DetailedCharts_Navigation" class="card-header">

                        <h3 class="ytext-heading"> Detailed Item Stats</h3>
                        <hr>

                        <ul  class="nav nav-pills card-header-pills  justify-content-center nav-pills-lightblue">

                            <li class="nav-item dropdown">
                                <a id="yolo1" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" >Total Sale</a>
                                <div class="dropdown-menu ">
                                    <a id="CompareYear_DetailChart_TotalSale_Month" class="dropdown-item chart-item-detail" href="#">Total Sale Per Month</a>
                                    <a id="CompareYear_DetailChart_TotalSale_Day" class="dropdown-item chart-item-detail" href="#">Total Sale Per Day</a>

                                    <a id="CompareYear_DetailChart_AverageDailySale_Month" class="dropdown-item chart-item-detail" href="#">Average DailySale Per Month </a>
                                    <a id="CompareYear_DetailChart_AverageOrderPrice_Month" class="dropdown-item chart-item-detail" href="#">Average OrderPrice Per Month </a>
                                    <a id="CompareYear_DetailChart_AverageOrderPrice_Day" class="dropdown-item chart-item-detail" href="#">Average OrderPrice Per Day </a>

                                    <a id="yo" class="dropdown-item chart-item" href="#">__Maximum/Minimum OrderPrice Per Month </a>
                                    <a id="CompareYear_DetailChart_MaxOrderPrice_Day" class="dropdown-item chart-item-detail" href="#">__Maximum/Minimum OrderPrice Per Day </a>
                                </div>

                            </li>

                            <li class="nav-item dropdown">
                                <a id="yolo2" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">Total Orders</a>
                                <div class="dropdown-menu">
                                    <a id="CompareYear_DetailChart_TotalOrder_Month" class="dropdown-item chart-item-detail" href="#">Total Orders Per Month</a>
                                    <a id="CompareYear_DetailChart_TotalOrder_Day" class="dropdown-item chart-item-detail" href="#">Total Orders Per Day</a>
                                    <a id="CompareYear_DetailChart_AverageNoOrdersPerDay_Month" class="dropdown-item chart-item-detail" href="#">Average No. Of Daily Orders Per Month</a>



                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="yolo3" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">Total Item Quantity Sold</a>
                                <div class="dropdown-menu">
                                    <a id="CompareYear_DetailChart_TotalItemQt_Month" class="dropdown-item chart-item-detail" href="#">Total Items sold Per Month</a>
                                    <a id="CompareYear_DetailChart_TotalItemQt_Day" class="dropdown-item chart-item-detail" href="#">Total Items sold Per Day</a>

                                    <a id="CompareYear_DetailChart_AverageDailyItemQt_Month" class="dropdown-item chart-item-detail" href="#">Average Item Qunatity sold in a day Per Month </a>
                                    <a id="CompareYear_DetailChart_AverageItemQtPerOrder_Month" class="dropdown-item chart-item-detail" href="#">Average OrderPrice Per Month </a>
                                    <a id="CompareYear_DetailChart_AverageItemQtPerOrder_Day" class="dropdown-item chart-item-detail" href="#">Average OrderPrice Per Day </a>

                                    <a id="CompareYear_DetailChart_MaxMinItemQtPerOrder_Month" class="dropdown-item chart-item-detail" href="#">Maximum/Minimum OrderPrice Per Month </a>
                                    <a id="CompareYear_DetailChart_MaxMinItemQtPerOrder_Day" class="dropdown-item chart-item-detail" href="#">Maximum/Minimum items sold per order Per Day </a>
                                </div>
                            </li>

                        </ul>
                    </div>

                    <div id="DashboardYear_DetailedCharts_Chart" class="card-block">
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
    var YOLO_GLOBAL_YEAR1 = <?php echo "'$Year1'" ; ?> ;
    var YOLO_GLOBAL_YEAR2 = <?php echo "'$Year2'" ; ?> ;
</script>

<script type="text/javascript" src="js/compare_year_charts_ajax.js" ></script>
</html>
