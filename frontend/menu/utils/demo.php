<?php

require_once '../../../sql/sqlconnection.php' ;
require_once 'refresh-utils.php' ;

$DBConnectionyolo = YOLOSqlConnect() ;
refresh_Menu($DBConnectionyolo) ;
