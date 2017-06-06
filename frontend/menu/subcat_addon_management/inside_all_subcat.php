
<?php
$CategorySubCategoriesListArray = getListOfAllSubCategory_InACategory_Array($DBConnectionBackend, $CategoryCode) ;
$CategoryAddonsListArray = getListOfAllAddonGroupsInACategory_Array($DBConnectionBackend, $CategoryCode) ;
$CategorySizesListArray = getListOfAllSizesInCategory($DBConnectionBackend, $CategoryCode) ;


?>



<div id="mainContent">

    <div id="Div_Main_Subcategories">


        <h1>All Sub-Categories</h1>
        <hr><br><br>
        <div>
        <table class="table table-bordered table-hover" >

            <tr class="table-info">
                <th>Sr. No</th>
                <th>Category Code</th>
                <th>Category Name</th>
                <th>No of Menu-Items</th>
                <th>Delete</th>
            </tr>





            <?php
            foreach ($CategorySubCategoriesListArray as $Record){
                $SubCategorySrNo = $Record['subcategory_ordering_no'] ;
                $SubCategoryCode = $Record['subcategory_code'] ;
                $SubCategoryDisplayName = $Record['subcategory_display_name'] ;
                $NoOfMenuItems = $Record['subcategory_no_of_menuitems'] ;

                echo "
                <tr>
                    <td>$SubCategorySrNo</td>
                    <td>$SubCategoryCode</td>
                    <td>$SubCategoryDisplayName</td>
                    <td>$NoOfMenuItems</td>
                    <td>
                        <form action='subcategory_management/confirm-delete-subcategory.php' method='post'>
                            <input name='__category_code' type='hidden' value='$CategoryCode'>
                            <input name='__subcategory_code' type='hidden' value='$SubCategoryCode'>
                            <button class='btn btn-danger' type='submit'>
                                <i class='fa fa-trash'></i>  &nbsp; | &nbsp; Delete
                            </button>                                           
                        </form>    
                    </td>
        
                </tr>
            ";
            }
            ?>

        </table>







        <br><br>
        <br><br>
        <form action='subcategory_management/add-subcategory.php' method='post'>
            <input name='__category_code' type='hidden' value='<?php echo "$CategoryCode" ; ?>'>
            <div class='row'>
                <div class='col-md-4'></div>
                <button class='col-md-4 btn btn-info' type='submit'>Add new Category</button>
                <div class='col-md-4'></div>

            </div>
        </form>
        </div>


    </div>





    <br><br><br><br>


    <div id="Div_Main_AddonGroups">
        <h1>All Addon-Groups</h1>
        <hr><br><br>
        <div>

        <table class="table table-bordered table-hover" >

            <tr class="table-info">
                <th>Sr. No</th>
                <th>Addon-Group Code</th>
                <th>Addon-Group Name</th>
                <th>Addon-Group Type</th>
                <th>No of Addon-Items</th>
                <th>Delete</th>
            </tr>





        <?php
        foreach ($CategoryAddonsListArray as $Record){
            $AddonGroupCategorySrNo = $Record['addon_group_ordering_no'] ;
            $AddonGroupCode = $Record['addon_group_code'] ;
            $AddonGroupDisplayName = $Record['addon_group_display_name'] ;
            $NoOfItems = $Record['addon_group_no_of_items'] ;

            $AddonGroupType = $Record['addon_group_type'] ;
            $AddonGroupTypeString = '' ;
            if($AddonGroupType == 'radio'){
                $AddonGroupTypeString = "Single-Select" ;
            } else if($AddonGroupType == 'checkbox'){
                $AddonGroupTypeString = "Multi-Select" ;
            } else {
                $AddonGroupTypeString = "Unknown-Select" ;
            }

            echo "
                <tr>
                    <td>$AddonGroupCategorySrNo</td>
                    <td>$AddonGroupCode</td>
                    <td>$AddonGroupDisplayName</td>
                    <td>$AddonGroupTypeString</td>
        
                    <td>$NoOfItems</td>
                    <td>
                        <form action='addon_management/confirm-delete-addongroup.php' method='post'>
                            <input name='__category_code' type='hidden' value='$CategoryCode'>
                            <input name='__addongroup_code' type='hidden' value='$AddonGroupCode'>
                            <button class='btn btn-danger' type='submit'>
                                <i class='fa fa-trash'></i>  &nbsp; | &nbsp; Delete
                            </button>                                           
                        </form>    
                    </td>
        
                </tr>
            ";
        }
        ?>

        </table>




        <br><br>
        <form action='addon_management/add-addongroup.php' method='post'>
            <input name='__category_code' type='hidden' value='<?php echo "$CategoryCode" ; ?>'>
            <div class='row'>
                <div class='col-md-4'></div>
                <button class='col-md-4 btn btn-info' type='submit'>Add new Addon-Group</button>
                <div class='col-md-4'></div>

            </div>
        </form>




        </div>
    </div>






    <br><br><br><br>
    <div id="Div_Main_Sizes">
        <h1>All Sizes</h1>
        <hr><br><br>
        <div>
            <table class="table table-bordered table-hover" >

                <tr class="table-info">
                    <th>Sr. No</th>
                    <th>Size  Code</th>
                    <th>Size  Name</th>
                    <th>Size  Abbreviated Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>





                <?php
                foreach ($CategorySizesListArray as $Record){

                    $SizeId = $Record['size_id'] ;
                    $SizeSrNo = $Record['size_sr_no'] ;
                    $SizeCode = $Record['size_code'] ;
                    $SizeName = $Record['size_name'] ;
                    $SizeAbbrName = $Record['size_name_short'] ;




                    echo "
                        <tr>
                            <td>$SizeSrNo</td>
                            <td>$SizeCode</td>
                            <td>$SizeName</td>
                            <td>$SizeAbbrName</td>
                            
                            <td>
                                <form action='size_management/edit-size.php' method='post'>
                                    <input name='__size_id' type='hidden' value='$SizeId'>
                                    <input name='__category_code' type='hidden' value='$CategoryCode'>
                                    <input name='__size_code' type='hidden' value='$SizeCode'>

                                    <button class='btn btn-info' type='submit'>
                                        <i class='fa fa-edit'></i>  &nbsp; | &nbsp; Edit
                                    </button>
                                </form>
                            </td>

                            <td>
                                <form action='size_management/confirm-delete-size.php' method='post'>
                                    <input name='__size_code' type='hidden' value='$SizeCode'>
                                    <input name='__category_code' type='hidden' value='$CategoryCode' >
                                    <button class='btn btn-danger' type='submit'>
                                        <i class='fa fa-trash'></i>  &nbsp; | &nbsp; Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                        ";
                }
                ?>

            </table>


            <br><br>
            <form action='size_management/add_size.php' method='post'>
                <input name='__category_code' type='hidden' value='<?php echo "$CategoryCode" ; ?>'>
                <div class='row'>
                    <div class='col-md-4'></div>
                    <button class='col-md-4 btn btn-info' type='submit'>Add new Size-Variation</button>
                    <div class='col-md-4'></div>

                </div>
            </form>


        </div>
    </div>





</div>










