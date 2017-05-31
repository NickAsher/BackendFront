<?php

function getGalleryItemInfo($DBConnection, $ItemId){
    $Query = "SELECT * FROM `gallery_table` WHERE `gallery_item_id` = '$ItemId' " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
        $Temp = null ;
        foreach ($QueryResult as $Record){
            $Temp = $Record ;
        }
        return $Temp ;
    } else {
        echo "Problem in getting the gallery item info for id: $ItemId <br> ".mysqli_error($DBConnection) ;
        return -1 ;
    }


}


?>