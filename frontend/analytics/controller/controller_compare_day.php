<?php





function getControllerCompareDay_TotalSale($DailyStats1, $DailyStats2){
    $RedGreen_TotalSale = getRedGreen_Output_Money($DailyStats1['total_sale'], $DailyStats2['total_sale']) ;
    $ReturnArray = array($RedGreen_TotalSale[0], $RedGreen_TotalSale[1]) ;
    return $ReturnArray ;

}




?>