<html>
<head>
    <title>Analytics | Day</title>

    <link rel="stylesheet" href="../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap-reboot.min.css" >


    <link rel="stylesheet" href="../lib/jquery_ui/jquery-ui.css">
    <link rel="stylesheet" href="../lib/jquery_ui/jquery-ui.structure.css">
    <link rel="stylesheet" href="../lib/jquery_ui/jquery-ui.theme.css">


    <link rel="stylesheet" href="../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../lib/material_color/material-design-color-palette.css">


    <link rel="stylesheet" href="../lib/t3/t3.css" />





    <script type="text/javascript" src="../lib/chartlibrary/loader.js"></script>
    <script>google.charts.load('current', {'packages':['corechart']});</script>


    <?php
    require_once '../utils/constants.php';
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




    ?>






</head>
<body>
<div id="div1"></div>

<?php
$DivId = "div1" ;
plotDaily_CategoryStats2_PieChart($DBConnectionBackend, $DBConnectionTest, $Date, $DivId) ;




?>
</body>
<script type="text/javascript" src="../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../lib/jquery_ui/jquery-ui.js" ></script>
<script type="text/javascript" src="../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../lib/t3/t3.js"></script>


</html>
