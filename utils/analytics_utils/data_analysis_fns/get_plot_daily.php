<?php
//require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/analytics_utils/utility.php';
//require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/backend_utils.php' ;

require_once $ROOT_FOLDER_PATH.'/utils/analytics_utils/utility.php';
require_once $ROOT_FOLDER_PATH.'/utils/backend_utils.php' ;

/*
* This class has the function for both the Per day analytics. It uses both daily_analayis and daily_charts_analaysis table
 */



/*
 * These functions are for the numerical stats
 */
    function getDailyStats($DBConnection, $Date){

        /*
         * Returns the stats for a specific day
         * returns it as a column named `total`
         */


        $Query = " SELECT *  FROM `daily_analysis` WHERE `date` = '$Date'   ";
        $QueryResult = mysqli_query($DBConnection, $Query) ;
        if($QueryResult){

            $Stats = '' ;
            foreach($QueryResult as $Record){
                $Stats = $Record ;
            }
            return $Stats ;

        } else {
            echo "<br> Problem in fetching Stats for this day" ;
            echo "<br> ".mysqli_error($DBConnection) ;
            return -1 ;
        }


    }





 /* ************************************************* Item Charts ************************************************** */







function plotDaily_ItemStats_ColumnBarChart($DBConnectionBackend, $DBConnectionTest, $Date,  $DivId){
    $Query = "  SELECT `item_stats_o_qt` FROM `daily_charts_analysis` WHERE `date` = '$Date'  ";
    $QueryResult = mysqli_query($DBConnectionTest, $Query);

    $DataString = '[';
    $ItemStatString = '' ;


    foreach ($QueryResult as $Record) {
        $ItemStatString = $Record['item_stats_o_qt'];
    }
    $ItemStatArray = json_decode($ItemStatString) ;

    $i = 0 ;
    foreach ($ItemStatArray as $Record){
        $ItemId = $Record[0];
        $ItemTotalQuantityOrdered = $Record[1];
        $ItemName = getItemInformation($DBConnectionBackend, $ItemId)['item_name'];
        $DataString .= "[ '$ItemName', $ItemTotalQuantityOrdered, '".getColorArray()[$i]."' ],";
        $i++  ;

    }
    $DataString = rtrim($DataString, ',') ;
    $DataString = $DataString."]" ;


//    echo  $DataString;


    echo "
            <script type='text/javascript'>

            function drawDailyItemStatsColumnBarChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Item');
                data.addColumn('number', 'Sale(units)');
                data.addColumn({type:'string', role:'style'})
                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                    'title':'Total Item Sale Chart',
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'legend': {
                        'position': 'left' 
                        },
                    'animation':{
                        'startup':true,
                        'easing':'inAndOut',
                        'duration':500
                        },
                    'hAxis': {
                        'minValue' : 0,
                         
                        },
                    'vAxis': {
                        'minValue' : 0
                        }
                    
                    };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.ColumnChart(document.getElementById('$DivId'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawDailyItemStatsColumnBarChart);

        </script>
        " ;

}





function plotDaily_ItemStats_PieChart($DBConnectionBackend, $DBConnectionTest, $Date, $DivID){
    $Query = "  SELECT `item_stats_o_qt` FROM `daily_charts_analysis` WHERE `date` = '$Date'  ";
    $QueryResult = mysqli_query($DBConnectionTest, $Query);

    $DataString = '[';
    $ItemStatString = '' ;
    $ColorString = '[' ;


    foreach ($QueryResult as $Record) {
        $ItemStatString = $Record['item_stats_o_qt'];
    }

    $ItemStatArray = json_decode($ItemStatString) ;
    //var_dump($ItemStatArray) ;



    $i = 0 ;
    foreach ($ItemStatArray as $Record){
        $ItemId = $Record[0];
        $ItemTotalQuantityOrdered = $Record[1];
        $ItemName = getItemInformation($DBConnectionBackend, $ItemId)['item_name'];
        $DataString = $DataString . "[ '$ItemName', $ItemTotalQuantityOrdered ],";

        $ColorString .= " '".getColorArray()[$i]."'," ;
        $i++ ;
    }
    $DataString = rtrim($DataString, ',') ;
    $DataString = $DataString."]" ;


    $ColorString = rtrim($ColorString, ',') ;
    $ColorString = $ColorString."]" ;


//        echo $ColorString."<br><br>" ;
//        echo  $DataString;


    echo "
            <script type='text/javascript'>

            function drawDailyItemStatsPieChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Item');
                data.addColumn('number', 'Sale');
                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                    'title':'Item based Breakdown of Sales',
                    'width' : 400,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'legend': {
                        'position' : 'left'
                    },
                    'colors' : $ColorString
                    
                    };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('$DivID'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawDailyItemStatsPieChart);

        </script>
        " ;

}









