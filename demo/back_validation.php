<?php
require_once '../vendor/autoload.php' ;


use Respect\Validation\Validator as v;

//if(v::stringType()->length(10, 20)->validate('my-username uolo')){
//    echo "this is true" ;
//} else {
//    echo "this is false" ;
//}






/*
 *  Regex for item name
 *      /^[\w\s\-\.',]+$/
 *
 * Regex for item name abbr
 *      same as item name
 *
 * regex for item description
 * 
 *
 * Regex for item price
 *      /^\d+\.?\d+$/
 *
 * Regex for some numeric id
 *      /^\d+$/
 *
 *
 */

$String = "abc yolo's" ;
$Regex = "/^[-\.'\w\s]+$/" ;

if(preg_match($Regex, $String)){
    echo "this is true" ;
} else {
    echo "this is false" ;
}















?>