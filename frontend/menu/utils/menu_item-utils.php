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


?>