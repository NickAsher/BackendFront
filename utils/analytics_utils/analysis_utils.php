<?php

function getMonthName($MonthNumber){
    switch($MonthNumber){
        case 1:
            return "Jan" ;
        case 2:
            return "Feb" ;
        case 3:
            return "Mar" ;
        case 4:
            return "Apr" ;
        case 5:
            return "May" ;
        case 6:
            return "Jun" ;
        case 7:
            return "Jul" ;
        case 8:
            return "Aug" ;
        case 9:
            return "Sep" ;
        case 10:
            return "Oct" ;
        case 11:
            return "Nov" ;
        case 12:
            return "Dec" ;
        default :
            return "Unknown" ;
    }
}

    function getColorArray(){
        $ColorArray = array(
            '#1CA8DD', //Blue
            '#1BC98E', //Green
            '#e4d836', // Yellow
            '#9f86ff', // Purple
            '#e64759', // Red
            '#1CA8DD', //Blue
            '#1BC98E', //Green
            '#e4d836', // Yellow
            '#9f86ff', // Purple
            '#e64759', // Red
            '#1CA8DD', //Blue
            '#1BC98E', //Green
            '#e4d836', // Yellow
            '#9f86ff', // Purple
            '#e64759', // Red

        ) ;
        return $ColorArray ;
    }

    function getMaterialColorArry(){
        $ColorArray = array(
            '#FF5252', //Red Accent
            '#E040FB', //Purple Accent
            '#EEFF41', // Yellow
            '#18FFFF', // Cyan Accent
            '#e64759', // Red
            '#1CA8DD', //Blue
            '#1BC98E', //Green
            '#e4d836', // Yellow
            '#9f86ff', // Purple
            '#e64759', // Red
            '#1CA8DD', //Blue
            '#1BC98E', //Green
            '#e4d836', // Yellow
            '#9f86ff', // Purple
            '#e64759', // Red

        ) ;
    }



    function getDataPointStyle($Promotion_No){
        $Datapoint = '  ' ;
        if($Promotion_No == 0){
            $DataPoint = 'null' ;
        } else if($Promotion_No == 1) {
            $DataPoint = 'point { size: 18; shape-type: star; fill-color: #ff0000; }' ;
        }


        return $Datapoint ;
    }


?>