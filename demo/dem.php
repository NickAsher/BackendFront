<?php

require_once '../sql/sqlconnection.php' ;
$CategoryCode = 'pizza' ;

$DBConnection = YOLOSqlConnect() ;

$Query1 = "SELECT COUNT(*) AS `total` FROM `menu_meta_rel_category-subcategory_table` 
                WHERE `category_code` = '$CategoryCode'  " ;
$QueryResult1 =  mysqli_query($DBConnection, $Query1) or die("Unable to fetch count Subcategories <br>".mysqli_error($DBConnection)) ;
    $NoOfSubCategories_InCategory = mysqli_fetch_assoc($QueryResult1)['total'] ;

    echo $NoOfSubCategories_InCategory ;
?>
