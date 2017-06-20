<?php

function parseOrderDescriptionString($DBConnectionBackend, $IndividualOrderCartItemArray){
    $ItemId = $IndividualOrderCartItemArray['item_id'] ;
    $ItemQuantity = $IndividualOrderCartItemArray['item_quantity'] ;

    $ItemInformation = getItemInformation($DBConnectionBackend, $ItemId) ;
    $ItemName = $ItemInformation['item_name'] ;
    $ItemCategory = $ItemInformation['item_category_code'] ;

    $DescriptionString = null ;
    $CustomizationString = parseOrderDescription_ItemCustomizationString($DBConnectionBackend, $IndividualOrderCartItemArray, $ItemCategory) ;

    $DescriptionString .= "$ItemQuantity x $ItemName $CustomizationString <br> <br>" ;
    return $DescriptionString ;
}




function parseOrderDescription_ItemCustomizationString($DBConnectionBackend, $IndividualOrderCartItemArray, $ItemCategory){
    $CustomizationString = null ;

    $SizeInformation = getSizeInformation($DBConnectionBackend, $ItemCategory, $IndividualOrderCartItemArray['item_size_code']) ;
    $SizeName = $SizeInformation['size_name'] ;
    if($SizeName == "Normal"){
        $SizeString  = "" ;
    } else {
        $SizeString  = "-($SizeName)" ;
    }

    /*
     *
     * "item_id":"41002",
     * "item_quantity":"1",
     * "item_size_code":"small",
     * "item_addon":[
     *     {
     *          "addon_group_code":"pizza_crusts",
     *          "addon_items_array":["48015"],
     *          "addon_group_price":40
     *      },
     *      {
     *          "addon_group_code":"pizza_toppings",
     *          "addon_items_array":["48001","48002"],
     *          "addon_group_price":100
     *      }
     *      ]
     *
     */

    $ItemAddonArray = $IndividualOrderCartItemArray['item_addon'] ;
    $AddonDescriptionString = '' ;

    if($ItemAddonArray != '') {
        foreach ($ItemAddonArray as $AddonData) {
            $AddonGroupCode = $AddonData['addon_group_code'];
            $AddonGroupName = getAddonGroupInfoArray($DBConnectionBackend, $ItemCategory, $AddonGroupCode)['addon_group_display_name'];
            $AddonDescriptionString .= "$AddonGroupName : ";

            foreach ($AddonData['addon_items_array'] as $AddonItemId) {
                $AddonItemInfo = getAddonItemInfoArray($DBConnectionBackend, $ItemCategory, $AddonItemId);
                $AddonItemName = $AddonItemInfo['item_name'];
                $AddonDescriptionString .= "$AddonItemName, ";
            }

            $AddonDescriptionString = rtrim($AddonDescriptionString, ", ");
            $AddonDescriptionString .= "<br>";
        }
    }




    return "$SizeString <br> $AddonDescriptionString" ;
}



function parseOrderAddress($AddressArrayString){
    $Record = json_decode($AddressArrayString, true) ;


    $AddressPhoneNum = $Record['address_phone'] ;
    $AddressLine1 = $Record['address_line1'] ;
    $AddressLine2 = $Record['address_line2'] ;
    $AddressPostalCode = $Record['address_postal_code'] ;
    $AddressCity = $Record['address_city'] ;
    $AddressDistrict = $Record['address_district'] ;
    $AddressState = $Record['address_state'] ;
    $AddressCountry = $Record['address_country'] ;

    $ReturnedHtmlAddressString = "
        $AddressPhoneNum <br>
        $AddressLine1 , $AddressLine2 <br>
        $AddressPostalCode, $AddressCity, $AddressDistrict <br>
        $AddressState , $AddressCountry <br>
    " ;

    return $ReturnedHtmlAddressString ;






}


?>