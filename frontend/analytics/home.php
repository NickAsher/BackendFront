<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../common/css/default_style.css">



        <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-reboot.min.css" >
    <script src="../../lib/bootstrap4/bootstrap.min.js" ></script>

    <script type="text/javascript" src="../../lib/chartlibrary/loader.js"></script>
    <script>google.charts.load('current', {'packages':['corechart']});</script>


    <?php
    require_once '../../sql/sqlconnection.php' ;
//    require_once '../utils/data_analysis_fns/get_plot_daily.php' ;
    require_once 'controller/controller_home.inc' ;
    $DBConnectionTest = YOLOSqlDemoConnect() ;
    $DBConnectionBackend = YOLOSqlConnect() ;

    ?>






</head>
<body>
<div><?php require_once "includes/header.php" ?></div>




<section>
    <div class="container-fluid row" id="mainContainer">
        <?php require_once "includes/navigation.php" ?>

        <div id = "main_Content" class="col-md-10 row">
            <div class="col-md-1"></div>
            <div class="col-md-11">




                <div class = "row">
                        <div class="col-md-1" style="background-color: #000000;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #ff0000;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #00ff00;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #0000ff;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #ffff00;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #00ffff;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #ff00ff;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #f0ff00;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #fe1245;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #000000;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #efefef;height: 4px;"></div>
                        <div class="col-md-1" style="background-color: #fb5000;height: 4px;"></div>
                </div>

            <br><br><br><br>


                <h3 class="ytext-heading">Quick Stats</h3>
                <hr><br>
                <div id="mainContainer-numericalStats" class="row">

                    <div class ="col-md-3">
                         <div class ="card card-inverse card-info">
                            <div class="card-block">
                                <h2 class="card-title">382</h2>
                                <hr />
                                <div class="card-text">Total Orders</div>
                            </div>
                        </div>
                    </div>


                    <div class ="col-md-3">
                        <div class ="card card-inverse card-warning">
                            <div class="card-block">
                                <h2 class="card-title">72,093</h2>
                                <hr />
                                <div class="card-text">Total Sale</div>
                            </div>
                        </div>
                    </div>


                    <div class ="col-md-3">
                        <div class ="card card-inverse card-danger">
                            <div class="card-block">
                                <h2 class="card-title">1015</h2>
                                <hr />
                                <div class="card-text">Total Items Sold</div>
                            </div>
                        </div>
                    </div>

                    <div class ="col-md-3">
                        <div class ="card card-inverse card-success">
                            <div class="card-block">
                                <h2 class="card-title">742</h2>
                                <hr />
                                <div class="card-text">Average Order Price</div>
                            </div>
                        </div>
                    </div>



                </div>



                <br><br><br><br><hr>
                <div id="mainContainer_LineChart">
                    <div id = "main_line_chart_div" class="col-md-12" style="height: 400px;"></div>

                    <?php
                    plotDailySaleTimeLineChart($DBConnectionTest, '2016-01-01', "main_line_chart_div") ;
                    ?>
                </div>







                <br><br><br><br>
                <h3 class="ytext-heading">Category Stats</h3>
                <hr>
                <div id="mainContainer_Charts_CategoryStats" class="row">
                    
                    <div id="category_stats_piechart" class="col-md-6" style="height: 500px;"></div>
                    <div id="category_stats_columnchart" class="col-md-6" style="height: 400px;"></div>

                    <?php
                    plotDailyCategoryStatsPieChart($DBConnectionTest, '2016-01-01', "category_stats_piechart") ;
                    plotDailyCategoryStatsColumnChart($DBConnectionTest, '2016-01-01', "category_stats_columnchart") ;
                    ?>

                </div>






                <br><br><br>
                <h3 class="ytext-heading">Item Stats</h3>
                <hr>
                <div id="mainContainer_PieChart_ItemStats" class="row">


                    <div id="item_stats_piechart" class="col-md-6" style="height: 500px;"></div>
                    <div id="item_stats_columnchart" class="col-md-6" style="height: 500px;"></div>

                    <?php
                    plotDailyItemQuantitySalePieChart($DBConnectionBackend, $DBConnectionTest, '2016-01-01', "item_stats_piechart") ;
                    plotDailyItemQuantitySaleColumnChart($DBConnectionBackend, $DBConnectionTest, '2016-01-01',2, "item_stats_columnchart") ;
                    ?>

                </div>









        </div>
    </div>



</section>



<div><?php require_once "includes/footer.php" ?></div>

</body>
</html>