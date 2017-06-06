<?php

require_once '../../../sql/sqlconnection.php' ;
//require_once 'refresh-utils.php' ;

$DBConnectionPlaygroung = YOLOSqlPlaygroundConnect();

mysqli_begin_transaction($DBConnectionPlaygroung) ;
try{
    $Query1 = "INSERT INTO `demo` VALUES('' , 'rafi', '1309')" ;
    $Query2 = "INSERT INTO `demo` VALUES('' , 'tafi', '1509')" ;
    $Query3 = "INSERT INTO `demo` VALUES('' , 'kafi', '1409', 'ol')" ;
    $Query4 = "INSERT INTO `demo` VALUES('' , 'safi', '1809')" ;


    if(!mysqli_query($DBConnectionPlaygroung, $Query1)){
        throw new Exception("in 1 : ".mysqli_error($DBConnectionPlaygroung));
    }
    if(!mysqli_query($DBConnectionPlaygroung, $Query2)){
        throw new Exception("in 2 : ".mysqli_error($DBConnectionPlaygroung));
    }
    if(!mysqli_query($DBConnectionPlaygroung, $Query3)){
        throw new Exception("in 3 : ".mysqli_error($DBConnectionPlaygroung));
    }
    if(!mysqli_query($DBConnectionPlaygroung, $Query4)){
        throw new Exception("in 4 : ".mysqli_error($DBConnectionPlaygroung));
    }


    mysqli_commit($DBConnectionPlaygroung) ;
    mysqli_autocommit($DBConnectionPlaygroung, true) ;







} catch ( Exception $e ) {

    echo $e ;
    // before rolling back the transaction, you'd want
    // to make sure that the exception was db-related
    mysqli_rollback($DBConnectionPlaygroung) ;
    mysqli_autocommit($DBConnectionPlaygroung, true) ;
     // i.e., end transaction
}
