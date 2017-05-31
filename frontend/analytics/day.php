<html>
<head>
    <title>Analytics | Day</title>

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
    <script>google.charts.load('current', {'packages':['corechart']});</script>


    <?php
    require_once '../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/analytics_utils/data_analysis_fns/get_plot_daily.php' ;

    $DBConnectionTest = YOLOSqlDemoConnect() ;
    $DBConnectionBackend = YOLOSqlConnect() ;



    $Date = "[" ;
    if(isset($_GET['date'])){
      $Date = $_GET['date'] ;
    } else{
      $Date = '2017-01-01' ;
    }

    $DailyStats = getDailyStats($DBConnectionTest, $Date) ;

    echo "<script>console.log('Root folder in class day.php is ' + '$ROOT_FOLDER_PATH') ; </script>" ;

    ?>







</head>
<body>


<header>


    <div id="header" class="navbar fixed-top navbar-toggleable-md" style="background-color: #222;">

        <div>
            <button type="button" class="btn btn-success t3-btn is-close">&#9776; open</button>
        </div>


        <div class="navbar-space"></div>

        <a class="navbar-brand text-white" href="#">Homeflavour Analytics</a>

        <div class="navbar-space"></div>

        <div class="btn-group">
            <button type="button" class="btn btn-info">Day</button>
            <button id="typepicker_btn" type="button" class="btn btn-default">Edit</button>
        </div>



        <div class="navbar-space"></div>

        <div class="btn-group">
            <input type="button" class="btn btn-info datepicker_input" value="<?php echo $Date ?>" >
            <button type="button" class="btn btn-default" id="datepicker_btn" >Edit</button>

        </div>

        <div class="navbar-space"></div>



        <div class="btn-group " >

            <button  class="btn btn-outline-secondary" href="#"><i class="fa fa-cog fa-spin fa-lg "></i></button>

            <button  class="btn btn-default  mdc-text-black-darker" href="#">Settings</button>

        </div>



    </div>


</header>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12">







                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>








                <div id="DashboardDay_NumericalStats" class="row" >

                    <div class ="col-md-4">
                        <div class ="card w-90">
                            <div class="card-block">
                                <div class="card-text">Total Sale</div>
                                <hr />
                                <h2 class="card-title text-center text-success"><?php echo "$ ".number_format($DailyStats['total_sale']) ; ?></h2>
                            </div>
                        </div>
                    </div>


                    <div class ="col-md-4">
                        <div class ="card w-90">
                            <div class="card-block">
                                <div class="card-text">Total Orders</div>
                                <hr />
                                <h2 class="card-title text-center text-info"><?php echo number_format($DailyStats['total_orders']) ; ?></h2>
                            </div>
                        </div>
                    </div>



                    <div class ="col-md-4">
                        <div class ="card w-90">
                            <div class="card-block">
                                <div class="card-text">Total Items Sold</div>
                                <hr />
                                <h2 class="card-title text-center text-danger"><?php echo number_format($DailyStats['total_itemqt']); ?></h2>

                            </div>
                        </div>
                    </div>



                </div>




                <br><br>





                <div id="DashboardDay_MainChart1_Chart" class="card">
                    <div class="card-block">

                        <h3 class="ytext-heading">Quick Stats</h3>
                        <hr><br>

                        <div id = "main_chart_div"  style="height:400px;"></div>

                        <?php plotDailySaleTimeLineChart($DBConnectionTest, $Date, "main_chart_div") ;
                        ?>

                    </div>

                </div>




                <br><br>



                <div id = "DashboardDay_ItemCategoryStats" class="row">

                    <div id="DashboardDay_CategoryStats" class="col-md-6">
                        <div class="card w-90">
                            <div class="card-block">


                                <h3 class="ytext-heading">Category Stats</h3>
                                <hr>

                                <div id="DashboardDay_CategoryStats_Navigation" >
                                    <ul  class="nav nav-pills  justify-content-center nav-pills-lightblue ">

                                        <li class="nav-item">
                                            <a id="Day_CategoryStatChart_ColumnChart" class="nav-link chart-item-categorystats " href="#" >Column</a>
                                        </li>
                                        <li class="nav-item">
                                            <a id="Day_CategoryStatChart_PieChart" class="nav-link chart-item-categorystats" href="#">Pie</a>
                                        </li>


                                    </ul>
                                </div>
                                <br>


                                <div id="categorystats_chart_div" style="height: 350px;"></div>



                            </div>
                        </div>
                    </div>




                    <div id="DashboardDay_ItemStats" class="col-md-6">
                        <div class="card w-90" >
                            <div class="card-block" >

                                <h3 class="ytext-heading">Item Stats</h3>
                                <hr>

                                <div id="DashboardDay_ItemStats_Navigation" >
                                    <ul  class="nav nav-pills justify-content-center nav-pills-lightblue">

                                        <li class="nav-item">
                                            <a id="Day_ItemStatChart_ColumnChart" class="nav-link chart-item-itemstats " href="#" >Column</a>
                                        </li>
                                        <li class="nav-item">
                                            <a id="Day_ItemStatChart_PieChart" class="nav-link chart-item-itemstats" href="#">Pie</a>
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




                <div id="DashboardDay_DetailedStats_NumericalStats" class="card" >

                    <div class=" card-block">

                        <h3 class="ytext-heading"> Detailed Stats</h3>
                        <hr>

                        <div class="card-deck">



                            <div class ="col-md-4">
                                <div class ="card card-inverse card-danger">
                                    <div class="card-block">
                                        <h2 class="card-title">70,027</h2>
                                        <div class="card-text">Total Sale</div>
                                        <hr />
                                        <h2 class="card-title">350</h2>
                                        <div class="card-text">Average OrderPrice per Order </div>
                                        <hr />
                                        <h2 class="card-title">873</h2>
                                        <div class="card-text">Maximum OrderPrice for an Order</div>

                                    </div>
                                </div>
                            </div>


                            <div class ="col-md-4">
                                <div class ="card card-inverse card-info">
                                    <div class="card-block">
                                        <h2 class="card-title">214</h2>
                                        <div class="card-text">Total Orders</div>
                                    </div>
                                </div>
                            </div>


                            <div class ="col-md-4">
                                <div class ="card card-inverse card-success">
                                    <div class="card-block">
                                        <h2 class="card-title">1,008</h2>
                                        <div class="card-text">Total Items Sold</div>
                                        <hr />
                                        <h2 class="card-title">4</h2>
                                        <div class="card-text">Average No. of Items sold in One Order </div>
                                        <hr />
                                        <h2 class="card-title">7</h2>
                                        <div class="card-text">Max Items in an Order</div>

                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                </div>




                <br><br>




                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>











            </div>
        </div>
    </div>
</section>




<?php require_once "includes/footer.php" ?>

</body>
<script type="text/javascript" src="../../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../../lib/jquery_ui/jquery-ui.js" ></script>

<script type="text/javascript" src="../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../lib/t3/t3.js"></script>

<script type="text/javascript">
    var YOLO_GLOBALZ_DATE = <?php echo "'$Date'" ; ?> ;
</script>

<script type="text/javascript" src="js/day_charts_ajax.js" ></script>
<script type="text/javascript" src="js/custom_datepicker.js"></script>


<script>



</script>

</html>
