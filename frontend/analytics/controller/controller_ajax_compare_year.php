<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/analytics_utils/data_analysis_fns/get_plot_compare_year.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/sql/sqlconnection.php';
$DBConnectionBackend = YOLOSqlConnect() ;
$DBConnectionTest = YOLOSqlDemoConnect() ;



if(isset($_POST['chart_id'])  ){
    $ChartId = $_POST['chart_id'] ;

    $Year1 = $_POST['chart_year1'] ;
    $Year2 = $_POST['chart_year2'] ;

    $ChartDiv = $_POST['chart_div'] ;
    $ChartDiv = ltrim($ChartDiv, "#") ;

    switch ($ChartId) {






        case 'CompareYear_MainChart_TotalSale_Day':
            plotCompareYear_Daily_TotalSale_LineChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;


        case 'CompareYear_MainChart_TotalOrder_Day':
            plotCompareYear_Daily_TotalOrders_LineChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;












        case 'CompareYear_DetailChart_TotalSale_Month':
            plotCompareYear_Month_TotalSale_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
        case 'CompareYear_DetailChart_TotalSale_Day':
            plotCompareYear_Daily_TotalSale_LineChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
        case 'CompareYear_DetailChart_AverageDailySale_Month':
            plotCompareYear_Month_AverageDailySale_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
        case 'CompareYear_DetailChart_AverageOrderPrice_Month':
            plotCompareYear_Month_AverageOrderPrice_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
        case 'CompareYear_DetailChart_AverageOrderPrice_Day':
            plotCompareYear_Daily_AverageOrderPrice_LineChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
//        case 'CompareYear_DetailChart_MaxMinOrderPrice_Day':
//            plotYearlyByMonth_TotalSale_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
//            break;
//        case 'Year_DetailChart_MaxMinOrderPrice_Month':
//            plotYearlyByDay_TotalItemsOrdered_LineChart($DBConnection, $ChartYear, "detail_chart_div") ;
//            break;




        case 'CompareYear_DetailChart_TotalOrder_Month':
            plotCompareYear_Month_TotalOrders_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
        case 'CompareYear_DetailChart_TotalOrder_Day':
            plotCompareYear_Daily_TotalOrders_LineChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
        case 'CompareYear_DetailChart_AverageNoOrdersPerDay_Month':
            plotCompareYear_Month_AverageNoOfOrders_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;




        case 'CompareYear_DetailChart_TotalItemQt_Month':
            plotCompareYear_Month_TotalItemQt_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
        case 'CompareYear_DetailChart_TotalItemQt_Day':
            plotCompareYear_Daily_TotalItemQt_LineChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;

        case 'CompareYear_DetailChart_AverageDailyItemQt_Month':
            plotCompareYear_Month_AverageDailyItemQt_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
        case 'CompareYear_DetailChart_AverageItemQtPerOrder_Month':
            plotCompareYear_Month_AvgItemQtPerOrder_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
        case 'CompareYear_DetailChart_AverageItemQtPerOrder_Day':
            plotCompareYear_Daily_AverageItemQtPerOrder_LineChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
            break;
//        case 'Year_DetailChart_MaxMinItemQtPerOrder_Month':
//            plotYearlyByMonth_TotalSale_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
//            break;
//        case 'CompareYear_DetailChart_MaxMinItemQtPerOrder_Day':
//            plotYearlyByMonth_TotalSale_ColumnChart($DBConnectionTest, $Year1, $Year2, $ChartDiv) ;
//            break;





        default:
            echo "Unknown Chart Div ".$ChartId ;

            break;
    }


} else {
    echo "Post data not correct" ;
}



?>
