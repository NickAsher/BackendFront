<?php


function isSecure_checkPostInput($Input){
    if(  !isset($_POST[$Input]) || empty($_POST[$Input])  ){
        die("Security errory : The input value   \$_POST['$Input']  is empty ") ;
    } else {
        return $_POST[$Input] ;
    }
}

function isSecure_checkGetInput($Input){
    if(  !isset($_GET[$Input]) || empty($_GET[$Input])  ){
        die("Security errory : The input value   \$_GET['$Input']  is empty ") ;
    } else {
        return $_GET[$Input] ;
    }
}


?>