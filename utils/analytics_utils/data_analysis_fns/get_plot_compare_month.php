<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/analytics_utils/utility.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/backend_utils.php' ;


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



/* **************************  Category Stats ****************** */

function plotCompareMonths_CategoryStats_ColumnChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId){
    $Query1 = "SELECT `category_stats` FROM `monthly_charts_analysis` WHERE `month` = '$Month1' AND `year` = '$Year1'  " ;
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

    $Query2 = "SELECT `category_stats` FROM `monthly_charts_analysis` WHERE `month` = '$Month2' AND `year` = '$Year2'  " ;
    $QueryResult2 = mysqli_query($DBConnectionTest, $Query2) ;
    $DataString2 = '' ;
    if($QueryResult2){
        foreach($QueryResult2 as $Record){
            $DataString2 = $Record['category_stats'] ;
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


    $Length = count($DataArray1) ;

    $DataString3 = "[" ;
    for($i=0;$i<$Length;$i++){
        $CurrentCategory_Day1 = $DataArray1[$i] ;
        $CurrentCategory_Day2 = $DataArray2[$i] ;

        $CurrentCategory_Name = $CurrentCategory_Day1[0] ; // $CurrentCategory_Day1[0] is same as $CurrentCategory_Day2[0]

        $CurrentCategory_Day1_Qt = $CurrentCategory_Day1[1] ;
        $CurrentCategory_Day2_Qt = $CurrentCategory_Day2[1] ;

//        datastring = ['pizza', 23, '#someBlue', 48, '#someRed'] ;
        $DataString3.= "['$CurrentCategory_Name', $CurrentCategory_Day1_Qt, '".getBlueColorArray()[$i]."' , $CurrentCategory_Day2_Qt, '".getRedColorArray()[$i]."' ], " ;

    }
    $DataString3 = rtrim($DataString3, ',') ;
    $DataString3 = $DataString3."]" ;

    //echo $DataString3 ;




    echo "
            <script type='text/javascript'>

            function drawCompareMonth_CategoryStat_ColumnChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', '".getFullMonthName($Month1).", $Year1');
                data.addColumn({type:'string', role:'style'})
                data.addColumn('number', '".getFullMonthName($Month1).", $Year1');
                data.addColumn({type:'string', role:'style'})

                
                data.addRows($DataString3);

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
                var chart = new google.visualization.ColumnChart(document.getElementById('$DivId'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawCompareMonth_CategoryStat_ColumnChart);

        </script>
        " ;



}




function plotCompareMonths_CategoryStats_PieChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId1, $DivId2, $ColorAr1, $ColorAr2) {
    /*
     *
     */


    $Query1 = "  SELECT `category_stats` FROM `monthly_charts_analysis` WHERE `month` = '$Month1' AND `year` = '$Year1' "    ;
    $QueryResult1 = mysqli_query($DBConnectionTest, $Query1);

    $ItemStatString1 = null ;
    $ColorString1 = '[' ;


    foreach ($QueryResult1 as $Record) {
        $ItemStatString1 = $Record['category_stats'];
    }
    $ItemStatArray1 = json_decode($ItemStatString1) ;
    //var_dump($ItemStatArray) ;



    $i = 0 ;
    foreach ($ItemStatArray1 as $Record){
        $ColorString1 .= " '".$ColorAr1[$i]."'," ;
        $i++ ;
    }
    $ColorString1 = rtrim($ColorString1, ',') ;
    $ColorString1 = $ColorString1."]" ;



    $Query2 = "  SELECT `category_stats` FROM `monthly_charts_analysis` WHERE `month` = '$Month2' AND `year` = '$Year2' "    ;
    $QueryResult2 = mysqli_query($DBConnectionTest, $Query2);

    $ItemStatString2 = null ;
    $ColorString2 = '[' ;


    foreach ($QueryResult2 as $Record) {
        $ItemStatString2 = $Record['category_stats'];
    }
    $ItemStatArray2 = json_decode($ItemStatString2) ;
    //var_dump($ItemStatArray) ;



    $j = 0 ;
    foreach ($ItemStatArray2 as $Record){
        $ColorString2 .= " '".$ColorAr2[$j]."'," ;
        $j++ ;
    }
    $ColorString2 = rtrim($ColorString2, ',') ;
    $ColorString2 = $ColorString2."]" ;





    //echo "$DataString1 <br> $ColorString1 <br><br><br> $DataString2 <br> $ColorString2" ;






    echo "
            <script type='text/javascript'>

            function drawCompareMonthly_CategoryStat_PieChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', 'yoloyoloylyoylo');
                data.addRows($ItemStatString1);

                // Set chart options
                var options = {
                'title' : 'Category Wise Breakdown of Sales for ".getFullMonthName($Month1).", $Year1',
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
                
                var data2 = new google.visualization.DataTable();
                data2.addColumn('string', 'Category');
                data2.addColumn('number', 'yoloyoloylyoylo');
                data2.addRows($ItemStatString2);


                // Set chart options
                var options2 = {
                'title' : 'Category Wise Breakdown of Sales for ".getFullMonthName($Month2).", $Year2',
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

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('".$DivId1."'));
                chart.draw(data, options);
                var chart2 = new google.visualization.PieChart(document.getElementById('".$DivId2."'));
                chart2.draw(data2, options2);
            }

            google.charts.setOnLoadCallback(drawCompareMonthly_CategoryStat_PieChart);

        </script>
        " ;

}



/* *************************************** Item Stats ****************************************************** */


function plotCompareMonths_ItemStats_ColumnChart($DBConnectionBackend, $DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId){
    $Query1 = "SELECT `item_stats_o_id` FROM `monthly_charts_analysis` WHERE `month` = '$Month1' AND `year` = '$Year1'  " ;
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

    $Query2 = "SELECT `item_stats_o_id` FROM `monthly_charts_analysis` WHERE `month` = '$Month2' AND `year` = '$Year2'  " ;
    $QueryResult2 = mysqli_query($DBConnectionTest, $Query2) ;
    $DataString2 = '' ;
    if($QueryResult2){
        foreach($QueryResult2 as $Record){
            $DataString2 = $Record['item_stats_o_id'] ;
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

            function drawCompareMonth_ItemStat_ColumnChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', '".getFullMonthName($Month1).", $Year1');
                data.addColumn('number', '".getFullMonthName($Month2).", $Year2');

                
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

            google.charts.setOnLoadCallback(drawCompareMonth_ItemStat_ColumnChart);

        </script>
        " ;



}







/* ****************************************** Numerical Stats *************************************************** */


function plotCompareMonth_NumericalStats_TableChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId){
    $Query = " SELECT *  FROM `monthly_analysis` WHERE `month` = '$Month1' AND `year` = '$Year1'   ";
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



    $Query2 = " SELECT *  FROM `monthly_analysis` WHERE `month` = '$Month2' AND `year` = '$Year2'    ";
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
        ['Average Sale of a Day ',  ".getRedGreen_Output_Table($Stats1['avg_sale_per_day'], $Stats2['avg_sale_per_day'] )." ],
        ['Average OrderPrice per Order for Month',  ".getRedGreen_Output_Table($Stats1['avg_saleprice_per_order'], $Stats2['avg_saleprice_per_order'] )." ],
        
        ['Total Orders',        ".getRedGreen_Output_Table($Stats1['total_orders'], $Stats2['total_orders'] )." ],
        ['Average No of Orders in a Day',  ".getRedGreen_Output_Table($Stats1['avg_orders_per_day'], $Stats2['avg_orders_per_day'] )." ],

        ['Total Item Quantity sold in Month', ".getRedGreen_Output_Table($Stats1['total_itemqt'], $Stats2['total_itemqt'] )." ],
        ['Average Item Quantity per Order', ".getRedGreen_Output_Table($Stats1['avg_itemqt_per_order'], $Stats2['avg_itemqt_per_order'] )." ],
        ['Maximum Item Quantity per Day', ".getRedGreen_Output_Table($Stats1['avg_itemqt_per_day'], $Stats2['avg_itemqt_per_day'] )." ],
        ]";

    //echo $DataString ;

    echo "
            <script type='text/javascript'>

            function drawCompareMonth_NumericalStats_TableChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', '".getFullMonthName($Month1).", $Year1');
                data.addColumn('number', '".getFullMonthName($Month2).", $Year2');

                
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

            google.charts.setOnLoadCallback(drawCompareMonth_NumericalStats_TableChart);

        </script>
        " ;











}






function plotCompareMonths_Variable_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId,
                                              $Variable, $Heading, $functionName){


    $Query1 = "SELECT `$Variable` FROM `monthly_charts_analysis` WHERE `month` = '$Month1' AND `year` = '$Year1'  " ;
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

    $Query2 = "SELECT `$Variable` FROM `monthly_charts_analysis` WHERE `month` = '$Month2' AND `year` = '$Year2'  " ;
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
                data.addColumn('number', '".getFullMonthName($Month1).", $Year1');
                data.addColumn({type:'string', role:'style'});
                 data.addColumn('number', '".getFullMonthName($Month2).", $Year2');
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




function plotCompareMonths_TotalSale_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId){
    plotCompareMonths_Variable_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId,
        'total_sale_perday', "Total Sale comparison for 2 Months","drawCompareMonths_TotalSale_LineChart") ;
}

function plotCompareMonths_AverageOrderPrice_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId){
    plotCompareMonths_Variable_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId,
        'avg_orderprice_perday', "Average OrderPrice comparison for 2 Months","drawCompareMonths_AverageOrderPrice_LineChart") ;
}



function plotCompareMonths_TotalOrders_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId){
    plotCompareMonths_Variable_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId,
        'total_orders_perday', "Total Orders comparison for 2 Months","drawCompareMonths_TotalOrders_LineChart") ;
}



function plotCompareMonths_TotalItemQt_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId){
    plotCompareMonths_Variable_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId,
        'total_itemqt_perday', "Total ItemQuantity sold, comparison for 2 Months","drawCompareMonths_TotalItemQt_LineChart") ;
}

function plotCompareMonths_AverageItemQtPerOrder_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId){
    plotCompareMonths_Variable_LineChart($DBConnectionTest, $Month1, $Year1, $Month2, $Year2, $DivId,
        'avg_itemqt_perday', "Average no. of items per Order, comparison for 2 Months","drawCompareMonths_AverageItemQtPerOrder_LineChart") ;
}


















?>