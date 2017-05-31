<?php
require_once $ROOT_FOLDER_PATH.'/utils/analytics_utils/utility.php';
require_once $ROOT_FOLDER_PATH.'/utils/backend_utils.php' ;


function getMonthlyStats($DBConnection, $Month,$Year){

        /*
         * Returns the stats for a specific month
         * returns it as a column named `total`
         */


        $Query = " SELECT *  FROM `monthly_analysis` WHERE `month` = '".$Month."' AND `year` = '".$Year."'   ";
        $QueryResult = mysqli_query($DBConnection, $Query) ;
        if($QueryResult){

            $Stats = '' ;
            foreach($QueryResult as $Record){
                $Stats = $Record ;
            }
            return $Stats ;

        } else {
            echo "<br> Problem in fetching Stats for this Month ".$Month."-".$Year ;
            echo "<br> ".mysqli_error($DBConnection) ;
            return -1 ;
        }

    }








/* ************************************************* Item Charts ************************************************** */







function plotMonthly_ItemStats_PieChart($DBConnectionBackend, $DBConnectionTest, $Month, $Year, $DivID){
    $Query = "  SELECT `item_stats_o_qt` FROM `monthly_charts_analysis` WHERE `month` = '$Month' AND `year` = '$Year'  ";
    $QueryResult = mysqli_query($DBConnectionTest, $Query);

    $DataString = '[';
    $ItemStatString = '' ;
    $ColorString = '[' ;


    foreach ($QueryResult as $Record) {
        $ItemStatString = $Record['item_stats_o_qt'];
    }

    $ItemStatArray = json_decode($ItemStatString) ;



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


//        echo "<br> $ColorString <br ";
//        echo  "<br> $DataString <br>";


    echo "
            <script type='text/javascript'>

            function drawYearlyItemStatsPieChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Item');
                data.addColumn('number', 'Sale');
                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                    'title':'Total Item Sale Chart',
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'legend': 'none',
                    'colors' : $ColorString
                    
                    };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('".$DivID."'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawYearlyItemStatsPieChart);

        </script>
        " ;

}




function plotMonthly_ItemStats_ColumnChart($DBConnectionBackend, $DBConnectionTest, $Month, $Year,  $DivId){
    $Query = "  SELECT `item_stats_o_qt` FROM `monthly_charts_analysis` WHERE `month` = '$Month' AND `year` = '$Year'  ";
    $QueryResult = mysqli_query($DBConnectionTest, $Query);

    $DataString = '[';
    $ItemStatString = '' ;
    $ColorString = '[' ;


    foreach ($QueryResult as $Record) {
        $ItemStatString = $Record['item_stats_o_qt'];
    }

    //echo $ItemStatString ;

    $ItemStatArray = json_decode($ItemStatString) ;



    $i = 0 ;
    foreach ($ItemStatArray as $Record){
        $ItemId = $Record[0];
        $ItemTotalQuantityOrdered = $Record[1];
        $ItemName = getItemInformation($DBConnectionBackend, $ItemId)['item_name'];
        $DataString = $DataString . "[ '$ItemName', $ItemTotalQuantityOrdered, '".getColorArray()[$i]."' ],";
        $i++  ;

    }
    $DataString = rtrim($DataString, ',') ;
    $DataString = $DataString."]" ;


    echo "<br> $ColorString <br> " ;
    echo "<br> $DataString <br> " ;


    echo "
            <script type='text/javascript'>

            function drawYearlyItemStatsPieChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Item');
                data.addColumn('number', 'Sale');
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

            google.charts.setOnLoadCallback(drawYearlyItemStatsPieChart);

        </script>
        " ;

}








/* ***************************************** Category Stats ************************************************************ */




