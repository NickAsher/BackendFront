<?php



function getListOfAllCategories_Array_PDO($DBConnection){
    $Query1 =  "SELECT * FROM `menu_meta_category_table` ORDER BY `category_sr_no` ASC" ;
    try{
        $QueryResult1 = $DBConnection->query($Query1) ;
        $AllCategoriesArray  = $QueryResult1->fetchAll() ;
        return $AllCategoriesArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Item categories from the menu_meta_category_table: ".$e->getMessage()) ;
    }

}







function getSingleCategoryInfoArray_PDO($DBConnection, $CategoryId){
    /*
     * This function returns the Information of a single category like its code, its name, its size variation
     * If it is unable to fetch the info, then it will kill the page
     */

    $Query1 =  "SELECT * FROM `menu_meta_category_table` WHERE `category_id` = :category_id " ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['category_id'=>$CategoryId]) ;
        $SingleCategoryInfoArray  = $QueryResult1->fetch(PDO::FETCH_ASSOC) ;

        return $SingleCategoryInfoArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the category info from the menu_meta_category_table: ".$e->getMessage()) ;
    }


}









function getListOfAllSubCategory_InACategory_Array_PDO($DBConnection, $CategoryId){
    /*
     * This function returns all the rows of subacategory of a particular category.
     * For example, if the category code is pizza, then it will return three subcategory rows like
     *  1.   pizza   simple_pizza   Simple Pizza  2   5
     *  2.   pizza   signature_pizza   Signature Pizza   3   5
     *
     */




    $Query1 =  "SELECT * FROM `menu_meta_subcategory_table`
                  WHERE `category_id` = :category_id ORDER BY `subcategory_sr_no` ASC" ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['category_id'=>$CategoryId]) ;
        $CategorySubCategoriesListArray  = $QueryResult1->fetchAll() ;

        return $CategorySubCategoriesListArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the SubCategory list from the menu_meta_rel_category : ".$e->getMessage()) ;
    }

}



function getSingleSubCategoryInfoArray_PDO($DBConnection, $SubCategoryRelId){


    $Query1 = "SELECT * FROM `menu_meta_subcategory_table`
                WHERE `rel_id` = :rel_id  " ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['rel_id'=>$SubCategoryRelId]) ;
        $SubCategoriesInfoArray  = $QueryResult1->fetch(PDO::FETCH_ASSOC) ;

        return $SubCategoriesInfoArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the subcategory info from the menu_meta_subcategory_table : ".$e->getMessage()) ;
    }






}






function getListOfAllAddonGroupsInACategory_Array_PDO($DBConnection, $CategoryId){

    $Query1 =  "SELECT * FROM `menu_meta_addongroups_table`
                WHERE `category_id` = :category_id ORDER BY `addon_group_sr_no` ASC" ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['category_id'=>$CategoryId]) ;
        $CategoryAddonGroupsListArray  = $QueryResult1->fetchAll() ;

        return $CategoryAddonGroupsListArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Addons Group list from the menu_meta_addongroups_table : ".$e->getMessage()) ;
    }


}



function getSingleAddonGroupInfoArray_PDO($DBConnection, $AddonGroupRelId){
    /*
     *
     *
     */


    $Query1 = "SELECT * FROM `menu_meta_addongroups_table` WHERE `rel_id` = :rel_id " ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['rel_id'=>$AddonGroupRelId]) ;
        $SingleAddonGroupInfoArray  = $QueryResult1->fetch(PDO::FETCH_ASSOC) ;

        return $SingleAddonGroupInfoArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Addon-Group info from the menu_meta_addongroups_table : ".$e->getMessage()) ;
    }

}



function getListOfAllAddonItemsInAddonGroup_Array_PDO($DBConnection, $AddonGroupRelId){

    /*
     *
     */


    $Query1 = "SELECT * FROM `menu_addons_table` WHERE `item_addon_group_rel_id` = :rel_id ORDER BY `item_sr_no` ASC " ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['rel_id'=>$AddonGroupRelId]) ;
        $AddonItemsInGroupArray  = $QueryResult1->fetchAll() ;

        return $AddonItemsInGroupArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Addons Item from the menu_addon_table : ".$e->getMessage()) ;
    }
}


function getListOfAllAddonItemsInCategoryArray_PDO($DBConnection, $CategoryId){
    $Query1 = "SELECT * FROM `menu_addons_table` WHERE `item_category_id` = :category_id ORDER BY `item_sr_no` ASC " ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['category_id'=>$CategoryId]) ;
        $AddonItemsInGroupArray  = $QueryResult1->fetchAll() ;

        return $AddonItemsInGroupArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Addons Item from the menu_addon_table : ".$e->getMessage()) ;
    }
}



