<?php

$ListOfAllSubCategoriesInCategory = getListOfAllSubCategory_InACategory_Array_PDO($DBConnectionBackend, $CategoryCode) ;

echo "<div id = 'mainContento' >" ;


foreach ($ListOfAllSubCategoriesInCategory as $SubCategoryRecord){

    $SubCategoryRelId = $SubCategoryRecord['rel_id'] ;
    $SubCategoryName = $SubCategoryRecord['subcategory_display_name'] ;
    $ListOfMenuItemsInSubCategory = getListOfAllMenuItemsInSubCategory_Array_PDO($DBConnectionBackend, $SubCategoryRelId) ;



    echo "
            <div style='display: block'>
                <h1 style='display: inline-block; float: left;' >$SubCategoryName</h1>
                <form action='sort-menuitem.php' method='post'>
                    <input name='__subcategory_rel_id' type='hidden' value=' $SubCategoryRelId'>
                    
                    <input type='submit' class='btn btn -info' style='display: inline-block;float: right' value='Sort This'>
                </form>
                <br><br>
            </div>
        
                <hr>
                
                                    
            <table  class='table table-bordered table-hover' >
        
                <tr class='table-info'>
                    <th>Sr No</th>
                    <th>Item Image</th>
                    <th>Item Name</th>
                    <th>Item Price</th>
                    <th>Item Active</th>
                    <th> Action</th>
                    
                </tr>
    " ;





    foreach($ListOfMenuItemsInSubCategory as $Record){
        $SrNo = $Record['item_sr_no'] ;
        $ItemId = $Record['item_id'] ;
        $ItemName = $Record['item_name'] ;
        $ItemPriceString = getItemPriceString_PDO($DBConnectionBackend, $CategoryCode, $ItemId) ;
        $ItemImage = $Record['item_image_name'] ;
        $ItemDescription = $Record['item_description'] ;

        $ItemSubcategoryRelId = $Record['item_subcategory_rel_id'] ;


        $ItemActive = $Record['item_is_active'] ;

        $ActiveButton = '' ;
        if($ItemActive == 'yes'){
            $ActiveButton = "<div class='btn btn-success' disabled><i class='fa fa-check'></i></div>" ;
        } else if($ItemActive == 'no'){
            $ActiveButton = "<div class='btn btn-danger' disabled><i class='fa fa-times'></i></div>" ;
        }

        $DetailPageLink = "show-menuitem.php?___menu_item_id=$ItemId" ;

        echo "
                <tr >
                    <td class='addon-link' data-href='$DetailPageLink'>$SrNo</td>
                    <td class='addon-link' data-href='$DetailPageLink'><img src='$IMAGE_BACKENDFRONT_LINK_PATH/$ItemImage' class='img-fluid' width = '80px' ></td>
                    <td class='addon-link' data-href='$DetailPageLink'><p class='link-black'>$ItemName</p></td>
                    <td class='addon-link' data-href='$DetailPageLink'>$ItemPriceString</td>
                    <td class='addon-link' data-href='$DetailPageLink'>$ActiveButton</td>
                    <td>
                        <div style='display: inline-block'>
                        <form method='get' action='edit-menuitem.php'>
                            <input type='hidden' name='___menu_item_id' value='$ItemId'>
                            <button type='submit' class='btn btn-info'><i class='fa  fa-edit' ></i></button>
                        </form>
                        </div>
                        &nbsp; &nbsp; 
                        <div style='display: inline-block'>
                        <form method='post' action='confirm-delete-menuitem.php'>
                            <input type='hidden' name='__menu_item_id' value='$ItemId'>
                            <button type='submit' class='btn btn-danger'><i class='fa fa-trash'></i></button>
                        </form>
                        </div>
                        
                        
                    </td>                                
                                        
                </tr>
                ";
    }

    echo "
            </table> <br><br><br>
            " ;



}


    echo "
                
            <br><br>
            <div class='row'>
                <div class='col-4'></div>
                <a class='col-4 btn btn-outline-info' href='add-menuitem.php?___category_code=$CategoryCode'>
                    Add New Item
                </a>
                <div class='col-4'></div>
            </div>
            
            
    </div>
                                
                           
                        
            " ;