function plotMonthly_CategoryStats_ColumnBarChart($DBConnectionTest, $Month, $Year, $DivID)
{
    /*
     *
     */
    $DataString = '' ;
    $Query = "  SELECT `category_stats` FROM `monthly_charts_analysis` WHERE `month` = '$Month' AND `year` = '$Year' "    ;
    $QueryResult = mysqli_query($DBConnectionTest, $Query);
    if($QueryResult){
        $Temp = '' ;
        foreach ($QueryResult as $Record) {
            $Temp = $Record['category_stats'] ;
        }
        $Temp = json_decode($Temp) ;




        $Length = count($Temp) ;

        $DataString = "[" ;
        for($i=0;$i<$Length;$i++){

            $DataString.= "['".$Temp[$i][0]."', ".$Temp[$i][1]." , '".getColorArray()[$i]."' ], " ;

        }
        $DataString = rtrim($DataString, ', ') ;
        $DataString = $DataString."]" ;
        //echo $DataString."<br><br>" ;



    }else{
        echo "Problem in fetching Category data <br>".mysqli_error($DBConnectionTest) ;
    }






    echo "
            <script type='text/javascript'>

            function drawMonthly_CategoryStat_ColumnChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', 'Total Sale');
                data.addColumn( {type:'string', role:'style'} ); // annotationText col.

                
                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0',
                    },
                    'legend' : 'none',
                    
                    'animation':{
                        'startup':true,
                        'easing':'inAndOut',
                        'duration':1500
                        },
                    'vAxis': {
                        'minValue' : 0
                        }

                };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.ColumnChart(document.getElementById('".$DivID."'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawMonthly_CategoryStat_ColumnChart);

        </script>
        " ;

}




function plotMonthly_CategoryStats_PieChart($DBConnectionTest, $Month, $Year, $DivID) {
    /*
     *
     */
    $DataString = '[' ;
    $ColorString = '[' ;
    $Query = "  SELECT `category_stats` FROM `monthly_charts_analysis` WHERE `month` = '$Month' AND `year` = '$Year' "    ;
    $QueryResult = mysqli_query($DBConnectionTest, $Query);
    if($QueryResult){
        $Temp = '' ;
        foreach ($QueryResult as $Record) {
            $Temp = $Record['category_stats'] ;
        }
        $Temp = json_decode($Temp) ;


        $Length = count($Temp) ;

        for($i=0;$i<$Length;$i++){

            $DataString.= "['".$Temp[$i][0]."', ".$Temp[$i][1]."  ], " ;
            $ColorString .= " '".getColorArray()[$i]."'," ;
        }
        $DataString = rtrim($DataString, ', ') ;
        $DataString .= "]" ;

        $ColorString = rtrim($ColorString, ', ') ;
        $ColorString = $ColorString."]" ;

        //echo $DataString."<br><br>" ;



    }else{
        echo "Problem in fetching Category data <br>".mysqli_error($DBConnectionTest) ;
    }






    echo "
            <script type='text/javascript'>

            function drawMonthly_CategoryStat_PieChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', 'Total Sale');
                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                'width' : 450,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0',
                    },
                    'legend' : 'none',
                    'colors': $ColorString
                    

                };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('".$DivID."'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawMonthly_CategoryStat_PieChart);

        </script>
        " ;

}







/* ************************************** Monthly Charts Start Here ********************************************************/






