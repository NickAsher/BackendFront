<?php

function getRedColorArray(){
    $RedColorArray = array('#B71C1C', '#D32F2F', '#F44336', '#ff4336') ;
    return $RedColorArray ;
}

function getBlueColorArray(){
    $BlueColorArray = array('#0D47A1', '#1976D2', '#2196F3', '#2196ff') ;
    return $BlueColorArray ;
}


function getRedGreen_Output_Table($Value1, $Value2){
    $ReturnString = '' ;
    if($Value1 >= $Value2){
        $ReturnString = "{v: +1, f: '".number_format($Value1)."'}  , {v: -1, f: '".number_format($Value2)."'}" ;
    } else {
        $ReturnString = "{v: -1, f: '".number_format($Value1)."'}  , {v: +1, f: '".number_format($Value2)."'}" ;

    }
    return $ReturnString ;

}

function getRedGreen_Output($Value1, $Value2){
    $ReturnString = '' ;
    if($Value1 >= $Value2){

        $ReturnString[0] = "<div class='text-success'> ".number_format($Value1)." </div>" ;
        $ReturnString[1] = "<div class='text-danger' > ".number_format($Value2)."</div>" ;

    } else {
        $ReturnString[0] = "<div class='text-danger' > ".number_format($Value1)."</div>" ;
        $ReturnString[1] = "<div class='text-success'> ".number_format($Value2)."</div>" ;

    }
    return $ReturnString ;
}


function getRedGreen_Output_Money($Value1, $Value2){
    $ReturnString = '' ;
    if($Value1 >= $Value2){

        $ReturnString[0] = "<div class='text-success'> $ ".number_format($Value1)." </div>" ;
        $ReturnString[1] = "<div class='text-danger'>$ ".number_format($Value2)."</div>" ;

    } else {
        $ReturnString[0] = "<div class='text-danger'>$ ".number_format($Value1)."</div>" ;
        $ReturnString[1] = "<div class='text-success'>$ ".number_format($Value2)."</div>" ;

    }
    return $ReturnString ;
}






?>