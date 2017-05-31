<html>
<head>
    <title>Analytics | Year</title>
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
    require_once $ROOT_FOLDER_PATH.'/utils/analytics_utils/data_analysis_fns/get_plot_yearly.php' ;

    $DBConnectionTest = YOLOSqlDemoConnect() ;
    $DBConnectionBackend = YOLOSqlConnect() ;


    $Year = "" ;
    if(isset($_GET['year'])){
        $Year = $_GET['year'] ;
    } else{
        $Year = '2017' ;
    }

    $YearlyStats = getYearlyStats($DBConnectionTest, $Year) ;



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
                            <button type="button" class="btn btn-info">Year</button>
                            <button id="typepicker_btn" type="button" class="btn btn-default">Edit</button>
                        </div>

                        <div class="navbar-space"></div>

                        <div class="btn-group">
                            <input  type="button" class="btn btn-info yearpicker_input" value="<?php echo $Year ?>" >
                            <button id="yearpicker_btn" type="button" class="btn btn-default">Edit</button>

                        </div>

                        <div class="navbar-space"></div>



                        <div class="btn-group" >

                            <button  class="btn btn-outline-secondary" href="#"><i class="fa fa-cog fa-spin fa-lg "></i></button>

                            <button  class="btn btn-default  mdc-text-black-darker" href="#">Settings</button>

                        </div>



                    </div>



                </header>




                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>




                <div id="DashBoardYear_NumericalStats" class="row" >

                    <div class ="col-md-4">
                        <div class ="card w-90">
                            <div class="card-block">
                                <div class="card-text">Total Sale</div>
                                <hr />
                                <h2 class="card-title text-center text-success"><?php echo "$ ".number_format($YearlyStats['total_sale']) ; ?></h2>
                            </div>
                        </div>
                    </div>


                    <div class ="col-md-4">
                        <div class ="card w-90">
                            <div class="card-block">
                                <div class="card-text">Total Orders</div>
                                <hr />
                                <h2 class="card-title text-center text-info"><?php echo number_format($YearlyStats['total_orders']) ; ?></h2>
                            </div>
                        </div>
                    </div>



                    <div class ="col-md-4">
                        <div class ="card w-90">
                            <div class="card-block">
                                <div class="card-text">Total Items Sold</div>
                                <hr />
                                <h2 class="card-title text-center text-danger"><?php echo number_format($YearlyStats['total_item_quantity']) ; ?></h2>

                            </div>
                        </div>
                    </div>



                </div>




                <br><br>





                <div id="DashboardYear_MainChart1" class="card" >

                    <div id = 'DashboardYear_MainChart1_Navigation' class = "card-header">


                        <h3 class="ytext-heading">Quick Stats</h3>
                        <hr>


                        <ul  class="nav nav-tabs card-header-tabs ">

                            <li class="nav-item">
                                <a id="Year_MainChart_TotalSale_Month" class="nav-link chart-item " href="#" >Total Sale  Per Month</a>
                            </li>
                            <li class="nav-item">
                                <a id="Year_MainChart_TotalSale_Day" class="nav-link chart-item" href="#">Total Sale Per Day</a>
                            </li>


                            <li class="nav-item">
                                <a id="Year_MainChart_TotalOrder_Month" class="nav-link chart-item" href="#">Total Orders Per Month</a>
                            </li>
                            <li class="nav-item">
                                <a id="Year_MainChart_TotalOrder_Day" class="nav-link chart-item" href="#">Total Orders Per Day</a>
                            </li>


                            <li class="nav-item">
                                <a id="Year_MainChart_TotalItemQt_Month" class="nav-link chart-item" href="#">Total Item Quantity Sold Per Month</a>
                            </li>
                            <li class="nav-item">
                                <a id="Year_MainChart_TotalItemQt_Day" class="nav-link chart-item" href="#">Total Item Quantity Sold Per Day</a>
                            </li>

                        </ul>
                    </div>


                    <div id = "DashboardYear_MainChart1_Chart" class="card-block">
                        <div id = "main_chart_div"  style="height:400px"></div>
                    </div>



                </div>










                <br><br>



                <div id = "Dashboardyear_ItemCategoryStats" class="row">

                    <div id="DashboardYear_CategoryStats" class="col-md-6">
                        <div class="card w-90">
                            <div class="card-block">


                                <h3 class="ytext-heading">Category Stats</h3>
                                <hr>

                                <div id="DashboardYear_CategoryStats_Navigation" >
                                    <ul  class="nav nav-pills  justify-content-center nav-pills-lightblue ">

                                        <li class="nav-item">
                                            <a id="Year_CategoryStatChart_ColumnChart" class="nav-link chart-item-categorystats " href="#" >Column</a>
                                        </li>
                                        <li class="nav-item">
                                            <a id="Year_CategoryStatChart_PieChart" class="nav-link chart-item-categorystats" href="#">Pie</a>
                                        </li>


                                    </ul>
                                </div>
                                <br>


                                <div id="categorystats_chart_div" style="height: 350px;"></div>



                            </div>
                        </div>
                    </div>




                    <div id="DashboardYear_ItemStats" class="col-md-6">
                        <div class="card w-90" >
                            <div class="card-block" >

                                <h3 class="ytext-heading">Item Stats</h3>
                                <hr>

                                <div id="DashboardYear_ItemStats_Navigation" >
                                    <ul  class="nav nav-pills justify-content-center nav-pills-lightblue">

                                        <li class="nav-item">
                                            <a id="Year_ItemStatChart_ColumnChart" class="nav-link chart-item-itemstats " href="#" >Column</a>
                                        </li>
                                        <li class="nav-item">
                                            <a id="Year_ItemStatChart_PieChart" class="nav-link chart-item-itemstats" href="#">Pie</a>
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




                <div id="DashboardYear_DetailedStats_NumericalStats" class="card" >

                    <div class=" card-block">

                        <h3 class="ytext-heading"> Detailed Item Stats</h3>
                        <hr>

                        <div class="card-deck">

                            <div class ="col-md-4">
                                <div class ="card card-inverse card-info">
                                    <div class="card-block">
                                        <h2 class="card-title">381,200</h2>
                                        <div class="card-text">Total Orders</div>
                                        <hr />
                                        <h2 class="card-title">50,775</h2>
                                        <div class="card-text">Average Orders per Month </div>
                                        <hr />
                                        <h2 class="card-title">2,200</h2>
                                        <div class="card-text">Average Orders per Day </div>
                                        <hr />
                                        <h2 class="card-title">72,458</h2>
                                        <h5 class="card-text">September </h5>
                                        <div class="card-text">Max Orders For a Month </div>
                                        <hr />
                                        <h2 class="card-title">5,000</h2>
                                        <h5 class="card-text">25 December </h5>
                                        <div class="card-text">Max Orders For a Day </div>
                                        <hr />
                                        <h2 class="card-title"> </h2>
                                        <br><br><br><br><br><br>
                                        <br><br>
                                    </div>
                                </div>
                            </div>


                            <div class ="col-md-4">
                                <div class ="card card-inverse card-danger">
                                    <div class="card-block">
                                        <h2 class="card-title">2,172,093</h2>
                                        <div class="card-text">Total Sale</div>
                                        <hr />
                                        <h2 class="card-title">180,465</h2>
                                        <div class="card-text">Average Sale per Month </div>
                                        <hr />
                                        <h2 class="card-title">61,746</h2>
                                        <div class="card-text">Average Sale per Day </div>
                                        <hr />
                                        <h2 class="card-title">350</h2>
                                        <div class="card-text">Average OrderPrice per Order </div>
                                        <hr />
                                        <h2 class="card-title">401,785</h2>
                                        <h5 class="card-text">November </h5>
                                        <div class="card-text">Max Sale For a Month </div>
                                        <hr />
                                        <h2 class="card-title">100,000</h2>
                                        <h5 class="card-text">30 December </h5>
                                        <div class="card-text">Max Sale For a Day </div>
                                        <hr />
                                        <h2 class="card-title">2,000</h2>
                                        <h5 class="card-text">25 December </h5>
                                        <div class="card-text">Max OrderPrice For an Order </div>
                                    </div>
                                </div>
                            </div>


                            <div class ="col-md-4">
                                <div class ="card card-inverse card-success">
                                    <div class="card-block">
                                        <h2 class="card-title">945,015</h2>
                                        <div class="card-text">Total Items Sold</div>
                                        <hr />
                                        <h2 class="card-title">83,186</h2>
                                        <div class="card-text">Average No. of Items sold per Month </div>
                                        <hr />
                                        <h2 class="card-title">2,358</h2>
                                        <div class="card-text">Average No. of Items sold per Day </div>
                                        <hr />
                                        <h2 class="card-title">4</h2>
                                        <div class="card-text">Average No. of Items in One Order </div>
                                        <hr />
                                        <h2 class="card-title">1855,526</h2>
                                        <h5 class="card-text">November </h5>
                                        <div class="card-text">Max Items sold in a Month </div>
                                        <hr />
                                        <h2 class="card-title">5,195</h2>
                                        <h5 class="card-text">30 December </h5>
                                        <div class="card-text">Max Items sold in a Day</div>
                                        <hr />
                                        <h2 class="card-title">35</h2>
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

                        <ul  class="nav nav-pills card-header-pills  justify-content-center nav-pills-lightblue">

                            <li class="nav-item dropdown">
                                <a id="yolo1" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" >Total Sale</a>
                                <div class="dropdown-menu ">
                                    <a id="Year_DetailChart_TotalSale_Month" class="dropdown-item chart-item-detail" href="#">Total Sale Per Month</a>
                                    <a id="Year_DetailChart_TotalSale_Day" class="dropdown-item chart-item-detail" href="#">Total Sale Per Day</a>
                                    <a id="Year_DetailChart_AverageDailySale_Month" class="dropdown-item chart-item-detail" href="#">Average DailySale Per Month </a>

                                    <a id="Year_DetailChart_AverageOrderPrice_Month" class="dropdown-item chart-item-detail" href="#">Average OrderPrice Per Month </a>
                                    <a id="Year_DetailChart_AverageOrderPrice_Day" class="dropdown-item chart-item-detail" href="#">Average OrderPrice Per Day </a>
                                    <a id="yo" class="dropdown-item chart-item" href="#">Maximum/Minimum OrderPrice Per Month </a>
                                    <a id="Year_DetailChart_MaxMinOrderPrice_Day" class="dropdown-item chart-item-detail" href="#">Maximum/Minimum OrderPrice Per Day </a>
                                </div>

                            </li>

                            <li class="nav-item dropdown">
                                <a id="yolo2" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">Total Orders</a>
                                <div class="dropdown-menu">
                                    <a id="Year_DetailChart_TotalOrder_Month" class="dropdown-item chart-item-detail" href="#">Total Orders Per Month</a>
                                    <a id="Year_DetailChart_TotalOrder_Day" class="dropdown-item chart-item-detail" href="#">Total Orders Per Day</a>
                                    <a id="Year_DetailChart_AverageNoOrdersPerDay_Month" class="dropdown-item chart-item-detail" href="#">Average No. Of Daily Orders Per Month</a>



                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="yolo3" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">Total Item Quantity Sold</a>
                                <div class="dropdown-menu">
                                    <a id="Year_DetailChart_TotalItemQt_Month" class="dropdown-item chart-item-detail" href="#">Total Items sold Per Month</a>
                                    <a id="Year_DetailChart_TotalItemQt_Day" class="dropdown-item chart-item-detail" href="#">Total Items sold Per Day</a>

                                    <a id="Year_DetailChart_AverageItemQtPerOrder_Month" class="dropdown-item chart-item-detail" href="#">Average OrderPrice Per Month </a>
                                    <a id="Year_DetailChart_AverageItemQtPerOrder_Day" class="dropdown-item chart-item-detail" href="#">Average OrderPrice Per Day </a>
                                    <a id="Year_DetailChart_MaxMinItemQtPerOrder_Month" class="dropdown-item chart-item-detail" href="#">Maximum/Minimum OrderPrice Per Month </a>
                                    <a id="Year_DetailChart_MaxMinItemQtPerOrder_Day" class="dropdown-item chart-item-detail" href="#">Maximum/Minimum items sold per order Per Day </a>
                                </div>
                            </li>

                        </ul>
                    </div>

                    <div id="DashboardYear_DetailedCharts_Chart" class="card-block">
                        <div id="detail_chart_div" style="height: 600px;" ></div>
                    </div>



                </div>



                <div id="space_before_footer">
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
    var YOLO_GLOBAL_YEAR = <?php echo $Year  ; ?> ;
</script>


<script type="text/javascript" src="js/year_charts_ajax.js" ></script>
<script type="text/javascript" src="js/custom_datepicker.js"></script>


</html>