function getSingleAddonItemInfoArray_PDO($DBConnection, $AddonItemId){

    /*
     *
     */


    $Query1 = "SELECT * FROM `menu_addons_table` WHERE `item_id` = :addon_id " ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['addon_id'=>$AddonItemId]) ;
        $SingleAddonItemInfoArray  = $QueryResult1->fetch(PDO::FETCH_ASSOC) ;

        return $SingleAddonItemInfoArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Addon-Item info from the menu_addon_table  : ".$e->getMessage()) ;
    }

}


function getSingleAddonItemPriceInfoArray_PDO($DBConnection, $AddonItemId, $SizeId){


    $Query1 = "SELECT * FROM `menu_meta_rel_size_addons_table` WHERE `addon_id` = :addon_id AND `size_id` = :size_id  " ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['addon_id'=>$AddonItemId, 'size_id'=>$SizeId]) ;
        $SingleAddonItemPriceInfoArray  = $QueryResult1->fetch(PDO::FETCH_ASSOC) ;

        return $SingleAddonItemPriceInfoArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Addon-Item info from the menu_addon_table  : ".$e->getMessage()) ;
    }
}



function getListOfAllSizesInCategory_PDO($DBConnection, $CategoryId){

    $Query1 = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_id` = :category_id ORDER BY `size_sr_no` ";
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['category_id'=>$CategoryId]) ;
        $ListOfAllSizesInCategory  = $QueryResult1->fetchAll() ;

        return $ListOfAllSizesInCategory ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Sizes for the category $CategoryId : ".$e->getMessage()) ;
    }
}


function getSingleSizeInfoArray_PDO($DBConnection, $SizeId){

    $Query1 = "SELECT * FROM `menu_meta_size_table` WHERE `size_id` = :size_id  " ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['size_id'=>$SizeId]) ;
        $SizeInformation  = $QueryResult1->fetch(PDO::FETCH_ASSOC) ;

        return $SizeInformation ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Size Information from the size table : ".$e->getMessage()) ;
    }
}







function getListOfAllMenuItemsInCategory_Array_PDO($DBConnection, $CategoryId) {

    $Query1 = "SELECT * FROM `menu_items_table` WHERE `item_category_id` = :category_id ORDER BY `item_id` ";
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['category_id'=>$CategoryId]) ;
        $ListOfMenuItemsInCategory  = $QueryResult1->fetchAll() ;

        return $ListOfMenuItemsInCategory ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Menu Item for the category $CategoryId : ".$e->getMessage()) ;
    }
}



function getListOfAllMenuItemsInSubCategory_Array_PDO($DBConnection, $SubCategoryRelId){

    $Query1 = "SELECT * FROM `menu_items_table` WHERE `item_subcategory_rel_id` = :rel_id ORDER BY `item_sr_no` ASC ";
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['rel_id'=>$SubCategoryRelId]) ;
        $ListOfMenuItemsInSubCategory  = $QueryResult1->fetchAll() ;

        return $ListOfMenuItemsInSubCategory ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Menu Item for the Subcategory $SubCategoryRelId : ".$e->getMessage()) ;
    }


}


function getSingleMenuItemInfoArray_PDO($DBConnection, $MenuItemId){


    $Query1 = "SELECT * FROM `menu_items_table` WHERE `item_id` = :item_id " ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['item_id'=>$MenuItemId]) ;
        $SingleMenuItemInfoArray  = $QueryResult1->fetch(PDO::FETCH_ASSOC) ;


        return $SingleMenuItemInfoArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Menu-Item info from the menu_items_table : ".$e->getMessage()) ;
    }

}


function getSingleMenuItemInfo_EXTRAArray_PDO($DBConnection, $MenuItemId){


    $Query1 = "SELECT * FROM `menu_items_table` WHERE `item_id` = :item_id " ;
    try{
        $QueryResult1 = $DBConnection->prepare($Query1) ;
        $QueryResult1->execute(['item_id'=>$MenuItemId]) ;
        $SingleMenuItemInfoArray  = $QueryResult1->fetch(PDO::FETCH_ASSOC) ;

        $CategoryName = getSingleCategoryInfoArray_PDO($DBConnection, $SingleMenuItemInfoArray['item_category_id'])['category_name'] ;
        $SubCategoryName = getSingleSubCategoryInfoArray_PDO($DBConnection, $SingleMenuItemInfoArray['item_subcategory_rel_id']) ['subcategory_display_name'] ;
        $SingleMenuItemInfoArray['category_name'] = $CategoryName ;
        $SingleMenuItemInfoArray['subcategory_display_name'] = $SubCategoryName ;


        return $SingleMenuItemInfoArray ;
    }catch (Exception $e){
        throw new Exception("Unable to fetch the Menu-Item info from the menu_items_table : ".$e->getMessage()) ;
    }

}









?>