/* ***************************************** Category Stats ************************************************************ */









function plotDaily_CategoryStats_ColumnChart($DBConnectionBackend, $DBConnectionTest, $Date,  $DivId){
    $Query = "  SELECT `category_stats` FROM `daily_charts_analysis` WHERE `date` = '$Date'  ";
    $QueryResult = mysqli_query($DBConnectionTest, $Query);

    $DataString = '[';
    $CategoryStatString = null ;


    foreach ($QueryResult as $Record) {
        $CategoryStatString = $Record['category_stats'];

    }
    $CategoryStatArray = json_decode($CategoryStatString, true) ;

    $i = 0 ;
    foreach ($CategoryStatArray as $Record){
        $ItemId = $Record[0];
        $ItemTotalQuantityOrdered = $Record[1];
        $DataString .= "[ '$ItemId', $ItemTotalQuantityOrdered, '".getColorArray()[$i]."' ],";
        $i++  ;

    }
    $DataString = rtrim($DataString, ',') ;
    $DataString = $DataString."]" ;




//    echo  $DataString;


    echo "
            <script type='text/javascript'>

            function drawDailyItemStatsColumnBarChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Item');
                data.addColumn('number', 'Sale(units)');
                data.addColumn({type:'string', role:'style'})

                data.addRows($DataString);

                // Set chart options
                var options = {
                    'title':'Total Item Sale Chart',
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'legend': {
                        'position': 'left' 
                        },
                    'animation':{
                        'startup':true,
                        'easing':'inAndOut',
                        'duration':500
                        },
                    'hAxis': {
                        'minValue' : 0,
                         
                        },
                    'vAxis': {
                        'minValue' : 0
                        }
                    
                    };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.ColumnChart(document.getElementById('$DivId'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawDailyItemStatsColumnBarChart);

        </script>
        " ;

}





function plotDaily_CategoryStats_PieChart($DBConnectionBackend, $DBConnectionTest, $Date, $DivID){
    $Query = "  SELECT `category_stats` FROM `daily_charts_analysis` WHERE `date` = '$Date'  ";
    $QueryResult = mysqli_query($DBConnectionTest, $Query);

    $ItemStatString = null ;
    $ColorString = '[' ;


    foreach ($QueryResult as $Record) {
        $ItemStatString = $Record['category_stats'];
    }
    $ItemStatArray = json_decode($ItemStatString) ;
    //var_dump($ItemStatArray) ;



    $i = 0 ;
    foreach ($ItemStatArray as $Record){
        $ColorString .= " '".getColorArray()[$i]."'," ;
        $i++ ;
    }
    $ColorString = rtrim($ColorString, ',') ;
    $ColorString = $ColorString."]" ;


//        echo $ColorString."<br><br>" ;
//        echo  $DataString;


    echo "
            <script type='text/javascript'>

            function drawDailyItemStatsPieChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Item');
                data.addColumn('number', 'Sale');
                data.addRows($ItemStatString);

                // Set chart options
                var options = {
                    'title':'Item based Breakdown of Sales',
                    'width' : 400,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'legend': {
                        'position' : 'left'
                    },
                    'colors' : $ColorString
                    
                    };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('$DivID'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawDailyItemStatsPieChart);

        </script>
        " ;

}







/* ************************************** Daily Charts Start Here ********************************************************/




function plotDailySaleTimeLineChart($DBConnection, $Date, $DivId){
    $Query = "SELECT `sale_time_perorder` FROM `daily_charts_analysis` WHERE `date` = '$Date'   " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    $DataString = '' ;
    if($QueryResult){
        foreach($QueryResult as $Record){
            $DataString = $Record['sale_time_perorder'] ;
        }


        echo "
            <script type='text/javascript'>

            function drawDailySaleTimeLineChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Time');
                data.addColumn('number', 'Sale');
                data.addColumn({type:'string', role:'style'}); // annotationText col.

                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                    'title':'Sale Time Chart for ".getFullDateString($Date)."',

                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'pointSize' : 5,
                    'curveType': 'function',
                    'legend': { 'position': 'bottom' },
                    'animation':{'startup':true,
                                    'easing':'inAndOut',
                                     'duration':500},
                    'hAxis': {'showTextEvery' : 5 }


                    };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.LineChart(document.getElementById('".$DivId."'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawDailySaleTimeLineChart);

        </script>
        " ;





    } else{
        echo "Problem in fetching" ;
        echo "<br>".mysqli_error($DBConnection) ;
    }
}


















?>