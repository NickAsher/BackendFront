<?php

function getItemPriceString_PDO($DBConnection, $CategoryId, $ItemId){
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

    $Query = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_id` = :category_id ORDER BY `size_sr_no` " ;
    try{
        $QueryResult = $DBConnection->prepare($Query) ;
        $QueryResult->execute(['category_id'=>$CategoryId]) ;
        $AllSizes = $QueryResult->fetchAll() ;


        foreach ($AllSizes as $Record){
            $SizeRelId = $Record['size_id'] ;
//            $CategorySizeCode = $Record['size_code'] ;
            $Query2 = "SELECT * FROM `menu_meta_rel_size_items_table` WHERE `item_id` = :item_id AND `size_id` = '$SizeRelId' " ;
            try{
                $QueryResult2 = $DBConnection->prepare($Query2) ;
                $QueryResult2->execute(['item_id'=>$ItemId]) ;

                if($QueryResult2->rowCount() == 0){
                    $PriceString.= "Undefined - " ;
                } else {
                    $Record2 = $QueryResult2->fetch(PDO::FETCH_ASSOC) ; ;
                    $Price = $Record2['item_price'] ;
                    if($Price == "-1"){
                        $PriceString.= "Empty - " ;
                    } else {
                        $PriceString.= "$Price - " ;
                    }
                }

            }catch (Exception $e){
            throw new Exception("Unable to fetch the price  for item  $ItemId  at ".$e->getMessage()) ;
        }



        }
        $PriceString = rtrim($PriceString, " - ") ;
        return $PriceString ;

    }catch (Exception $e){
        throw new Exception("Unable to fetch the price string for item  $ItemId as Unable to fetch the sizes".$e->getMessage()) ;
    }

}



function getAddonPriceString_PDO($DBConnection, $CategoryId, $AddonId){
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

    $Query = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_id` = :category_id ORDER BY `size_sr_no` " ;
    try{
        $QueryResult = $DBConnection->prepare($Query) ;
        $QueryResult->execute(['category_id'=>$CategoryId]) ;
        $AllSizes = $QueryResult->fetchAll() ;
    } catch(Exception $e) {
        throw new Exception("Unable to fetch the different sizes for the category $CategoryId : ".$e->getMessage()) ;
    }
        foreach ($AllSizes as $Record){
            $SizeRelId = $Record['size_id'] ;
            $Query2 = "SELECT * FROM `menu_meta_rel_size_addons_table` WHERE `addon_id` = :addon_id AND `size_id` = '$SizeRelId' " ;

            try{
                $QueryResult2 = $DBConnection->prepare($Query2) ;
                $QueryResult2->execute(['addon_id'=>$AddonId]) ;

                if($QueryResult2->rowCount() == 0){
                    $PriceString.= "Undefined - " ;
                } else {
                    $Record2 = $QueryResult2->fetch(PDO::FETCH_ASSOC) ;
                    $Price = $Record2['addon_price'] ;
                    if($Price == "-1"){
                        $PriceString.= "Empty - " ;
                    } else {
                        $PriceString.= "$Price - " ;
                    }
                }
            } catch(Exception $e) {
                throw new Exception("Unable to fetch the price  for addon  $AddonId  at : ".$e->getMessage()) ;
            }
        }
        $PriceString = rtrim($PriceString, " - ") ;
        return $PriceString ;


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