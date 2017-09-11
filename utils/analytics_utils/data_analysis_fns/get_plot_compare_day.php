<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/analytics_utils/utility.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/BackendFront/utils/backend_utils.php' ;

function getDailyStats($DBConnection, $Date){

    /*
     * Returns the stats for a specific day
     * returns it as a column named `total`
     */


    $Query = " SELECT *  FROM `daily_analysis` WHERE `date` = '".$Date."'   ";
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





function plotCompareDay_OrdersSale_LineChart($DBConnectionTest, $Date1, $Date2, $DivId){

    $Query1 = "SELECT * FROM `daily_charts_analysis` WHERE `date` = '$Date1'  " ;
    $QueryResult1 = mysqli_query($DBConnectionTest, $Query1) ;
    $DataString1 = '' ;
    if($QueryResult1){
        foreach($QueryResult1 as $Record){
            $DataString1 = $Record['sale_time_perorder'] ;
        }


        $DataArray1 = json_decode($DataString1) ;



    } else {
        echo "Problem in fetching data <br>  ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }


    $Query2 = "SELECT * FROM `daily_charts_analysis` WHERE `date` = '$Date2'  " ;
    $QueryResult2 = mysqli_query($DBConnectionTest, $Query2) ;
    $DataString2 = '' ;
    if($QueryResult2){
        foreach($QueryResult2 as $Record){
            $DataString2 = $Record['sale_time_perorder'] ;
        }


        $DataArray2 = json_decode($DataString2) ;



    } else {
        echo "Problem in fetching data <br>  ".mysqli_error($DBConnectionTest) ;
        return -1 ;
    }


    $Length1 = count($DataArray1) ;
    $Length2 = count($DataArray2) ;


    $DataString3 = "[" ;
    // The logic here is this, Let's say we have two days Da with 20 orders and Db with 10 orders
    // Now we want a string like this for two days
    // [ [1,Da.1, Db.1], [2,Da.2, Db.2] ..... [10, Da.10, Db.10], [11, Da.11, 0], [12, Da.12, 0], ..... [20, Da.20, 0], ]
    //
    // See that we use 0 for entries of those days with less number of orders.
    //
    //


    if($Length1 >= $Length2){
                $i = 0 ;

                // while i variable is less than bigger length
                while ($i<$Length1){
                    $j = $i + 1 ;
                        // for smaller length we use the normal sale time line chart
                        // in other case we use zero instead of the value.
                        if($i < $Length2){
                            $DataString3.= "[ '$j', ".$DataArray1[$i][1]." , ".$DataArray2[$i][1]."  ]," ;
                        }
                        else {
                            $DataString3.= "[ '$j', ".$DataArray1[$i][1]." , 0  ]," ;
                        }

                        $i ++ ;
                }


    } else {
                $i = 0 ;
                while ($i<$Length2){
                    $j = $i+1 ;
                        if($i < $Length1){
                            $DataString3.= "[ '$j', ".$DataArray1[$i][1]." , ".$DataArray2[$i][1]."  ]," ;
                        }
                        else {
                            $DataString3.= "[ '$j', 0 , ".$DataArray2[$i][1]."  ]," ;
                        }

                        $i ++ ;
                }
    }

    $DataString3 = rtrim($DataString3, ",") ;
    $DataString3.= "]" ;

    //echo $DataString3 ;


    echo "
            <script type='text/javascript'>

            function drawCompareDay_OrderSale_LineChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', '$Date1 ');
                data.addColumn('number', '$Date2 ');

                
                data.addRows(".$DataString3."
                );

                // Set chart options
                var options = {
                    'title' : 'Order Sale Chart, Comparison for the 2 days',
                    'backgroundColor' : {
                        'fill' : '#ffffff',
                        'fillOpacity' : '0',
                    },
                    'pointSize' : 2,
                    'curveType': 'function',
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
                var chart = new google.visualization.LineChart(document.getElementById('".$DivId."'));
                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawCompareDay_OrderSale_LineChart);

        </script>
        " ;

}




function plotCompareDay_CategoryStats_ColumnChart($DBConnectionTest, $Date1, $Date2,  $DivId){
    $Query1 = "SELECT `category_stats` FROM `daily_charts_analysis` WHERE `date` = '$Date1'  " ;
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

    $Query2 = "SELECT `category_stats` FROM `daily_charts_analysis` WHERE `date` = '$Date2' " ;
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

            function drawCompareDay_CategoryStat_ColumnChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', '$Date1');
                data.addColumn({type:'string', role:'style'})
                data.addColumn('number', '$Date2');
                data.addColumn({type:'string', role:'style'})


                
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

            google.charts.setOnLoadCallback(drawCompareDay_CategoryStat_ColumnChart);

        </script>
        " ;



}



function plotCompareDay_CategoryStats_PieChart($DBConnectionTest, $Date1, $Date2, $DivId1, $DivId2, $ColorAr1, $ColorAr2) {
    /*
     *
     */
    $Query1 = "  SELECT `category_stats` FROM `daily_charts_analysis` WHERE `date` = '$Date1'  ";
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



    $Query2 = "  SELECT `category_stats` FROM `daily_charts_analysis` WHERE `date` = '$Date2'  ";
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

            function drawDaily_CategoryStat_PieChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', 'Total Sale');
                data.addRows($ItemStatString1);

                // Set chart options
                var options = {
                'title' : 'Category Wise Breakdown of Sales for $Date1',
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
                data2.addColumn('number', 'Total Sale');
                data2.addRows($ItemStatString2);

                // Set chart options
                var options2 = {
                'title' : 'Category Wise Breakdown of Sales for $Date2',
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
                var chart = new google.visualization.PieChart(document.getElementById('$DivId1'));
                chart.draw(data, options);
                var chart2 = new google.visualization.PieChart(document.getElementById('$DivId2'));
                chart2.draw(data2, options2);
            }

            google.charts.setOnLoadCallback(drawDaily_CategoryStat_PieChart);

        </script>
        " ;

}





function plotCompareDay_ItemStats_ColumnChart($DBConnectionBackend, $DBConnectionTest,  $Date1, $Date2, $DivId){
    $Query1 = "SELECT `item_stats_o_id` FROM `daily_charts_analysis` WHERE `date` = '$Date1'  " ;
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

    $Query2 = "SELECT `item_stats_o_id` FROM `daily_charts_analysis` WHERE `date` = '$Date2'  " ;
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

        $CurrentItem_Day1 = $DataArray1[$i] ;
        $CurrentItem_Day2 = $DataArray2[$i] ;

        $CurrentItem_Day1_Qt = $CurrentItem_Day1[1] ;
        $CurrentItem_Day2_Qt = $CurrentItem_Day2[1] ;


        $DataString3.= "['$ItemName', $CurrentItem_Day1_Qt , $CurrentItem_Day2_Qt ], " ;

    }
    $DataString3 = rtrim($DataString3, ',') ;
    $DataString3 = $DataString3."]" ;


    //echo $DataString3 ;


    echo "
            <script type='text/javascript'>

            function drawCompareDay_ItemStat_ColumnChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', '$Date1');
                data.addColumn('number', '$Date2');

                
                data.addRows(".$DataString3."
                );

                // Set chart options
                var options = {
                
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

            google.charts.setOnLoadCallback(drawCompareDay_ItemStat_ColumnChart);

        </script>
        " ;



}






function plotCompareDay_NumericalStats_TableChart($DBConnectionTest, $Date1, $Date2, $DivId){
    $Query = " SELECT *  FROM `daily_analysis` WHERE `date` = '$Date1'   ";
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



    $Query2 = " SELECT *  FROM `daily_analysis` WHERE `date` = '$Date2'   ";
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
        ['Total Sale',          ".getRedGreen_Output_Table($Stats1['total_sale'], $Stats2['total_sale'] )." ],
        ['Average OrderPrice',  ".getRedGreen_Output_Table($Stats1['avg_orderprice'], $Stats2['avg_orderprice'] )." ],
        ['Max OrderPrice',      ".getRedGreen_Output_Table($Stats1['max_orderprice'], $Stats2['max_orderprice'] )." ],
        ['Total Orders',        ".getRedGreen_Output_Table($Stats1['total_orders'], $Stats2['total_orders'] )." ],
        ['Total Item Quantity', ".getRedGreen_Output_Table($Stats1['total_itemqt'], $Stats2['total_itemqt'] )." ],
        ['Average Item Quantity per Order', ".getRedGreen_Output_Table($Stats1['avg_itemqt'], $Stats2['avg_itemqt'] )." ],
        ['Maximum Item Quantity per Order', ".getRedGreen_Output_Table($Stats1['max_itemqt'], $Stats2['max_itemqt'] )." ],
        ]";

    //echo $DataString ;

    echo "
            <script type='text/javascript'>

            function drawCompareDay_NumericalStats_TableChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Category');
                data.addColumn('number', '$Date1');
                data.addColumn('number', '$Date2');

                
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

                
                  
                    
                    var chart = new google.visualization.Table(document.getElementById('$DivId'));
                    chart.draw(data, options);
        
                
            }

            google.charts.setOnLoadCallback(drawCompareDay_NumericalStats_TableChart);

        </script>
        " ;


        

        
    





}






?>