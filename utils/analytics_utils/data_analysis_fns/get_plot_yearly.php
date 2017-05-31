<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/analytics_utils/utility.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/backend_utils.php' ;






function getYearlyStats($DBConnection, $Year){
        $Query = " SELECT *  FROM `yearly_analysis` WHERE  `year` = '".$Year."'   ";
        $QueryResult = mysqli_query($DBConnection, $Query) ;
        if($QueryResult){

            $Stats = '' ;
            foreach($QueryResult as $Record){
                $Stats = $Record ;
            }
            return $Stats ;

        } else {
            echo "<br> Problem in fetching Stats for this Year ".$Year ;
            echo "<br> ".mysqli_error($DBConnection) ;
            return -1 ;
        }
    }












        /************************************************************************************************** */


        /*
         * Item Stats Chart
         */




function plotYearly_ItemStats_PieChart($DBConnectionBackend, $DBConnectionTest, $Year, $DivID){
    $Query = "  SELECT `item_stats` FROM `yearly_analysis` WHERE `year` = '$Year'  ";
    $QueryResult = mysqli_query($DBConnectionTest, $Query);

    $DataString = '[';
    $ItemStatString = '' ;
    $ColorString = '[' ;


    foreach ($QueryResult as $Record) {
        $ItemStatString = $Record['item_stats'];
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


//        echo $ColorString ;
//        echo  $DataString;


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
                'legend': {
                        'position' : 'left'
                    },
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







function plotYearly_ItemStats_ColumnBarChart($DBConnectionBackend, $DBConnectionTest, $Year, $ChartType, $DivId){
    $Query = "  SELECT `item_stats` FROM `yearly_analysis` WHERE `year` = '$Year'  ";
    $QueryResult = mysqli_query($DBConnectionTest, $Query);

    $DataString = '[';
    $ItemStatString = '' ;
    $ColorString = '[' ;


    foreach ($QueryResult as $Record) {
        $ItemStatString = $Record['item_stats'];
    }

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
    
    $ChartString = '' ;
    if($ChartType == 1){
        $ChartString = "var chart = new google.visualization.ColumnChart(document.getElementById('$DivId')); " ;
    } else if($ChartType == 2){
        $ChartString = "var chart = new google.visualization.BarChart(document.getElementById('$DivId')); " ;

    }



//        echo $ColorString ;
//        echo  $DataString;


    echo "
            <script type='text/javascript'>

            function drawYearly_ItemStats_ColumnBarChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Item');
                data.addColumn('number', 'Sale');
                data.addColumn({type:'string', role:'style'})
                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                    'title':'Total Item Sale Chart',
                    'width' : 450,
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
                $ChartString
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawYearly_ItemStats_ColumnBarChart);

        </script>
        " ;

}





    /*
     * Category Stats Chart
     */

function plotYearly_CategoryStats_PieChart($DBConnectionTest, $Year, $DivID) {
    /*
     *
     */
    $DataString = '' ;
    $Query = "  SELECT `category_stats` FROM `yearly_charts_analysis` WHERE `year` = '$Year' "    ;
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

            $DataString.= "['".$Temp[$i][0]."', ".$Temp[$i][1]."  ], " ;

        }
        $DataString = rtrim($DataString, ', ') ;
        $DataString = $DataString."]" ;

        //echo $DataString."<br><br>" ;



        $ColorString = "['".getColorArray()[0]."' , '".getColorArray()[1]."'] " ;
    }else{
        echo "Problem in fetching Category data <br>".mysqli_error($DBConnectionTest) ;
    }






    echo "
            <script type='text/javascript'>

            function drawYearly_CategoryStat_PieChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', 'Total Sale');
                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                'title' : 'Breakdown of Sales by Category',
                'width' : 450,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0',
                    },
                    'legend' : {
                        'position' : 'left'
                    },
                    'colors': $ColorString
                    

                };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('".$DivID."'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawYearly_CategoryStat_PieChart);

        </script>
        " ;

}






