<?php

function getItemPriceString($DBConnection, $CategoryId, $ItemId){
    $PriceString = '' ;
    /*
     * returns --> String
     * arg1 --> $DBConnection : a database connection
     * arg2 --> $CategoryId : The category_id of the item
     * arg3 --> $ItemId : the id of item for which the price string should be finded
     *
     *
     * Description:
     * ------------
     * This method gives a string telling the prices at different sizes, for an item, like "100-200-300"
     *
     *
     * Working:
     * --------
     * The way this method works is in two steps
     *
     *      1. Firstly we query the meta_size table to get all the size_codes in a category
     *      2. Then for each of the size_code, we make a query in the items_price table to get the price
     *          2.1 Here we do another check that if the item does not has a price for that size_code, then undefined will be written there
     *
     */

    $Query = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_id` = '$CategoryId' ORDER BY `size_sr_no` " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
        foreach ($QueryResult as $Record){
            $SizeRelId = $Record['size_id'] ;
//            $CategorySizeCode = $Record['size_code'] ;
            $Query2 = "SELECT * FROM `menu_meta_rel_size_items_table` WHERE `item_id` = '$ItemId' AND `size_id` = '$SizeRelId' " ;
            $QueryResult2 = mysqli_query($DBConnection, $Query2) ;
            if($QueryResult2){
                if(mysqli_num_rows($QueryResult2) == 0){
                    $PriceString.= "Undefined - " ;

                } else {
                    $Record2 = mysqli_fetch_assoc($QueryResult2) ;
                    $Price = $Record2['item_price'] ;
                    if($Price == "-1"){
                        $PriceString.= "Empty - " ;
                    } else {
                        $PriceString.= "$Price - " ;
                    }
                }
            } else {
                return "Unable to fetch the price  for item  $ItemId  at : ".mysqli_error($DBConnection) ;
            }
        }
        $PriceString = rtrim($PriceString, " - ") ;
        return $PriceString ;
    } else {
        return "Unable to fetch the price string for item  $ItemId : ".mysqli_error($DBConnection) ;
    }

}



function getAddonPriceString($DBConnection, $CategoryId, $AddonId){
    $PriceString = '' ;
    /*
     * returns --> String
     * arg1 --> $DBConnection : a database connection
     * arg2 --> $CategoryId : The category_id of the item
     * arg3 --> $AddonId : the id of addon for which the price string should be finded
     *
     *
     * Description:
     * ------------
     * This method gives a string telling the prices at different sizes, for an addon, like "100-200-300"
     *
     *
     * Working:
     * --------
     * The way this method works is in two steps
     *
     *      1. Firstly we query the meta_size table to get all the size_codes in a category
     *      2. Then for each of the size_code, we make a query in the items_price table to get the price
     *          2.1 Here we do another check that if the item does not has a price for that size_code, then undefined will be written there
     *          2.2 If the price is initialised but a value is not defined, then Empty will be written
     *
     */

    $Query = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_id` = '$CategoryId' ORDER BY `size_sr_no` " ;
    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
        foreach ($QueryResult as $Record){
            $SizeRelId = $Record['size_id'] ;
            $Query2 = "SELECT * FROM `menu_meta_rel_size_addons_table` WHERE `addon_id` = '$AddonId' AND `size_id` = '$SizeRelId' " ;
            $QueryResult2 = mysqli_query($DBConnection, $Query2) ;
            if($QueryResult2){
                if(mysqli_num_rows($QueryResult2) == 0){
                    $PriceString.= "Undefined - " ;

                } else {
                    $Record2 = mysqli_fetch_assoc($QueryResult2) ;
                    $Price = $Record2['addon_price'] ;
                    if($Price == "-1"){
                        $PriceString.= "Empty - " ;
                    } else {
                        $PriceString.= "$Price - " ;
                    }
                }
            } else {
                return "Unable to fetch the price  for addon  $AddonId  at : ".mysqli_error($DBConnection) ;
            }
        }
        $PriceString = rtrim($PriceString, " - ") ;
        return $PriceString ;
    } else {
        return "Unable to fetch the different sizes for the category $CategoryId : ".mysqli_error($DBConnection) ;
    }

}






//function sort_menuItems($DBConnection, $SubCategoryRelId){
//    $ListOfAllMenuItemsInASubCategory = getListOfAllMenuItemsInSubCategory_Array($DBConnection, $SubCategoryRelId) ;
//    $NoOfItems = count($ListOfAllMenuItemsInASubCategory) ;
//
//    $CaseStatement = '' ;
//    for($i = 0;$i<=$NoOfItems;$i++){
//        $ThisItem_ItemId = $ListOfAllMenuItemsInASubCategory[$i]['item_id'] ;
//        $RealSortNo = $i + 1 ;
//        $CaseStatement .= "WHEN `item_id` = '$ThisItem_ItemId' THEN '$RealSortNo' " ;
//
//    }
//
//    $Query = "UPDATE `menu_items_table` SET `item_sr_no` = CASE $CaseStatement END WHERE `item_subcategory_rel_id` = '$SubCategoryRelId'  " ;
//    $QueryResult = mysqli_query($DBConnection, $Query) ;
//    if(!$QueryResult){
//        die("error in case statement") ;
//    }
//
//    echo "Success" ;
//
//
//}









?>