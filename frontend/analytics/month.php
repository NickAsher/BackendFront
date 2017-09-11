<html>
<head>
    <title>Analytics | Month</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../common/css/reset.css" >

    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-reboot.min.css" >

    <link rel="stylesheet" href="../../lib/jquery_ui/jquery-ui.css">
    <link rel="stylesheet" href="../../lib/jquery_ui/jquery-ui.structure.css">
    <link rel="stylesheet" href="../../lib/jquery_ui/jquery-ui.theme.css">


    <link rel="stylesheet" href="../../lib/font-awesome/css/font-awesome.css" >


    <link rel="stylesheet" href="../../lib/t3/t3.css" />



    <link rel="stylesheet" href="../common/css/default_style.css">
    <link rel="stylesheet" href="../common/css/my_general_classes.css">



    <script type="text/javascript" src="../../lib/chartlibrary/loader.js"></script>
    <script>google.charts.load('current', {'packages':['corechart']});</script>


    <?php

    require_once '../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/analytics_utils/data_analysis_fns/get_plot_monthly.php' ;

    $DBConnectionTest = YOLOSqlDemoConnect() ;
    $DBConnectionBackend = YOLOSqlConnect() ;


    $Month = '' ;
    $Year = '' ;

    if( isset($_GET['month'])  ){
        $Month_v = $_GET['month'] ;
        $Month_v = explode("-", $Month_v) ;
        $Year = $Month_v[0] ;
        $Month = $Month_v[1] ;

    } else {
        $Month = '01' ;
        $Year = '2017' ;
    }


    $MonthlyStats = getMonthlyStats($DBConnectionTest, $Month, $Year) ;


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


                        <div class="navbar-space"></div>

                        <a class="navbar-brand text-white" href="#">Homeflavour Analytics</a>

                        <div class="navbar-space"></div>


                        <div class="btn-group">
                            <button type="button" class="btn btn-info">Month</button>
                            <button id="typepicker_btn" type="button" class="btn btn-default">Edit</button>
                        </div>

                        <div class="navbar-space"></div>

                        <div class="btn-group">
                            <input type="button" class="btn btn-info monthpicker_input" value="<?php echo "$Year-$Month" ; ?>" />
                            <button type="button" class="btn btn-default" id="monthpicker_btn">Edit</button>
                        </div>

                        <div class="navbar-space"></div>



                        <div class="btn-group navbar-toggler-right" >

                            <button  class="btn btn-outline-secondary" href="#"><i class="fa fa-cog fa-spin fa-lg "></i></button>

                            <button  class="btn btn-default  mdc-text-black-darker" href="#">Settings</button>

                        </div>



                    </div>



                </header>



                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>




                <div id="DashboardMonth_NumericalStats" class="row" >

                    <div class ="col-md-4">
                        <div class ="card w-90">
                            <div class="card-block">
                                <div class="card-text">Total Sale</div>
                                <hr />
                                <h2 class="card-title text-center text-success"><?php echo "$".number_format($MonthlyStats['total_sale']) ; ?></h2>
                            </div>
                        </div>
                    </div>


                    <div class ="col-md-4">
                        <div class ="card w-90">
                            <div class="card-block">
                                <div class="card-text">Total Orders</div>
                                <hr />
                                <h2 class="card-title text-center text-info"><?php echo number_format($MonthlyStats['total_orders']) ; ?></h2>
                            </div>
                        </div>
                    </div>



                    <div class ="col-md-4">
                        <div class ="card w-90">
                            <div class="card-block">
                                <div class="card-text">Total Items Sold</div>
                                <hr />
                                <h2 class="card-title text-center text-danger"><?php echo number_format($MonthlyStats['total_itemqt']) ; ?></h2>

                            </div>
                        </div>
                    </div>



                </div>




                <br><br>





                <div id="DashboardMonth_MainChart1" class="card">

                    <div id = 'DashboardMonth_MainChart1_Navigation' class = "card-header">


                        <h3 class="ytext-heading">Quick Stats</h3>
                        <hr>


                        <ul  class="nav nav-tabs card-header-tabs nav-tabs-lightblue ">

                            <li class="nav-item">
                                <a id="Month_MainChart_TotalSale_Day" class="nav-link chart-item-main " href="#" >Total Sale  Per Day</a>
                            </li>
                            <li class="nav-item">
                                <a id="Month_MainChart_TotalOrder_Day" class="nav-link chart-item-main" href="#">Total Orders Per Day</a>
                            </li>
                            <li class="nav-item">
                                <a id="Month_MainChart_TotalItemQt_Day" class="nav-link chart-item-main" href="#">Total Item Quantity Sold Per Day</a>
                            </li>

                        </ul>
                    </div>


                    <div id = "DashboardMonth_MainChart1_Chart" class="card-block">
                        <div id = "main_chart_div"  style="height:400px"></div>
                    </div>



                </div>







                <br><br>






                <div id = "DashboardMonth_ItemCategoryStats" class="row">

                    <div id="DashboardMonth_CategoryStats" class="col-md-6">
                        <div class="card w-90">
                            <div class="card-block">


                                <h3 class="ytext-heading">Category Stats</h3>
                                <hr>

                                <div id="DashboardMonth_CategoryStats_Navigation" >
                                    <ul  class="nav nav-pills  justify-content-center nav-pills-lightblue ">

                                        <li class="nav-item">
                                            <a id="Month_CategoryStatChart_ColumnChart" class="nav-link chart-item-categorystats " href="#" >Column</a>
                                        </li>
                                        <li class="nav-item">
                                            <a id="Month_CategoryStatChart_PieChart" class="nav-link chart-item-categorystats" href="#">Pie</a>
                                        </li>


                                    </ul>
                                </div>
                                <br>


                                <div id="categorystats_chart_div" style="height: 350px;"></div>



                            </div>
                        </div>
                    </div>




                    <div id="DashboardMonth_ItemStats" class="col-md-6">
                        <div class="card w-90" >
                            <div class="card-block" >

                                <h3 class="ytext-heading">Item Stats</h3>
                                <hr>

                                <div id="DashboardMonth_ItemStats_Navigation" >
                                    <ul  class="nav nav-pills justify-content-center nav-pills-lightblue">

                                        <li class="nav-item">
                                            <a id="Month_ItemStatChart_ColumnChart" class="nav-link chart-item-itemstats " href="#" >Column</a>
                                        </li>
                                        <li class="nav-item">
                                            <a id="Month_ItemStatChart_PieChart" class="nav-link chart-item-itemstats" href="#">Pie</a>
                                        </li>


                                    </ul>
                                </div>
                                <br>


                                <div id="itemstats_chart_div"  style="height: 350px;"></div>



                            </div>
                        </div>
                    </div>



                </div>







                <br><br>






                <div id="DashboardMonth_DetailedStats_NumericalStats" class="card" >

                    <div class=" card-block">

                        <h3 class="ytext-heading"> Detailed Item Stats</h3>
                        <hr>

                        <div class="card-deck">



                            <div class ="col-md-4">
                                <div class ="card card-inverse card-danger">
                                    <div class="card-block">
                                        <h2 class="card-title">693,473</h2>
                                        <div class="card-text">Total Sale</div>
                                        <hr />
                                        <h2 class="card-title">23,115</h2>
                                        <div class="card-text">Average Sale per Day </div>
                                        <hr />
                                        <h2 class="card-title">750</h2>
                                        <div class="card-text">Average OrderPrice per Order </div>
                                        <hr />
                                        <h2 class="card-title">100,000</h2>
                                        <h5 class="card-text">31 December </h5>
                                        <div class="card-text">Max Sale For a Day </div>
                                        <hr />
                                        <h2 class="card-title">2,000</h2>
                                        <h5 class="card-text">25 December </h5>
                                        <div class="card-text">Max OrderPrice For an Order </div>
                                    </div>
                                </div>
                            </div>


                            <div class ="col-md-4">
                                <div class ="card card-inverse card-info">
                                    <div class="card-block">
                                        <h2 class="card-title">3500</h2>
                                        <div class="card-text">Total Orders</div>
                                        <hr />
                                        <h2 class="card-title">115</h2>
                                        <div class="card-text">Average Orders per Day </div>
                                        <hr />
                                        <h2 class="card-title">250</h2>
                                        <h5 class="card-text">30 December </h5>
                                        <div class="card-text">Max Orders For a Day </div>
                                        <hr />
                                        <h2 class="card-title"> </h2>
                                        <br><br><br><br><br><br>
                                        <br><br>
                                    </div>
                                </div>
                            </div>


                            <div class ="col-md-4">
                                <div class ="card card-inverse card-success">
                                    <div class="card-block">
                                        <h2 class="card-title">75,000</h2>
                                        <div class="card-text">Total Items Sold</div>
                                        <hr />
                                        <h2 class="card-title">250</h2>
                                        <div class="card-text">Average No. of Items sold per Day </div>
                                        <hr />
                                        <h2 class="card-title">4</h2>
                                        <div class="card-text">Average No. of Items sold in One Order </div>
                                        <hr />
                                        <h2 class="card-title">540</h2>
                                        <h5 class="card-text">30 December </h5>
                                        <div class="card-text">Max Items sold in a Day</div>
                                        <hr />
                                        <h2 class="card-title">15</h2>
                                        <h5 class="card-text">25 December </h5>
                                        <div class="card-text">Max Items sold in a single Order </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                </div>






                <br><br>






                <div id="DashboardYear_DetailedCharts" class="card" >

                    <div id="DashboardYear_DetailedCharts_Navigation" class="card-header">

                        <h3 class="ytext-heading"> Detailed Item Stats</h3>
                        <hr>

                        <ul  class="nav nav-pills card-header-pills nav-tabs-lightblue justify-content-center">

                            <li class="nav-item dropdown">
                                <a id="yolo1" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" >Total Sale</a>
                                <div class="dropdown-menu ">
                                    <a id="Month_DetailChart_TotalSale_Day" class="dropdown-item chart-item-detail" href="#">Total Sale Per Day</a>
                                    <a id="Month_DetailChart_AverageOrderPrice_Day" class="dropdown-item chart-item-detail" href="#">Average OrderPrice  Per Day</a>
                                    <a id="Month_DetailChart_MaxMinOrderPrice_Day" class="dropdown-item chart-item-detail" href="#">Max/Min  OrderPrice Per Month </a>

                                </div>

                            </li>

                            <li class="nav-item dropdown">
                                <a id="yolo2" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">Total Orders</a>
                                <div class="dropdown-menu">
                                    <a id="Month_DetailChart_TotalOrder_Day" class="dropdown-item chart-item-detail" href="#">Total Orders Per Day</a>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="yolo3" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">Total Item Quantity Sold</a>
                                <div class="dropdown-menu">
                                    <a id="Month_DetailChart_TotalItemQt_Day" class="dropdown-item chart-item-detail" href="#">Total Items sold Per Day</a>
                                    <a id="Month_DetailChart_AverageItemQtPerOrder_Day" class="dropdown-item chart-item-detail" href="#">Average ItemQuantity per Order Per Day</a>
                                    <a id="Month_DetailChart_MaxMinItemQtPerOrder_Day" class="dropdown-item chart-item-detail" href="#">Maximum/Minimum ItemQuantity per Order Per Day</a>

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


<script type="text/javascript">
    var YOLO_GLOBAL_MONTH = <?php echo $Month ; ?> ;
    var YOLO_GLOBAL_YEAR = <?php echo $Year  ; ?> ;
</script>






<script type="text/javascript" src="js/month_charts_ajax.js" ></script>

<script type="text/javascript" src="js/custom_datepicker.js"></script>

</html>
