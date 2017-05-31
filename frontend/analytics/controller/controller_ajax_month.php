<?php

require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/analytics_utils/data_analysis_fns/get_plot_monthly.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php';

$DBConnectionBackend = YOLOSqlConnect() ;
$DBConnectionTest = YOLOSqlDemoConnect() ;


if(isset($_POST['chart_id'])  ){
    $ChartId = $_POST['chart_id'] ;
    $ChartMonth = $_POST['chart_month'] ;
    $ChartYear = $_POST['chart_year'] ;
    $ChartDiv = $_POST['chart_div'] ;
    $ChartDiv = ltrim($ChartDiv, "#") ;

    switch ($ChartId) {

        case 'Month_ItemStatChart_PieChart':
            plotMonthly_ItemStats_PieChart($DBConnectionBackend, $DBConnectionTest, $ChartMonth, $ChartYear, $ChartDiv) ;
            break;
        case 'Month_ItemStatChart_ColumnChart':
            plotMonthly_ItemStats_ColumnChart($DBConnectionBackend, $DBConnectionTest, $ChartMonth, $ChartYear, $ChartDiv) ;
            break;

        case 'Month_CategoryStatChart_PieChart':
            plotMonthly_CategoryStats_PieChart($DBConnectionTest, $ChartMonth, $ChartYear, $ChartDiv) ;
            break;
        case 'Month_CategoryStatChart_ColumnChart':
            plotMonthly_CategoryStats_ColumnBarChart($DBConnectionTest, $ChartMonth, $ChartYear, $ChartDiv) ;
            break;





        case 'Month_MainChart_TotalSale_Day':
            plotMonthlyByDay_TotalSale_LineChart($DBConnectionTest, $ChartMonth, $ChartYear, $ChartDiv) ;
            break;
        case 'Month_MainChart_TotalOrder_Day':
            plotMonthlyByDay_TotalOrders_LineChart($DBConnectionTest, $ChartMonth, $ChartYear, $ChartDiv) ;
            break;
        case 'Month_MainChart_TotalItemQt_Day':
            plotMonthlyByDay_TotalItemsOrdered_LineChart($DBConnectionTest, $ChartMonth, $ChartYear, $ChartDiv) ;
            break;




        case 'Month_DetailChart_TotalSale_Day':
            plotMonthlyByDay_TotalSale_LineChart($DBConnectionTest, $ChartMonth, $ChartYear, "detail_chart_div") ;
            break;
        case 'Month_DetailChart_AverageOrderPrice_Day':
            plotMonthlyByDay_AverageOrderPrice_LineChart($DBConnectionTest, $ChartMonth, $ChartYear, "detail_chart_div") ;
            break;
        case 'Month_DetailChart_MaxMinOrderPrice_Day':
            plotMonthlyByDay_MaximumMinimumOrderPrice_LineChart($DBConnectionTest, $ChartMonth, $ChartYear, "detail_chart_div") ;
            break;


        case 'Month_DetailChart_TotalOrder_Day':
            plotMonthlyByDay_TotalOrders_LineChart($DBConnectionTest, $ChartMonth, $ChartYear, "detail_chart_div") ;
            break;


        case 'Month_DetailChart_TotalItemQt_Day':
            plotMonthlyByDay_TotalItemsOrdered_LineChart($DBConnectionTest, $ChartMonth, $ChartYear, "detail_chart_div") ;
            break;
        case 'Month_DetailChart_AverageItemQtPerOrder_Day':
            plotMonthlyByDay_AverageItemQtPerOrder_LineChart($DBConnectionTest, $ChartMonth, $ChartYear, "detail_chart_div") ;
            break;
        case 'Month_DetailChart_MaxMinItemQtPerOrder_Day':
            plotMonthlyByDay_MaxMinItemQtPerOrder_LineChart($DBConnectionTest, $ChartMonth, $ChartYear, "detail_chart_div") ;
            break;






        default:
            echo "Unknown Chart Div ".$ChartId ;

            break;
    }


} else {
    echo "Post data not correct" ;
}



?>
