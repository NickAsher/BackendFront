<?php

function validate_isNumber($Data){
    $RegularExpression = "/^[0-9]+\$/" ;


    if( preg_match($RegularExpression, $Data) ){
        return true ;
    } else {
        return false ;
    }

}


function validate_isLettersSpace($Data){

}