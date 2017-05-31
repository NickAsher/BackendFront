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





function plotCompareYear_CategoryStats_ColumnPieChart($DBConnectionTest, $Year1, $Year2, $DivId1, $DivId2, $DivId3, $ColorAr1, $ColorAr2){
    $Query1 = "SELECT `category_stats` FROM `yearly_charts_analysis` WHERE `year` = '$Year1'  " ;
    $QueryResult1 = mysqli_query($DBConnectionTest, $Query1) ;
    $DataString1 = '' ;
    if($QueryResult1){
        foreach($QueryResult1 as $Record){
            $DataString1 = $Record['category_stats'] ;
        }


        $DataArray1 = json_decode($DataString1) ;



    } else {
        echo "Problem in fetching data <br>  ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }

    $Query2 = "SELECT `category_stats` FROM `yearly_charts_analysis` WHERE `year` = '$Year2'  " ;
    $QueryResult2 = mysqli_query($DBConnectionTest, $Query2) ;
    $DataString2 = '' ;
    if($QueryResult2){
        foreach($QueryResult2 as $Record){
            $DataString2 = $Record['category_stats'] ;
        }
        $DataArray2 = json_decode($DataString2) ;

    } else {
        echo "Problem in fetching Category Stats <br>  ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }


//    echo $DataString1 ;
//    echo "<br><br>" ;
//    echo $DataString2 ;
//    echo "<br><br>" ;


    $Length = count($DataArray1) ;

    $DataString3 = "[" ;
    $DataStringP1 = "[" ;
    $DataStringP2 = "[" ;
    $ColorString1 = "[" ;
    $ColorString2 = "[" ;
    for($i=0;$i<$Length;$i++){
        $DataString3.= "['".$DataArray1[$i][0]."', ".$DataArray1[$i][1].", '".$ColorAr1[$i]."', ".$DataArray2[$i][1].", '".$ColorAr2[$i]."' ]," ;
        $DataStringP1.= "['".$DataArray1[$i][0]."', ".$DataArray1[$i][1]."  ]," ;
        $ColorString1.= " '".$ColorAr1[$i]."' ," ;
        $DataStringP2.= "['".$DataArray2[$i][0]."', ".$DataArray2[$i][1]."  ]," ;
        $ColorString2.= " '".$ColorAr2[$i]."' ," ;


    }
    $DataString3 = rtrim($DataString3, ',') ;
    $DataString3 = $DataString3."]" ;
    $DataStringP1 = rtrim($DataStringP1, ',') ;
    $DataStringP1 = $DataStringP1."]" ;
    $DataStringP2 = rtrim($DataStringP2, ',') ;
    $DataStringP2 = $DataStringP2."]" ;
    $ColorString1 = rtrim($ColorString1, ',') ;
    $ColorString1 = $ColorString1."]" ;
    $ColorString2 = rtrim($ColorString2, ',') ;
    $ColorString2 = $ColorString2."]" ;

    //echo "$DataString3 <br><br> $DataStringP1 <br><br> $DataStringP2 <br><br> $ColorString1 <br><br> $ColorString2 <br><br>  " ;







    //echo $DataString3 ;


    echo "
            <script type='text/javascript'>

            function drawCompareYear_CategoryStat_ColumnPieChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', '$Year1');
                data.addColumn({type:'string', role:'style'})
                data.addColumn('number', '$Year2');
                data.addColumn({type:'string', role:'style'})           
                data.addRows(".$DataString3.");

                // Set chart options
                var options = {
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
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
                
                var data2 = new google.visualization.DataTable();
                data2.addColumn('string', 'Category');
                data2.addColumn('number', 'yoloyoloylyoylo');
                data2.addRows(".$DataStringP1."
                );

                // Set chart options
                var options2 = {
                'title' : 'Category Wise Breakdown of Sales for $Year1',
                'width' : 450,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'legend' : {
                        'position' : 'left'
                    },
                    'colors': $ColorString1
                    

                };
                
                var data3 = new google.visualization.DataTable();
                data3.addColumn('string', 'Category');
                data3.addColumn('number', 'yoloyoloylyoylo');
                data3.addRows(".$DataStringP2."
                );

                // Set chart options
                var options3 = {
                'title' : 'Category Wise Breakdown of Sales for  $Year2',
                'width' : 450,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0'
                    },
                    'legend' : {
                        'position' : 'left'
                    },
                    'colors': $ColorString2
                    

                };

                
                
                
                

                var chart = new google.visualization.ColumnChart(document.getElementById('".$DivId1."'));
                chart.draw(data, options);
                var chart2 = new google.visualization.PieChart(document.getElementById('".$DivId2."'));
                chart2.draw(data2, options2);
                var chart3 = new google.visualization.PieChart(document.getElementById('".$DivId3."'));
                chart3.draw(data3, options3);
            }

            google.charts.setOnLoadCallback(drawCompareYear_CategoryStat_ColumnPieChart);

        </script>
        " ;



}




function plotCompareYear_ItemStats_ColumnChart($DBConnectionBackend, $DBConnectionTest, $Year1, $Year2, $DivId){
    $Query1 = "SELECT `item_stats_o_id` FROM `yearly_charts_analysis` WHERE `year` = '$Year1'  " ;
    $QueryResult1 = mysqli_query($DBConnectionTest, $Query1) ;
    $DataString1 = '' ;
    if($QueryResult1){
        foreach($QueryResult1 as $Record){
            $DataString1 = $Record['item_stats_o_id'] ;
        }


        $DataArray1 = json_decode($DataString1) ;



    } else {
        echo "Problem in fetching data <br>  ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }

    $Query2 = "SELECT `item_stats_o_id` FROM `yearly_charts_analysis` WHERE `year` = '$Year2'  " ;
    $QueryResult2 = mysqli_query($DBConnectionTest, $Query2) ;
    $DataString2 = '' ;
    if($QueryResult2){
        foreach($QueryResult2 as $Record){
            $DataString2 = $Record['item_stats_o_id'] ;
        }
        $DataArray2 = json_decode($DataString2) ;

    } else {
        echo "Problem in fetching Item Stats <br>  ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }


//    echo $DataString1 ;
//    echo "<br><br>" ;
//    echo $DataString2 ;
//    echo "<br><br>" ;


    $Length = count($DataArray1) ;

    $DataString3 = "[" ;
    for($i=0;$i<$Length;$i++){
        $ItemId = $DataArray1[$i][0] ;
        $ItemName = getItemInformation($DBConnectionBackend, $ItemId)['item_name'];

        $DataString3.= "['$ItemName', ".$DataArray1[$i][1]." , ".$DataArray2[$i][1]." ], " ;

    }
    $DataString3 = rtrim($DataString3, ',') ;
    $DataString3 = $DataString3."]" ;


    //echo $DataString3 ;


    echo "
            <script type='text/javascript'>

            function drawCompareYear_ItemStat_ColumnChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', '$Year1');
                data.addColumn('number', '$Year2');

                
                data.addRows(".$DataString3."
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
                var chart = new google.visualization.ColumnChart(document.getElementById('".$DivId."'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawCompareYear_ItemStat_ColumnChart);

        </script>
        " ;



}





function plotCompareYear_NumericalStats_TableChart($DBConnectionTest, $Year1, $Year2, $DivId){
    $Query = " SELECT *  FROM `yearly_analysis` WHERE `year` = '$Year1'   ";
    $QueryResult = mysqli_query($DBConnectionTest, $Query) ;
    if($QueryResult){

        $Stats1 = '' ;
        foreach($QueryResult as $Record){
            $Stats1 = $Record ;
        }


    } else {
        echo "<br> Problem in fetching Stats for this day" ;
        echo "<br> ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }



    $Query2 = " SELECT *  FROM `yearly_analysis` WHERE `year` = '$Year2'    ";
    $QueryResult2 = mysqli_query($DBConnectionTest, $Query2) ;
    if($QueryResult2){

        $Stats2 = '' ;
        foreach($QueryResult2 as $Record){
            $Stats2 = $Record ;
        }


    } else {
        echo "<br> Problem in fetching Stats for this day" ;
        echo "<br> ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }

    //var_dump($Stats1) ;


    $DataString = "[ 
        ['Total Sale in Month',          ".getRedGreen_Output_Table($Stats1['total_sale'], $Stats2['total_sale'] )." ],
        ['Average Sale in a Month ',  ".getRedGreen_Output_Table($Stats1['avg_totalsale_per_month'], $Stats2['avg_totalsale_per_month'] )." ],
        ['Average Sale in a day ',  ".getRedGreen_Output_Table($Stats1['avg_totalsale_per_day'], $Stats2['avg_totalsale_per_day'] )." ],
        ['Average OrderPrice per Order ',  ".getRedGreen_Output_Table($Stats1['avg_totalsale_per_order'], $Stats2['avg_totalsale_per_order'] )." ],
        
        ['Total Orders',        ".getRedGreen_Output_Table($Stats1['total_orders'], $Stats2['total_orders'] )." ],
        ['Average No of Orders in a Month',  ".getRedGreen_Output_Table($Stats1['avg_orders_per_month'], $Stats2['avg_orders_per_month'] )." ],
        ['Average No of Orders in a Day',  ".getRedGreen_Output_Table($Stats1['avg_orders_per_day'], $Stats2['avg_orders_per_day'] )." ],

        ['Total Item Quantity sold', ".getRedGreen_Output_Table($Stats1['total_item_quantity'], $Stats2['total_item_quantity'] )." ],
        ['Average Item Quantity sold in a Month', ".getRedGreen_Output_Table($Stats1['avg_itemqt_per_month'], $Stats2['avg_itemqt_per_month'] )." ],
        ['Average Item Quantity sold in a Day', ".getRedGreen_Output_Table($Stats1['avg_itemqt_per_day'], $Stats2['avg_itemqt_per_day'] )." ],
        ['Average Item Quantity sold per Order', ".getRedGreen_Output_Table($Stats1['avg_itemqt_per_order'], $Stats2['avg_itemqt_per_order'] )." ],

        
        ]";

    //echo $DataString ;

    echo "
            <script type='text/javascript'>

            function drawCompareYear_NumericalStats_TableChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', '$Year1');
                data.addColumn('number', '$Year2');

                
                data.addRows(".$DataString."
                );

                // Set chart options
                var options = {
                      showRowNumber: true,
                      width: '100%', 
                      height: '100%',
                      'allowHtml': true,
                      sort : 'disable'
                   };
                   
                   
                var formatter = new google.visualization.ColorFormat();
                formatter.addRange(-2, 0, 'red', 'null');
                formatter.addRange(0, 2, 'green', 'null');
                formatter.format(data, 1);
                formatter.format(data, 2);

                
                  
                    
                    var chart = new google.visualization.Table(document.getElementById('".$DivId."'));
                    chart.draw(data, options);
        
                
            }

            google.charts.setOnLoadCallback(drawCompareYear_NumericalStats_TableChart);

        </script>
        " ;











}






/* ************************************************* Daily Line Charts    ****************************************   */

function plotCompareYear_Daily_Variable_LineChart($DBConnectionTest, $Year1, $Year2, $DivId, $Variable, $Heading, $functionName){


    $Query1 = "SELECT `$Variable` FROM `yearly_charts_analysis` WHERE `year` = '$Year1'  " ;
    $QueryResult1 = mysqli_query($DBConnectionTest, $Query1) ;
    $DataString1 = '' ;
    if($QueryResult1){
        foreach($QueryResult1 as $Record){
            $DataString1 = $Record[$Variable] ;
        }

        $DataArray1 = json_decode($DataString1) ;

    } else {
        echo "Problem in fetching data <br>  ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }

    $Query2 = "SELECT `$Variable` FROM `yearly_charts_analysis` WHERE `year` = '$Year2'  " ;
    $QueryResult2 = mysqli_query($DBConnectionTest, $Query2) ;
    $DataString2 = '' ;
    if($QueryResult2){
        foreach($QueryResult2 as $Record){
            $DataString2 = $Record[$Variable] ;
        }
        $DataArray2 = json_decode($DataString2) ;

    } else {
        echo "Problem in fetching data $Variable <br>  ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }


//    echo $DataString1 ;
//    echo "<br><br>" ;
//    echo $DataString2 ;
//    echo "<br><br>" ;



    $DataString3 = '[' ;
    for($i = 0;$i<30;$i++) {
        $j = $i + 1 ;
        $DataString3 .= '[  "'.$j.'", '.$DataArray1[$i][1].', "'.$DataArray1[$i][2].'",
         '.$DataArray2[$i][1].', "'.$DataArray2[$i][2].'" ], ' ;
    }

    $DataString3 = rtrim($DataString3, ',') ;
    $DataString3 .= ']' ;

//    echo $DataString3 ;



    echo "
            <script type='text/javascript'>

            function ".$functionName."() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', '$Year1');
                data.addColumn({type:'string', role:'style'});
                 data.addColumn('number', '$Year2');
                data.addColumn({type:'string', role:'style'});

                data.addRows(".$DataString3.");

                // Set chart options
                var options = {
                    'title':'".$Heading."',
                    'width':1200,
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
                        'showTextEvery' : 5
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











}




function plotCompareYear_Daily_TotalSale_LineChart($DBConnectionTest, $Year1, $Year2, $DivId){
    plotCompareYear_Daily_Variable_LineChart($DBConnectionTest, $Year1, $Year2, $DivId,
        'total_sale_perday', "Total Sale comparison for 2 Years","drawCompareYear_Daily_TotalSale_LineChart") ;
}

function plotCompareYear_Daily_AverageOrderPrice_LineChart($DBConnectionTest, $Year1, $Year2, $DivId){
    plotCompareYear_Daily_Variable_LineChart($DBConnectionTest, $Year1, $Year2, $DivId,
        'avg_orderprice_perday', "Average OrderPrice comparison for 2 Years","drawCompareYear_Daily_AverageOrderPrice_LineChart") ;
}



function plotCompareYear_Daily_TotalOrders_LineChart($DBConnectionTest, $Year1, $Year2, $DivId){
    plotCompareYear_Daily_Variable_LineChart($DBConnectionTest, $Year1, $Year2, $DivId,
        'total_orders_perday', "Total Orders comparison for 2 Years","drawCompareYear_Daily_TotalOrders_LineChart") ;
}



function plotCompareYear_Daily_TotalItemQt_LineChart($DBConnectionTest, $Year1, $Year2, $DivId){
    plotCompareYear_Daily_Variable_LineChart($DBConnectionTest, $Year1, $Year2, $DivId,
        'total_itemqt_perday', "Total ItemQuantity sold, comparison for 2 Years","drawCompareYear_Daily_TotalItemQt_LineChart") ;
}

function plotCompareYear_Daily_AverageItemQtPerOrder_LineChart($DBConnectionTest, $Year1, $Year2, $DivId){
    plotCompareYear_Daily_Variable_LineChart($DBConnectionTest, $Year1, $Year2, $DivId,
        'avg_itemqt_perday', "Average no. of items per Order, comparison for 2 Years","drawCompareYear_Daily_AverageItemQtPerOrder_LineChart") ;
}

















function plotCompareYear_Month_Variable_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId, $Variable, $Heading, $functionName){
    $Query1 = "SELECT `$Variable` FROM `yearly_charts_analysis` WHERE `year` = '$Year1'  " ;
    $QueryResult1 = mysqli_query($DBConnectionTest, $Query1) ;
    $DataString1 = '' ;
    if($QueryResult1){
        foreach($QueryResult1 as $Record){
            $DataString1 = $Record[$Variable] ;
        }

        $DataArray1 = json_decode($DataString1) ;

    } else {
        echo "Problem in fetching data <br>  ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }

    $Query2 = "SELECT `$Variable` FROM `yearly_charts_analysis` WHERE `year` = '$Year2'  " ;
    $QueryResult2 = mysqli_query($DBConnectionTest, $Query2) ;
    $DataString2 = '' ;
    if($QueryResult2){
        foreach($QueryResult2 as $Record){
            $DataString2 = $Record[$Variable] ;
        }
        $DataArray2 = json_decode($DataString2) ;

    } else {
        echo "Problem in fetching data <br>  ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }


//    echo $DataString1 ;
//    echo "<br><br>" ;
//    echo $DataString2 ;
//    echo "<br><br>" ;



    $DataString3 = '[' ;
    for($i = 0;$i<12;$i++) {
        $j = $i+1 ;
        $DataString3 .= '[  "'.getMonthName($j).'", '.$DataArray1[$i][1].', '.$DataArray2[$i][1].' ],' ;
    }

    $DataString3 = rtrim($DataString3, ',') ;
    $DataString3 .= ']' ;

    //echo $DataString3."<br><br>" ;


    echo "
            <script type='text/javascript'>

            function $functionName() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Month Name');
                data.addColumn('number', '$Year1');
                data.addColumn('number', '$Year2');

                
                data.addRows(".$DataString3."
                );

                // Set chart options
                var options = {
                    'title' : '$Heading',
                     'width' : 1500,
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0',
                    },
                    'legend' : {
                        'position' : 'bottom'
                    },
                    
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
                var chart = new google.visualization.ColumnChart(document.getElementById('".$DivId."'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback($functionName);

        </script>
        " ;

}






function plotCompareYear_Month_TotalSale_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId) {
    plotCompareYear_Month_Variable_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId, 'total_sale_permonth',
        "Total Sale per Month, Comparison for $Year1 and $Year2 ", "drawCompareYear_Month_TotalSale_ColumnChart") ;

    }
function plotCompareYear_Month_AverageDailySale_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId) {
    plotCompareYear_Month_Variable_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId, 'avg_dailysale_permonth',
        "Average Daily Sale per Month, Comparison for $Year1 and $Year2 ", "drawCompareYear_Month_AverageDailySale_ColumnChart") ;

}
function plotCompareYear_Month_AverageOrderPrice_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId) {
    plotCompareYear_Month_Variable_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId, 'avg_orderprice_permonth',
        "Average OrderPrice per Month, Comparison for $Year1 and $Year2 ", "drawCompareYear_Month_AverageOrderPrice_ColumnChart") ;

}


function plotCompareYear_Month_TotalOrders_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId) {
    plotCompareYear_Month_Variable_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId, 'total_orders_permonth',
        "Total Orders per Month, Comparison for $Year1 and $Year2 ", "drawCompareYear_Month_TotalOrders_ColumnChart") ;

}
function plotCompareYear_Month_AverageNoOfOrders_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId) {
    plotCompareYear_Month_Variable_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId, 'avg_nooforders_permonth',
        "Average No of Orders per Month, Comparison for $Year1 and $Year2 ", "drawCompareYear_Month_AverageNoOfOrders_ColumnChart") ;

}


function plotCompareYear_Month_TotalItemQt_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId) {
    plotCompareYear_Month_Variable_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId, 'total_itemqt_permonth',
        "Total Item Quantity sold per Month, Comparison for $Year1 and $Year2 ", "drawCompareYear_Month_TotalItemQt_ColumnChart") ;

}
function plotCompareYear_Month_AverageDailyItemQt_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId) {
    plotCompareYear_Month_Variable_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId, 'avg_dailyitemqt_permonth',
        "Average Daily Item Quantity sold per Month,  Comparison for $Year1 and $Year2 ", "drawCompareYear_Month_AverageDailyItemQt_ColumnChart") ;

}
function plotCompareYear_Month_AvgItemQtPerOrder_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId) {
    plotCompareYear_Month_Variable_ColumnChart($DBConnectionTest, $Year1, $Year2, $DivId, 'avg_itemqt_perorder_permonth',
        "Average Item Quanity sold per Order per Month, Comparison for $Year1 and $Year2 ", "drawCompareYear_Month_AvgItemQtPerOrder_ColumnChart") ;

}














?>