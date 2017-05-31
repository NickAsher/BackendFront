<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/analytics_utils/data_analysis_fns/get_plot_yearly.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/sql/sqlconnection.php';
$DBConnectionBackend = YOLOSqlConnect() ;
$DBConnectionTest = YOLOSqlDemoConnect() ;



if(isset($_POST['chart_id'])  ){
    $ChartId = $_POST['chart_id'] ;
    $ChartYear = $_POST['chart_year'] ;
    $ChartDiv = $_POST['chart_div'] ;
    $ChartDiv = ltrim($ChartDiv, "#") ;

    switch ($ChartId) {

        case 'Year_ItemStatChart_PieChart':
            plotYearly_ItemStats_PieChart($DBConnectionBackend, $DBConnectionTest, $ChartYear, $ChartDiv) ;
            break;
        case 'Year_ItemStatChart_ColumnChart':
            plotYearly_ItemStats_ColumnBarChart($DBConnectionBackend, $DBConnectionTest, $ChartYear, 1, $ChartDiv) ;
            break;

        case 'Year_CategoryStatChart_PieChart':
            plotYearly_CategoryStats_PieChart($DBConnectionTest, $ChartYear, $ChartDiv) ;
            break;
        case 'Year_CategoryStatChart_ColumnChart':
            plotYearly_CategoryStats_ColumnBarChart($DBConnectionTest, $ChartYear, $ChartDiv) ;
            break;





        case 'Year_MainChart_TotalSale_Month':
            plotYearlyByMonth_TotalSale_ColumnChart($DBConnectionTest, $ChartYear, "main_chart_div") ;
            break;
        case 'Year_MainChart_TotalSale_Day':
            plotYearlyByDay_TotalSale_LineChart($DBConnectionTest, $ChartYear, "main_chart_div") ;
            break;

        case 'Year_MainChart_TotalOrder_Month':
            plotYearlyByMonth_TotalOrder_ColumnChart($DBConnectionTest, $ChartYear, "main_chart_div") ;
            break;
        case 'Year_MainChart_TotalOrder_Day':
            plotYearlyByDay_TotalOrders_LineChart($DBConnectionTest, $ChartYear, "main_chart_div") ;
            break;

        case 'Year_MainChart_TotalItemQt_Month':
            plotYearlyByMonth_TotalItemQt_ColumnChart($DBConnectionTest, $ChartYear, "main_chart_div") ;
            break;
        case 'Year_MainChart_TotalItemQt_Day':
            plotYearlyByDay_TotalItemsOrdered_LineChart($DBConnectionTest, $ChartYear, "main_chart_div") ;
            break;










        case 'Year_DetailChart_TotalSale_Month':
            plotYearlyByMonth_TotalSale_ColumnChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_TotalSale_Day':
            plotYearlyByDay_TotalSale_LineChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_AverageDailySale_Month':
            plotYearlyByMonth_AvgDailySale_ColumnChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_AverageOrderPrice_Month':
            plotYearlyByMonth_AvgOrderPrice_ColumnChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_AverageOrderPrice_Day':
            plotYearlyByDay_AverageOrderPrice_LineChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_MaxMinOrderPrice_Day':
            plotYearlyByDay_MaximumMinimumOrderPrice_LineChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
//        case 'Year_DetailChart_MaxMinOrderPrice_Month':
//            plotYearlyByDay_TotalItemsOrdered_LineChart($DBConnection, $ChartYear, "detail_chart_div") ;
//            break;




        case 'Year_DetailChart_TotalOrder_Month':
            plotYearlyByMonth_TotalOrder_ColumnChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_TotalOrder_Day':
            plotYearlyByDay_TotalOrders_LineChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_AverageNoOrdersPerDay_Month':
            plotYearlyByMonth_AvgDailyNoOfOrder_ColumnChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;




        case 'Year_DetailChart_TotalItemQt_Month':
            plotYearlyByMonth_TotalItemQt_ColumnChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_TotalItemQt_Day':
            plotYearlyByDay_TotalItemsOrdered_LineChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_AverageItemQtPerOrder_Month':
            plotYearlyByMonth_AvgDailyItemQt_ColumnChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_AverageItemQtPerOrder_Day':
            plotYearlyByDay_AverageItemsPerOrder_LineChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_MaxMinItemQtPerOrder_Month':
            plotYearlyByMonth_AvgItemQtPerOrder_ColumnChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;
        case 'Year_DetailChart_MaxMinItemQtPerOrder_Day':
            plotYearlyByDay_MaxMinItemsPerOrder_LineChart($DBConnectionTest, $ChartYear, "detail_chart_div") ;
            break;






        default:
            echo "Unknown Chart Div ".$ChartId ;

            break;
    }


} else {
    echo "Post data not correct" ;
}



?>
