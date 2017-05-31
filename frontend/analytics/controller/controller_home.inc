<?php
require_once $_SERVER['DOCUMENT_ROOT']."/BackendFront/utils/data_analysis_fns/get_plot_daily.php" ;


function getControllerDailyStats($DBConnection, $Date){
    $DailyStats = getDailyStats($DBConnection, $Date) ;
    $DailyStats['total_items_sold'] = $DailyStats['category_main_counter'] + $DailyStats['category_main_counter'] ;
    return $DailyStats ;
    
}










?>