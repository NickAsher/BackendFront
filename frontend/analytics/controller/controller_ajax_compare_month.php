<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/analytics_utils/data_analysis_fns/get_plot_compare_month.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/sql/sqlconnection.php';
$DBConnectionBackend = YOLOSqlConnect() ;
$DBConnectionTest = YOLOSqlDemoConnect() ;



if(isset($_POST['chart_id'])  ){
    $ChartId = $_POST['chart_id'] ;

    $Month1 = $_POST['chart_month1'] ;
    $Year1 = $_POST['chart_year1'] ;
    $Month2 = $_POST['chart_month2'] ;
    $Year2 = $_POST['chart_year2'] ;

    $ChartDiv = $_POST['chart_div'] ;
    $ChartDiv = ltrim($ChartDiv, "#") ;

    switch ($ChartId) {





        case 'CompareMonth_MainChart_TotalSale_Day':
            plotCompareMonths_TotalSale_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $ChartDiv) ;
            break;
        case 'CompareMonth_MainChart_TotalOrder_Day':
            plotCompareMonths_TotalOrders_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $ChartDiv) ;
            break;
        case 'CompareMonth_MainChart_TotalItemQt_Day':
            plotCompareMonths_TotalItemQt_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $ChartDiv) ;
            break;




        case 'CompareMonth_DetailChart_TotalSale_Day':
            plotCompareMonths_TotalSale_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $ChartDiv) ;
            break;
        case 'CompareMonth_DetailChart_AverageOrderPrice_Day':
            plotCompareMonths_AverageOrderPrice_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $ChartDiv) ;
            break;
//        case 'CompareMonth_DetailChart_MaxOrderPrice_Day':
//            plotCompareMonths_TotalSale_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $ChartDiv) ;
//            break;


        case 'CompareMonth_DetailChart_TotalOrder_Day':
            plotCompareMonths_TotalOrders_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $ChartDiv) ;
            break;


        case 'CompareMonth_DetailChart_TotalItemQt_Day':
            plotCompareMonths_TotalItemQt_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $ChartDiv) ;
            break;
        case 'CompareMonth_DetailChart_AverageItemQtPerOrder_Day':
            plotCompareMonths_AverageItemQtPerOrder_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $ChartDiv) ;
            break;
//        case 'CompareMonth_DetailChart_MaxItemQtPerOrder_Day':
//            plotCompareMonths_TotalSale_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $ChartDiv) ;
//            break;






        default:
            echo "Unknown Chart Div ".$ChartId ;

            break;
    }


} else {
    echo "Post data not correct" ;
}



?>
