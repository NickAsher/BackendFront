<?php

function getItemPriceString($NoOfSizeVariations, $ItemPriceSize1, $ItemPriceSize2, $ItemPriceSize3){
    $ItemPriceString = null ;
    switch ($NoOfSizeVariations) {
        case 1 :
            $ItemPriceString = "$ItemPriceSize1" ;
            break ;
        case 2 :
            $ItemPriceString = "$ItemPriceSize1 - $ItemPriceSize2" ;

            break ;
        case 3 :
            $ItemPriceString = "$ItemPriceSize1 - $ItemPriceSize2 - $ItemPriceSize3" ;

            break ; 
        default :
            $ItemPriceString = "Uknown Variations" ;
            break ;
    }
    return $ItemPriceString ;
}



function getItemPriceStringNew($DBConnection, $NoOfSizeVariations, $ItemId){
    $PriceString = '' ;

    for ($i = 1; $i <=$NoOfSizeVariations ; $i ++){
        $Query = "SELECT * FROM `menu_items_price_view` WHERE `item_id` = '$ItemId' AND `size_sr_no` = '$i' " ;
        $QueryResult = mysqli_query($DBConnection, $Query) ;

        $Record = mysqli_fetch_assoc($QueryResult) ;
        $PriceAtThisVariation = $Record['item_price'] ;
        $PriceString .= "$PriceAtThisVariation - " ;
    }

    $PriceString = rtrim($PriceString, " - ") ;
    return $PriceString ;
}


function getAddonPriceStringNew($DBConnection, $NoOfSizeVariations, $AddonId){
    $PriceString = '' ;

    for ($i = 1; $i <=$NoOfSizeVariations ; $i ++){
        $Query = "SELECT * FROM `menu_meta_rel_size-addons_table` WHERE `addon_id` = '$AddonId' AND `size_sr_no` = '$i' " ;
        $QueryResult = mysqli_query($DBConnection, $Query) ;

        $Record = mysqli_fetch_assoc($QueryResult) ;
        $PriceAtThisVariation = $Record['addon_price'] ;
        $PriceString .= "$PriceAtThisVariation - " ;
    }

    $PriceString = rtrim($PriceString, " - ") ;
    return $PriceString ;
}


?>