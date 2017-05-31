<?php




function getControllerCompareMonth_Variable($MonthlyStats1, $MonthlyStats2, $Variable){
    $RedGreen_Variable = getRedGreen_Output($MonthlyStats1["$Variable"], $MonthlyStats2["$Variable"]) ;
    $ReturnArray = array($RedGreen_Variable[0], $RedGreen_Variable[1]) ;
    return $ReturnArray ;
}


function getControllerCompareMonth_TotalSale($MonthlyStats1, $MonthlyStats2){

    $RedGreen_TotalSale = getRedGreen_Output_Money($MonthlyStats1['total_sale'], $MonthlyStats2['total_sale']) ;
    $ReturnArray = array($RedGreen_TotalSale[0], $RedGreen_TotalSale[1]) ;
    return $ReturnArray ;

}

function getControllerCompareMonth_TotalOrders($MonthlyStats1, $MonthlyStats2){
    return getControllerCompareMonth_Variable($MonthlyStats1, $MonthlyStats2, 'total_orders') ;
}




?>