function plotYearly_CategoryStats_ColumnBarChart($DBConnectionTest, $Year, $DivID)
{
    /*
     *
     */
    $DataString = '' ;
    $Query = "  SELECT `category_stats` FROM `yearly_charts_analysis` WHERE `year` = '$Year' "    ;
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
    }else{
        echo "Problem in fetching Category data <br>".mysqli_error($DBConnectionTest) ;
    }






    echo "
            <script type='text/javascript'>

            function drawYearly_CategoryStat_ColumnBarChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', 'Total Sale');
                data.addColumn( {type:'string', role:'style'} ); // annotationText col.

                
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

            google.charts.setOnLoadCallback(drawYearly_CategoryStat_ColumnBarChart);

        </script>
        " ;

}









    /*
     * Daily Variable Line Charts
     */





function plotYearlyVariableLineChart($DBConnection, $Year, $DivId, $Variable, $Heading, $VariableName, $functionName){
    $Query = "SELECT `$Variable` FROM `yearly_charts_analysis` WHERE `year` = '$Year'  " ;
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
                    'width':1000,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'pointSize' : 1,
                    'curveType': 'function',
                    'legend': {
                        'position': 'bottom' 
                        },
                    'animation':{
                        'startup':true,
                        'easing':'inAndOut',
                        'duration':500
                        },
                    'hAxis': {
                        'showTextEvery' : 30,
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






function plotYearlyVariable2LineChart($DBConnection, $Year, $DivId, $Variable, $Heading, $VariableName1, $VariableName2, $functionName){
    $Query = "SELECT `$Variable` FROM `yearly_charts_analysis` WHERE `year` = '$Year'  " ;
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
                    'height' : 800,
                    'width':1000,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'pointSize' : 1,
                    'curveType': 'function',
                    'legend': {
                        'position': 'bottom' 
                        },
                    'animation':{
                        'startup':true,
                        'easing':'inAndOut',
                        'duration':500
                        },
                    'hAxis': {
                        'showTextEvery' : 15,
                         
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










function plotYearlyByDay_TotalSale_LineChart($DBConnection, $Year, $DivId){
    plotYearlyVariableLineChart($DBConnection, $Year, $DivId, "total_sale_perday",
        "Total sales per day for $Year", "Sale", "drawMonthlyByDayTotalSaleLineChart") ;
}

function plotYearlyByDay_AverageOrderPrice_LineChart($DBConnection, $Year, $DivId){
    plotYearlyVariableLineChart($DBConnection, $Year, $DivId, "avg_orderprice_perday",
        "Average OrderPrice per day for $Year", "Average OrderPrice", "drawMonthlyByDayAverageOrderPriceLineChart") ;
}

function plotYearlyByDay_MaximumMinimumOrderPrice_LineChart($DBConnection, $Year, $DivId){
    plotYearlyVariable2LineChart($DBConnection, $Year, $DivId, "maxmin_orderprice_perday",
        "Max/Min OrderPrice per day for $Year", "Maximum OrderPrice", "Minimum OrderPrice", "drawMonthlyByDayMaxMinOrderpriceLineChart") ;
}






function plotYearlyByDay_TotalOrders_LineChart($DBConnection, $Year, $DivId){
    plotYearlyVariableLineChart($DBConnection, $Year, $DivId, "total_orders_perday",
        "Total orders per day for $Year", "Orders", "drawMonthlyByDayTotalOrderLineChart") ;
}





function plotYearlyByDay_TotalItemsOrdered_LineChart($DBConnection, $Year, $DivId){
    plotYearlyVariableLineChart($DBConnection, $Year, $DivId, "total_itemqt_perday",
        "Total Number of items ordered per day for $Year", "Total Items", "drawMonthlyByDayTotalItemsOrderedLineChart") ;
}

function plotYearlyByDay_AverageItemsPerOrder_LineChart($DBConnection, $Year, $DivId){
    plotYearlyVariableLineChart($DBConnection, $Year, $DivId, "avg_itemqt_perday",
        "Average number of items ordered per day for $Year", "Average no of Items", "drawMonthlyByDayAverageItemsOrderedLineChart");

}

function plotYearlyByDay_MaxMinItemsPerOrder_LineChart($DBConnection, $Year, $DivId){
    plotYearlyVariable2LineChart($DBConnection, $Year, $DivId, "maxmin_itemqt_perday",
        "Max/Min ItemQuantity Ordered Per Order per day for $Year",
        "Maximum ItemQuantity Per Order", "Minimum ItemQuantity Per Order", "drawMonthlyByDayMaxMinOrderpriceLineChart") ;

}






    /*
     * Monthly Variable Column Charts
     */



function plotVariableColumnChart($DBConnection, $Year, $DivId, $Variable, $Heading, $VariableName, $functionName){
    $Query = "SELECT `$Variable` FROM `yearly_charts_analysis` WHERE `year` = '$Year'  " ;
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

                data.addRows(".$DataString.");

                // Set chart options
                var options = {
                    'title':'".$Heading."',
                    'width':1000,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'pointSize' : 1,
                    'curveType': 'function',
                    'legend': { 'position': 'bottom' },
                    'animation':{'startup':true,
                                    'easing':'inAndOut',
                                     'duration':500}

                    };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.ColumnChart(document.getElementById('".$DivId."'));
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




function plotYearlyByMonth_TotalSale_ColumnChart($DBConnection, $Year, $DivId){
    plotVariableColumnChart($DBConnection, $Year, $DivId, "total_sale_permonth",
        "Total sales per month for $Year", "Total Sale", "drawYearlyByMonthTotalSaleColumnChart") ;
}

function plotYearlyByMonth_AvgDailySale_ColumnChart($DBConnection, $Year, $DivId){
    plotVariableColumnChart($DBConnection, $Year, $DivId, "avg_dailysale_permonth",
        "Average Daily Sale per month for $Year", "Average Sale", "drawYearlyByMonthTotalSaleColumnChart") ;
}

function plotYearlyByMonth_AvgOrderPrice_ColumnChart($DBConnection, $Year, $DivId){
    plotVariableColumnChart($DBConnection, $Year, $DivId, "avg_orderprice_permonth",
        "Average OrderPrice per month for $Year", "Average OrderPrice", "drawYearlyByMonthTotalSaleColumnChart") ;
}




function plotYearlyByMonth_TotalItemQt_ColumnChart($DBConnection, $Year, $DivId){
    plotVariableColumnChart($DBConnection, $Year, $DivId, "total_itemqt_permonth",
        "Total ItemQt sold per month for $Year", "Total ItemQt", "drawYearlyByMonthTotalSaleColumnChart") ;
}

function plotYearlyByMonth_AvgDailyItemQt_ColumnChart($DBConnection, $Year, $DivId){
    plotVariableColumnChart($DBConnection, $Year, $DivId, "avg_dailyitemqt_permonth",
        "Average ItemQt sold daily per month for $Year", "Average ItemQt", "drawYearlyByMonthTotalSaleColumnChart") ;
}

function plotYearlyByMonth_AvgItemQtPerOrder_ColumnChart($DBConnection, $Year, $DivId){
    plotVariableColumnChart($DBConnection, $Year, $DivId, "avg_itemqt_perorder_permonth",
        "Average ItemQt sold in 1 order per month for $Year", "Average ItemQt", "drawYearlyByMonthTotalSaleColumnChart") ;
}




function plotYearlyByMonth_TotalOrder_ColumnChart($DBConnection, $Year, $DivId){
    plotVariableColumnChart($DBConnection, $Year, $DivId, "total_orders_permonth",
        "Total Orders per month for $Year", "Total Orders", "drawYearlyByMonthTotalSaleColumnChart") ;
}

function plotYearlyByMonth_AvgDailyNoOfOrder_ColumnChart($DBConnection, $Year, $DivId){
    plotVariableColumnChart($DBConnection, $Year, $DivId, "avg_nooforders_permonth",
        "Average No. of Orders Daily per month for $Year", "Average Orders", "drawYearlyByMonthTotalSaleColumnChart") ;
}




?>