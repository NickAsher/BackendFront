<?php

    $SingleCategoryInfoArray = getSingleCategoryInfoArray($DBConnectionBackend, $CategoryCode) ;

    $CategoryAddonGroupsListArray = getListOfAllAddonGroupsInACategory_Array($DBConnectionBackend, $CategoryCode) ;



    

?>








<div id="mainContent" >
<?php
    foreach ($CategoryAddonGroupsListArray as $Record){
        $AddonGroupRelId = $Record['rel_id'] ;
        $AddonGroupDisplayName = $Record['addon_group_display_name'] ;
        $AddonGroupType = $Record['addon_group_type'] ;

        if($AddonGroupType == "checkbox"){
            $TD_IsDefault_Heading = "<td>Is Default</td>" ;
            $TD_IsDefault_RowValue = "" ;
        }

        if($AddonGroupType == "checkbox"){

            echo "
            
                <div>
                    <div style='display: block'>
                        <h1 style='display: inline-block; float: left;' >$AddonGroupDisplayName <span>(Multi-Select)</span></h1>
                        <form action='sort-addon.php' method='post'>
                            <input name='__addongroup_rel_id' type='hidden' value=' $AddonGroupRelId'>
                            
                            <input type='submit' class='btn btn -info' style='display: inline-block;float: right' value='Sort This'>
                        </form>
                        <br><br>
                    </div>
                    <hr><br><br>
                    <div>
                        <table class='table table-bordered table-hover' >
    
                            <tr class='table-info'>
                                <th>Item Name</th>
                                <th>Item Price</th>
                                <th>Item Active</th>
                                <th>Item Edit</th>
                                <th>Item Delete</th>
                            </tr>
                            
            " ;


                            $AllAddonsInAGroup = getListOfAllAddonItemsInAddonGroup_Array($DBConnectionBackend, $AddonGroupRelId) ;
                            foreach($AllAddonsInAGroup as $Record2){

                                $ItemId = $Record2['item_id'] ;
                                $ItemName = $Record2['item_name'] ;
                                $ItemPriceString = getAddonPriceString($DBConnectionBackend, $CategoryCode, $ItemId) ;
                                $ItemActive = $Record2['item_is_active'] ;
                                if($ItemActive == 'true'){
                                    $ActiveButton = "<div class='btn btn-success' disabled><i class='fa fa-check'></i></div>" ;
                                } else if($ItemActive == 'false'){
                                    $ActiveButton = "<div class='btn btn-danger' disabled><i class='fa fa-times'></i></div>" ;
                                }



                                $DetailPageLink = "show_addon.php?___addon_item_id=$ItemId&___category_code=$CategoryCode" ;

                                echo "
                                    <tr>
                                        <td class='addon-link' data-href='$DetailPageLink'> <p class='link-black'>$ItemName</p> </td>
                                        <td class='addon-link' data-href='$DetailPageLink'>$ItemPriceString</td>
                                        <td class='addon-link' data-href='$DetailPageLink'>$ActiveButton</td>
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
                            <a href='add-addon.php?___category_code=$CategoryCode&___addongroup_rel_id=$AddonGroupRelId' class='col-md-4 btn btn-outline-info'>
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
                    <div style='display: block'>
                        <h1 style='display: inline-block; float: left;' >$AddonGroupDisplayName <span>(Single-Select)</span></h1>
                        <form action='sort-addon.php' method='post'>
                            <input name='__addongroup_rel_id' type='hidden' value=' $AddonGroupRelId'>
                            
                            <input type='submit' class='btn btn -info' style='display: inline-block;float: right' value='Sort This'>
                        </form>
                        <br><br>
                    </div>
                    
                    <hr><br><br>
                    <div>
                        <table class='table table-bordered table-hover' >
    
                            <tr class='table-info'>
                                <th>Item Name</th>
                                <th>Item Price</th>
                                <th>Is Default?</th>
                                <th>Item Active</th>
                                <th>Item Edit</th>
                                <th>Item Delete</th>
                            </tr>
                            
            " ;
                            $AllAddonsInAGroup = getListOfAllAddonItemsInAddonGroup_Array($DBConnectionBackend, $AddonGroupRelId) ;

                            foreach($AllAddonsInAGroup as $Record2){

                                $ItemId = $Record2['item_id'] ;
                                $ItemName = $Record2['item_name'] ;
                                $ItemPriceString = getAddonPriceString($DBConnectionBackend, $CategoryCode, $ItemId) ;
                                $ItemDefaultStatus = $Record2['item_is_default'] ;
                                $ItemActive = $Record2['item_is_active'] ;
                                if($ItemActive == 'true'){
                                    $ActiveButton = "<div class='btn btn-success' disabled><i class='fa fa-check'></i></div>" ;
                                } else if($ItemActive == 'false'){
                                    $ActiveButton = "<div class='btn btn-danger' disabled><i class='fa fa-times'></i></div>" ;
                                }


                                $DetailPageLink = "show_addon.php?___addon_item_id=$ItemId&___category_code=$CategoryCode" ;

                                echo "
                                                        <tr>
                                                            <td class='addon-link' data-href='$DetailPageLink'> <p class='link-black'>$ItemName</p> </td>
                                                            <td class='addon-link' data-href='$DetailPageLink'>$ItemPriceString</td>
                                                            <td class='addon-link' data-href='$DetailPageLink'>$ItemDefaultStatus</td>
                                                            <td class='addon-link' data-href='$DetailPageLink'>$ActiveButton</td>
                
                                                            
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
                        
                            
                        
                            <div class='col-md-1'></div>
                            <a href='add-addon.php?___category_code=$CategoryCode&___addongroup_rel_id=$AddonGroupRelId' class='col-md-4 btn btn-outline-info'>
                                Add New Addon-Item
                            </a>
                            <div class='col-md-1'></div>
                            
                            <div class='col-md-1'></div>
                            <form action='edit-addon-defaultvalue.php' method='post' class='col-md-4'>
                                <input name='__category_code' type='hidden' value='$CategoryCode'>
                                <input name='__addongroup_rel_id' type='hidden' value='$AddonGroupRelId'>
                                <input type='submit' class='btn btn-outline-success' value='Change Default Value'>
                            </form>
                            
                            <div class='col-md-1'></div>
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











