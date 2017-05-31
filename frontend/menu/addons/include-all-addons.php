<?php

    $SingleCategoryInfoArray = getSingleCategoryInfoArray($DBConnectionBackend, $CategoryCode) ;
    $NoOfSizeVariations = intval($CategoryRecord['category_no_of_size_variations']) ;

    $CategoryAddonGroupsListArray = getListOfAllAddonGroupsInACategory_Array($DBConnectionBackend, $CategoryCode) ;



    

?>








<div id="mainContent" >
<?php
    foreach ($CategoryAddonGroupsListArray as $Record){
        $AddonGroupCode = $Record['addon_group_code'] ;
        $AddonGroupDisplayName = $Record['addon_group_display_name'] ;
        $AddonGroupType = $Record['addon_group_type'] ;

        if($AddonGroupType == "checkbox"){
            $TD_IsDefault_Heading = "<td>Is Default</td>" ;
            $TD_IsDefault_RowValue = "" ;
        }

        if($AddonGroupType == "checkbox"){

            echo "
            
                <div>
                    <h1>$AddonGroupDisplayName <span>(Multi-Select)</span></h1>
                    <hr><br><br>
                    <div>
                        <table class='table table-bordered table-hover' >
    
                            <tr class='table-info'>
                                <th>Item Name</th>
                                <th>Item Price</th>
                                <th>Item Edit</th>
                                <th>Item Delete</th>
                            </tr>
                            
            " ;


                            $AllAddonsInAGroup = getListOfAllAddonItemsInAddonGroup_Array($DBConnectionBackend, $CategoryCode, $AddonGroupCode) ;
                            foreach($AllAddonsInAGroup as $Record2){

                                $ItemId = $Record2['item_id'] ;
                                $ItemName = $Record2['item_name'] ;
                                $ItemPriceString = getItemPriceString($NoOfSizeVariations, $Record2['item_price_size1'], $Record2['item_price_size2'], $Record2['item_price_size3']) ; ;



                                $DetailPageLink = "show_addon.php?___addon_item_id=$ItemId&___category_code=$CategoryCode" ;

                                echo "
                                    <tr>
                                        <td class='addon-link' data-href='$DetailPageLink'> <p class='link-black'>$ItemName</p> </td>
                                        <td class='addon-link' data-href='$DetailPageLink'>$ItemPriceString</td>
                                        <td>
                                            <form action='edit-addon.php' method='get'>
                                                <input name='___category_code' type='hidden' value='$CategoryCode'>
                                                <input name='___addon_item_id' type='hidden' value='$ItemId'>
                                                <button type='submit' class='btn btn-info'>
                                                    <i class='fa fa-edit'></i> | Edit
                                                </button>
                                            </form> 
                                        </td>
                                        
                                        <td>
                                            <form action='confirm-delete-addon.php' method='post'>
                                                <input name='__category_code' type='hidden' value='$CategoryCode'>
                                                <input name='__addon_id' type='hidden' value='$ItemId'>
                                                <button type='submit' class='btn btn-danger'>
                                                    <i class='fa fa-trash'></i> | Delete
                                                </button>
                                            </form> 
                                        </td>
                                        
                                    </tr>
                                    
                                    
                                    " ;

                            }

            echo "
                        </table>
                        <br><br>
                        <div class='row'>
                            <div class='col-md-4'></div>
                            <a href='add-addon.php?___category_code=$CategoryCode&___addongroup_code=$AddonGroupCode' class='col-md-4 btn btn-outline-info'>
                                Add New Addon-Item
                            </a>
                            <div class='col-md-4'></div>
                        </div>
                    </div>
                    
            " ;




        }
        else
        if($AddonGroupType == "radio"){
            echo "
            
                <div>
                    <h1>$AddonGroupDisplayName <span>(Single-Select)</span> </h1>
                    <hr><br><br>
                    <div>
                        <table class='table table-bordered table-hover' >
    
                            <tr class='table-info'>
                                <th>Item Name</th>
                                <th>Item Price</th>
                                <th>Is Default?</th>
                                <th>Item Edit</th>
                                <th>Item Delete</th>
                            </tr>
                            
            " ;

                            $Query2 = "SELECT * FROM `menu_addons_table` WHERE `item_category_code` = '$CategoryCode' AND `item_addon_group_code` = '$AddonGroupCode'  ORDER BY `item_id` " ;
                            $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
                            if($QueryResult2){
                                foreach($QueryResult2 as $Record2){

                                    $ItemId = $Record2['item_id'] ;
                                    $ItemName = $Record2['item_name'] ;
                                    $ItemPriceString = getItemPriceString($NoOfSizeVariations, $Record2['item_price_size1'], $Record2['item_price_size2'], $Record2['item_price_size3']) ; ;
                                    $ItemDefaultStatus = $Record2['item_is_default'] ;
                                    $DetailPageLink = "show_addon.php?___addon_item_id=$ItemId&___category_code=$CategoryCode" ;

                                    echo "
                                        <tr>
                                            <td class='addon-link' data-href='$DetailPageLink'> <p class='link-black'>$ItemName</p> </td>
                                            <td class='addon-link' data-href='$DetailPageLink'>$ItemPriceString</td>
                                            <td class='addon-link' data-href='$DetailPageLink'>$ItemDefaultStatus</td>
                                            
                                            <td>
                                                <form action='edit-addon.php' method='get'>
                                                    <input name='___category_code' type='hidden' value='$CategoryCode'>
                                                    <input name='___addon_item_id' type='hidden' value='$ItemId'>
                                                    <button type='submit' class='btn btn-info'>
                                                        <i class='fa fa-edit'></i> | Edit
                                                    </button>
                                                </form> 
                                            </td>
                                            
                                            <td>
                                                <form action='confirm-delete-addon.php' method='post'>
                                                    <input name='__category_code' type='hidden' value='$CategoryCode'>
                                                    <input name='__addon_id' type='hidden' value='$ItemId'>
                                                    <button type='submit' class='btn btn-danger'>
                                                        <i class='fa fa-trash'></i> | Delete
                                                    </button>
                                                </form> 
                                            </td>
                                            
                                        </tr>
                                                        
                                                        
                                                        " ;

                                }
                            }
            echo "
                        </table>
                        <br><br>
                        <div class='row'>
                            <div class='col-md-2'></div>
                            <a href='add-addon.php?___category_code=$CategoryCode&___addongroup_code=$AddonGroupCode' class='col-md-2 btn btn-outline-info'>
                                Add New Addon-Item
                            </a>
                            <div class='col-md-2'></div>
                            
                            <div class='col-md-2'></div>
                            <a href='edit-addon-defaultvalue.php?___category_code=$CategoryCode&___addongroup_code=$AddonGroupCode' class='col-md-2 btn btn-outline-success'>
                                Change Default Value
                            </a>
                            <div class='col-md-2'></div>
                        </div>
                    </div>
                    <br><br>
            " ;
        }






        echo "
            </div>
            <br><br><br><br>
    
        
        
        " ;
    }
?>
</div>











