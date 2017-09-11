<?php

function getThreeCharMonthName($MonthNumber){
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




function getFullMonthName($MonthNumber){
    switch($MonthNumber){
        case 1:
            return "January" ;
        case 2:
            return "February" ;
        case 3:
            return "March" ;
        case 4:
            return "April" ;
        case 5:
            return "May" ;
        case 6:
            return "June" ;
        case 7:
            return "July" ;
        case 8:
            return "August" ;
        case 9:
            return "September" ;
        case 10:
            return "October" ;
        case 11:
            return "November" ;
        case 12:
            return "December" ;
        default :
            return "Unknown" ;
    }

}

function getFullDateString($Date){
    $Day = explode("-", $Date)[2] ;
    $Month = explode("-", $Date)[1] ;
    $Year = explode("-", $Date)[0] ;

    $DateString = getFullMonthName($Month)." ".$Day.", ".$Year ;
    return $DateString ;
}






?>