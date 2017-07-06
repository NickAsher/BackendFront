<?php


function getAllOpeningScreenImages($DBConnection){
    $Query = "SELECT * FROM `opening_screen_image_table` ORDER BY `item_sr_no` ASC " ;
    try {
        $QueryResult = $DBConnection->query($Query);
        $AllOpeningScrImages = $QueryResult->fetchAll();
        return $AllOpeningScrImages ;
    } catch (Exception $e) {
        throw new Exception("Problem in fetching the Records from gallery table : ".$e );
    }
}