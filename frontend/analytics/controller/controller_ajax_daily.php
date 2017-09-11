<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/analytics_utils/data_analysis_fns/get_plot_daily.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php';

$DBConnectionBackend = YOLOSqlConnect() ;
$DBConnectionTest = YOLOSqlDemoConnect() ;



if(isset($_POST['chart_id'])  ){
    $ChartId = $_POST['chart_id'] ;
    $ChartDate = $_POST['chart_date'] ;
    $ChartDiv = $_POST['chart_div'] ;
    $ChartDiv = ltrim($ChartDiv, "#") ;

    switch ($ChartId) {

        case 'Day_ItemStatChart_PieChart':
            plotDaily_ItemStats_PieChart($DBConnectionBackend, $DBConnectionTest, $ChartDate, $ChartDiv) ;
            break;
        case 'Day_ItemStatChart_ColumnChart':
            plotDaily_ItemStats_ColumnBarChart($DBConnectionBackend, $DBConnectionTest, $ChartDate, $ChartDiv) ;
            break;

        case 'Day_CategoryStatChart_PieChart':
            plotDaily_CategoryStats_PieChart($DBConnectionBackend, $DBConnectionTest, $ChartDate, $ChartDiv) ;
            break;
        case 'Day_CategoryStatChart_ColumnChart':
            plotDaily_CategoryStats_ColumnChart($DBConnectionBackend, $DBConnectionTest, $ChartDate, $ChartDiv) ;
            break;


        default:
            echo "Unknown Chart Div ".$ChartId ;
            break;
    }


} else {
    echo "Post data not correct" ;
}



?>
