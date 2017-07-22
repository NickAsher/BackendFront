<?php
require_once '../../../utils/menu-utils-pdo.php' ;

function parseReceipt_Cart($DBConnection, $CartArray){
    $ReturnArray = array() ;
    $i = 0 ;

    foreach ($CartArray as $CartItem){
        $ItemNameString = '' ;
        $ItemPrice = 0 ;

        $ItemId = $CartItem['item_id'] ;
        $ItemQuantity = $CartItem['item_quantity'] ;
        $ItemSizeId = $CartItem['item_size_id'] ;


        $SizeInformation = getSingleSizeInfoArray_PDO($DBConnection, $ItemSizeId) ;
        $SizeNameAbbr = $SizeInformation['size_name_short'] ;
        $ItemName = getSingleMenuItemInfoArray_PDO($DBConnection, $ItemId)['item_name'] ;

        $ItemNameString = "$SizeNameAbbr $ItemName" ;



        $AddonArray = $CartItem['item_addon'] ;
        // this check is for items which do not have an addon group, so addon array for them is just ""
        if($AddonArray != ""){
            $AllAddonItemsIdArray = array() ;


            foreach ($AddonArray as $AddonRecord){
                $AddonItemsArray = $AddonRecord['addon_items_array'] ;
                $AddonItemGroupPrice = $AddonRecord['addon_group_price'] ;




                $AllAddonItemsIdArray = array_merge($AllAddonItemsIdArray, $AddonItemsArray) ;

                $ItemPrice += $AddonItemGroupPrice ;

            }

            foreach ($AllAddonItemsIdArray as $AddonItemId){
                $ItemNameString .= " ".getSingleAddonItemInfoArray_PDO($DBConnection, $AddonItemId)['item_name'] ;

            }
        }


        $Query = "SELECT * FROM `menu_meta_rel_size_items_table` WHERE `item_id` = '$ItemId' AND `size_id`  = '$ItemSizeId' " ;
        $QueryResult = $DBConnection->query($Query) ;
        $ItemBasePrice = $QueryResult->fetch(PDO::FETCH_ASSOC)['item_price'] ;

        $ItemPrice += $ItemBasePrice ;











        $DescriptionString = null ;
        $ReturnArray[$i] = array(
            'item_quantity'=>$ItemQuantity,
            'item_name'=>$ItemNameString,
            'item_price'=>$ItemPrice,
        ) ;

        $i++ ;

    }

    return $ReturnArray ;





}



function parseReceipt_User($DBConnection, $UserId){
    $Query = "SELECT * FROM `users_profile_table` WHERE `user_id` = :user_id " ;
    try {
        $QueryResult = $DBConnection->prepare($Query);
        $QueryResult->execute(['user_id' => $UserId]);
        $UserInfo = $QueryResult->fetch(PDO::FETCH_ASSOC);

        return array(
            'customer_name'=>$UserInfo['user_name'],
            'customer_num'=>$UserInfo['user_phone'],
            'customer_email'=>$UserInfo['user_email'],
        ) ;


    }catch (Exception $e){
        throw new Exception("Unable to fetch the user details : ".$e->getMessage()) ;
    }



}