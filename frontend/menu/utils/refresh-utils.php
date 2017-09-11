<?php


function refresh_InCategory_SubCategories($DBConnection, $CategoryId){
    $Query = "UPDATE `menu_meta_category_table` SET `category_no_of_subcategories` = 
              (SELECT COUNT(*) AS `total` FROM `menu_meta_subcategory_table` WHERE `category_id` = '$CategoryId')
              WHERE `category_id` = '$CategoryId' " ;

    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
//        echo "Successfully updated the Count for SubCategory in Categories <br>" ;

    } else {
        die("Unable to set the new count for SubCategories In category <br>".mysqli_error($DBConnection)) ;
    }


}






function refresh_InCategory_MenuItems($DBConnection, $CategoryId){
    $Query = "UPDATE `menu_meta_category_table` SET `category_no_of_menuitems` = 
              (SELECT COUNT(*) AS `total` FROM `menu_items_table` WHERE `item_category_id` = '$CategoryId')
              WHERE `category_id` = '$CategoryId' " ;

    $QueryResult = mysqli_query($DBConnection, $Query);
    if($QueryResult){
//        echo "Successfully updated the Count for MenuItems in Categories <br>" ;
    } else {
        die("Unable to set the new count for MenuItems In category <br>".mysqli_error($DBConnection)) ;
    }
}






function refresh_InCategory_AddonGroups($DBConnection, $CategoryId){
    $Query = "UPDATE `menu_meta_category_table` SET `category_no_of_addongroups` = 
              (SELECT COUNT(*) AS `total` FROM `menu_meta_addongroups_table` WHERE `category_id` = '$CategoryId')
              WHERE `category_id` = '$CategoryId' " ;

    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
//        echo "Successfully updated the Count for AddonGroups in Categories <br>" ;
    } else {
        die("Unable to set the new count for AddonGroups In category <br>".mysqli_error($DBConnection)) ;
    }
}






function refresh_InCategory_AddonItems($DBConnection, $CategoryId){

    $Query = "UPDATE `menu_meta_category_table` SET `category_no_of_addonitems` = 
              (SELECT COUNT(*) AS `total` FROM `menu_addons_table` WHERE `item_category_id` = '$CategoryId')
              WHERE `category_id` = '$CategoryId' " ;

    $QueryResult = mysqli_query($DBConnection, $Query) ;
    if($QueryResult){
//        echo "Successfully updated the Count for AddonItems in Categories <br>" ;
    } else {
        die("Unable to set the new count for AddonItems In category <br>".mysqli_error($DBConnection)) ;
    }
}





 /* ************************************************************* */

function refresh_InSubCategory_MenuItems($DBConnection, $CategoryId, $SubCategoryCode){


    $Query = "UPDATE `menu_meta_subcategory_table` SET `subcategory_no_of_menuitems` = 
              (SELECT COUNT(*) AS `total` FROM `menu_items_table` WHERE `item_category_id` = '$CategoryId' AND  `item_subcategory_code` =  '$SubCategoryCode')
              WHERE `category_id` = '$CategoryId' AND `subcategory_code` =  '$SubCategoryCode' " ;

    $QueryResult = mysqli_query($DBConnection, $Query) or die("Unable to set the new count for MenuItems In Subcategory <br>".mysqli_error($DBConnection));

    return true ;
}


/* **************************************************************** */
function refresh_InAddonGroups_AddonItems($DBConnection, $CategoryId, $AddonGroupCode){
    $Query = "UPDATE `menu_meta_addongroups_table` SET `addon_group_no_of_items` = 
              (SELECT COUNT(*) AS `total` FROM `menu_addons_table` WHERE `item_category_id` = '$CategoryId' AND  `item_addon_group_code` =  '$AddonGroupCode')
              WHERE `category_id` = '$CategoryId' AND `addon_group_code` =  '$AddonGroupCode' " ;

    $QueryResult = mysqli_query($DBConnection, $Query) or die("Unable to set the new count for AddonItems In AddonCategory <br>".mysqli_error($DBConnection));

    return true ;
}






function refresh_AllCategories($DBConnection){

    $Query = "SELECT * FROM `menu_meta_category_table` " ;
    $QueryResult = mysqli_query($DBConnection, $Query) or die("Unable to fetch all the categories <br>" .mysqli_error($DBConnection)) ;
    foreach ($QueryResult as $CategoryRecord){
        $CategoryId = $CategoryRecord['category_id'] ;
//        echo "For Category ".$CategoryRecord['category_name']."<br><br>";
        refresh_InCategory_SubCategories($DBConnection, $CategoryId) ;
        refresh_InCategory_MenuItems($DBConnection, $CategoryId) ;
        refresh_InCategory_AddonGroups($DBConnection, $CategoryId) ;
        refresh_InCategory_AddonItems($DBConnection, $CategoryId) ;
    }
//    echo "<br><br>" ;


}

function refresh_AllSubCategories($DBConnection){

    $Query = "SELECT * FROM `menu_meta_subcategory_table` " ;
    $QueryResult = mysqli_query($DBConnection, $Query) or die("Unable to fetch all the Subcategories <br>" .mysqli_error($DBConnection)) ;
    foreach ($QueryResult as $Record){
        $CategoryId = $Record['category_id'] ;
        $SubCategoryCode = $Record['subcategory_code'] ;
//        echo "For SubCategory ".$Record['subcategory_display_name']."<br><br>";
        refresh_InSubCategory_MenuItems($DBConnection, $CategoryId, $SubCategoryCode) ;

    }
//    echo "<br><br>" ;


}

function refresh_AllAddonGroups($DBConnection){

    $Query = "SELECT * FROM `menu_meta_addongroups_table` " ;
    $QueryResult = mysqli_query($DBConnection, $Query) or die("Unable to fetch all the AddonGroups <br>" .mysqli_error($DBConnection)) ;
    foreach ($QueryResult as $Record){
        $CategoryId = $Record['category_id'] ;
        $AddonGroupCode = $Record['addon_group_code'] ;
//        echo "For SubCategory ".$Record['subcategory_display_name']."<br><br>";
        refresh_InAddonGroups_AddonItems($DBConnection, $CategoryId, $AddonGroupCode) ;

    }
//    echo "<br><br>" ;


}



function refresh_Menu($DBConnection){
    refresh_AllCategories($DBConnection) ;
    refresh_AllSubCategories($DBConnection) ;
    refresh_AllAddonGroups($DBConnection) ;

}