function plotVariableLineChart($DBConnection, $Month, $Year, $DivId, $Variable, $Heading, $VariableName, $functionName){
    $Query = "SELECT `$Variable` FROM `monthly_charts_analysis` WHERE `month` = '$Month' AND `year` = '$Year'  " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    $DataString = '' ;
    if($QueryResult){
        foreach($QueryResult as $Record){
            $DataString = $Record[$Variable] ;
        }


        echo "
            <script type='text/javascript'>

            function ".$functionName."() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Item');
                data.addColumn('number', '".$VariableName."');
                data.addColumn({type:'string', role:'style'}); // annotationText col.

                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                    'title':'".$Heading."',
                    'width':800,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'pointSize' : 3,
                    'curveType': 'function',
                    'legend': { 'position': 'bottom' },
                    'animation':{
                        'startup':true,
                        'easing':'inAndOut',
                        'duration':500
                        },
                    'hAxis': {
                        'showTextEvery' : 5,
                        },
                    'vAxis': {
                        'minValue' : 0
                        }


                    };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.LineChart(document.getElementById('".$DivId."'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(".$functionName.");

        </script>
        " ;





    } else{
        echo "Problem in fetching" ;
        echo "<br>".mysqli_error($DBConnection) ;
    }
}





function plotVariable2LineChart($DBConnection, $Month, $Year, $DivId, $Variable, $Heading, $VariableName1, $VariableName2, $functionName){
    $Query = "SELECT `$Variable` FROM `monthly_charts_analysis` WHERE `month` = '$Month' AND `year` = '$Year'  " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    $DataString = '' ;
    if($QueryResult){
        foreach($QueryResult as $Record){
            $DataString = $Record[$Variable] ;
        }


        echo "
            <script type='text/javascript'>

            function ".$functionName."() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Item');
                data.addColumn('number', '".$VariableName1."');
                data.addColumn({type:'string', role:'style'}); // annotationText col.
                data.addColumn('number', '".$VariableName2."');
                data.addColumn({type:'string', role:'style'}); // annotationText col.

                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                    'title':'".$Heading."',
                    'width':800,
                    'height':500,
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

            google.charts.setOnLoadCallback(".$functionName.");

        </script>
        " ;





    } else{
        echo "Problem in fetching" ;
        echo "<br>".mysqli_error($DBConnection) ;
    }
}









/*
 * These are the frontend Functions
 */





function plotMonthlyByDay_TotalSale_LineChart($DBConnection, $Month, $Year, $DivId){
    plotVariableLineChart($DBConnection, $Month, $Year, $DivId, "total_sale_perday",
        "Total sales per day for " . getMonthName($Month), "Sale", "drawMonthlyByDayTotalSaleLineChart") ;
}

function plotMonthlyByDay_AverageOrderPrice_LineChart($DBConnection, $Month, $Year, $DivId){
    plotVariableLineChart($DBConnection, $Month, $Year, $DivId, "avg_orderprice_perday",
        "Average Order Price per day for " . getMonthName($Month), "Average Sale", "drawMonthlyByDayAverageSaleLineChart") ;
}

function plotMonthlyByDay_MaximumMinimumOrderPrice_LineChart($DBConnection, $Month, $Year, $DivId){
    plotVariable2LineChart($DBConnection, $Month, $Year, $DivId, "maxmin_orderprice_perday",
        "Max/Min OrderPrice per day for " . getMonthName($Month), "Maximum OrderPrice", "Minimum OrderPrice", "drawMonthlyByDayMaxMinOrderpriceLineChart") ;
}






function plotMonthlyByDay_TotalOrders_LineChart($DBConnection, $Month, $Year, $DivId){
    plotVariableLineChart(
        $DBConnection, $Month, $Year, $DivId, "total_orders_perday",
        "Total orders per day for " . getMonthName($Month), "Orders", "drawMonthlyByDayTotalOrderLineChart") ;
}





function plotMonthlyByDay_TotalItemsOrdered_LineChart($DBConnection, $Month, $Year, $DivId){
    plotVariableLineChart(
        $DBConnection, $Month, $Year, $DivId, "total_itemqt_perday",
        "Total Number of items ordered per day for " . getMonthName($Month), "Total Items", "drawMonthlyByDayTotalItemsOrderedLineChart") ;
}

function plotMonthlyByDay_AverageItemQtPerOrder_LineChart($DBConnection, $Month, $Year, $DivId) {
    plotVariableLineChart(
        $DBConnection, $Month, $Year, $DivId, "avg_itemqt_perday",
        "Average number of items ordered per day for " . getMonthName($Month), "Average no of Items", "drawMonthlyByDayAverageItemsOrderedLineChart");

}

function plotMonthlyByDay_MaxMinItemQtPerOrder_LineChart($DBConnection, $Month, $Year, $DivId){
    plotVariable2LineChart($DBConnection, $Month, $Year, $DivId, "maxmin_itemqt_perday",
        "Max/Min ItemQuantity Ordered Per Order per day for " . getMonthName($Month),
        "Maximum ItemQuantity Per Order", "Minimum ItemQuantity Per Order", "drawMonthlyByDayMaxMinOrderpriceLineChart") ;

}







?>