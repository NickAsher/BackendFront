<?php




function getControllerCompareYear_Variable($YearlyStats1, $YearlyStats2, $Variable){
    $RedGreen_Variable = getRedGreen_Output($YearlyStats1["$Variable"], $YearlyStats2["$Variable"]) ;
    $ReturnArray = array($RedGreen_Variable[0], $RedGreen_Variable[1]) ;
    return $ReturnArray ;
}


function getControllerCompareYear_TotalSale($YearlyStats1, $YearlyStats2){

    $RedGreen_TotalSale = getRedGreen_Output_Money($YearlyStats1['total_sale'], $YearlyStats2['total_sale']) ;
    $ReturnArray = array($RedGreen_TotalSale[0], $RedGreen_TotalSale[1]) ;
    return $ReturnArray ;

}

function getControllerCompareYear_TotalOrders($YearlyStats1, $YearlyStats2){
    return getControllerCompareYear_Variable($YearlyStats1, $YearlyStats2, 'total_orders') ;
}




?>