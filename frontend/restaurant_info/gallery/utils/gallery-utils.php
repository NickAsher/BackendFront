<?php

function getGalleryItemInfo($DBConnection, $ItemId){
    $Query = "SELECT * FROM `gallery_table` WHERE `gallery_item_id` = :item_id " ;
    try{
        $QueryResult = $DBConnection->prepare($Query) ;
        $QueryResult->execute([':item_id'=>$ItemId]) ;
        return $QueryResult->fetch(PDO::FETCH_ASSOC) ;

    }catch (Exception $e){
        throw new Exception("Unable to fetch the gallery Items".$e->getMessage()) ;
    }




}


function getListOfAllGalleryItems($DBConnection){
    $Query = "SELECT * FROM `gallery_table` ORDER BY `gallery_item_sr_no` ASC" ;
    try{
        $QueryResult = $DBConnection->query($Query) ;
        return $QueryResult->fetchAll() ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the gallery items : ".$e->getMessage()) ;
    }

}


?>