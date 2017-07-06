<?php

//$String = "123" ;
//$RegularExpression = "/[-]?[0-9,]+\$/" ;


$String = "123" ;
$RegularExpression = "/^[0-9]+$/" ;


if( preg_match($RegularExpression, $String) ){
    echo "true" ;
} else {
    echo "false" ;
}

//if (preg_match("/php/i", "PHP is the web scripting language of choice.")) {
//    echo "A match was found.";
//} else {
//    echo "A match was not found.";
//}