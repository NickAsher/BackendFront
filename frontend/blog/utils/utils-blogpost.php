<?php












/*
 * Easy Database functions
 */

function getBlogInfo($DBConnectionBackend, $BlogId){
    $Query = "SELECT * FROM `blogs_table` WHERE `id` = '$BlogId'  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    $Temp = '' ;
    if($QueryResult){
        foreach ($QueryResult as $Record){
            $Temp = $Record ;
        }
        return $Temp ;
    } else {
        echo "Problem in getting the values for blog from blog table <br>".mysqli_error($DBConnectionBackend) ;
        return -1 ;
    }





}


?>