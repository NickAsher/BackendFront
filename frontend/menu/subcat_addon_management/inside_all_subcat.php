
<?php
$CategorySubCategoriesListArray = getListOfAllSubCategory_InACategory_Array_PDO($DBConnectionBackend, $CategoryId) ;
$CategoryAddonsListArray = getListOfAllAddonGroupsInACategory_Array_PDO($DBConnectionBackend, $CategoryId) ;
$CategorySizesListArray = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $CategoryId) ;


?>



<div id="mainContent">

    <div id="Div_Main_Subcategories">


        <div style="display: block">
            <h1 style="display: inline-block; float: left;" >All Sub-Categories </h1>
            <form action="subcategory_management/sort-subcategory.php" method="post">
                <input name="__category_id" type="hidden" value="<?php echo $CategoryId ?>">
                <input type="submit" class="btn btn -info" style="display: inline-block;float: right" value="Sort This">
            </form>
            <br><br>
        </div>

        <hr><br><br>
        <div>
        <table class="table table-bordered table-hover" >

            <tr class="table-info">
                <th>Sr. No</th>
                <th>SubCategory Name</th>
                <th>SubCategory Active</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>





            <?php
            foreach ($CategorySubCategoriesListArray as $Record){
                $SubCategoryRelId = $Record['rel_id'] ;
                $SubCategorySrNo = $Record['subcategory_sr_no'] ;
                $SubCategoryDisplayName = $Record['subcategory_display_name'] ;

                $SubCategoryActive = $Record['subcategory_is_active'] ;
                $ActiveButton = '' ;
                if($SubCategoryActive == 'yes'){
                    $ActiveButton = "<div class='btn btn-success' disabled><i class='fa fa-check'></i></div>" ;
                } else if($SubCategoryActive == 'no'){
                    $ActiveButton = "<div class='btn btn-danger' disabled><i class='fa fa-times'></i></div>" ;
                }

                echo "
                <tr>
                    <td>$SubCategorySrNo</td>
                    <td>$SubCategoryDisplayName</td>
                    <td>$ActiveButton</td>
                    <td>
                        <form action='subcategory_management/edit-subcategory.php' method='post'>
                            <input name='__category_id' type='hidden' value='$CategoryId'>
                            <input name='__subcategory_rel_id' type='hidden' value='$SubCategoryRelId'>
                            <button class='btn btn-info' type='submit'>
                                <i class='fa fa-edit'></i>  &nbsp; | &nbsp; Edit
                            </button>                                           
                        </form>    
                    </td>
                    <td>
                        <form action='subcategory_management/confirm-delete-subcategory.php' method='post'>
                            <input name='__category_id' type='hidden' value='$CategoryId'>
                            <input name='__subcategory_rel_id' type='hidden' value='$SubCategoryRelId'>
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
            <input name='__category_id' type='hidden' value='<?php echo "$CategoryId" ; ?>'>
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

        <div style="display: block">
            <h1 style="display: inline-block; float: left;" >All Addon Groups</h1>
            <form action="addon_management/sort-addongroup.php" method="post">
                <input name="__category_id" type="hidden" value="<?php echo $CategoryId ?>">
                <input type="submit" class="btn btn -info" style="display: inline-block;float: right" value="Sort This">
            </form>
            <br><br>
        </div>

        <hr><br><br>
        <div>

        <table class="table table-bordered table-hover" >

            <tr class="table-info">
                <th>Sr. No</th>
                <th>Addon-Group Name</th>
                <th>Addon-Group Type</th>
                <td>Addon Active</td>
                <th>Edit</th>
                <th>Delete</th>
            </tr>





        <?php
        foreach ($CategoryAddonsListArray as $Record){
            $AddonGroupRelId = $Record['rel_id'] ;
            $AddonGroupCategorySrNo = $Record['addon_group_sr_no'] ;
            $AddonGroupDisplayName = $Record['addon_group_display_name'] ;

            $AddonGroupType = $Record['addon_group_type'] ;
            $AddonGroupTypeString = '' ;
            if($AddonGroupType == 'radio'){
                $AddonGroupTypeString = "Single-Select" ;
            } else if($AddonGroupType == 'checkbox'){
                $AddonGroupTypeString = "Multi-Select" ;
            } else {
                $AddonGroupTypeString = "Unknown-Select" ;
            }

            $AddonGroupActive = $Record['addon_group_is_active'] ;
            $ActiveButton = '' ;
            if($AddonGroupActive == 'yes'){
                $ActiveButton = "<div class='btn btn-success' disabled><i class='fa fa-check'></i></div>" ;
            } else if($AddonGroupActive == 'no'){
                $ActiveButton = "<div class='btn btn-danger' disabled><i class='fa fa-times'></i></div>" ;
            }

            echo "
                <tr>
                    <td>$AddonGroupCategorySrNo</td>
                    <td>$AddonGroupDisplayName</td>
                    <td>$AddonGroupTypeString</td>
                    <td>$ActiveButton</td>
                    <td>
                        <form action='addon_management/edit-addongroup.php' method='post'>
                            <input name='__addongroup_rel_id' type='hidden' value='$AddonGroupRelId'>
                            <button class='btn btn-info' type='submit'>
                                <i class='fa fa-edit'></i>  &nbsp; | &nbsp; Edit
                            </button>                                           
                        </form>    
                    </td>
                    <td>
                        <form action='addon_management/confirm-delete-addongroup.php' method='post'>
                            <input name='__category_id' type='hidden' value='$CategoryId'>
                            <input name='__addongroup_rel_id' type='hidden' value='$AddonGroupRelId'>
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
            <input name='__category_id' type='hidden' value='<?php echo "$CategoryId" ; ?>'>
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

        <div style="display: block">
            <h1 style="display: inline-block; float: left;" >All Sizes</h1>
            <form action="size_management/sort-size.php" method="post">
                <input name="__category_id" type="hidden" value="<?php echo $CategoryId ?>">
                <input type="submit" class="btn btn -info" style="display: inline-block;float: right" value="Sort This">
            </form>
            <br><br>
        </div>


        <hr><br><br>
        <div>
            <table class="table table-bordered table-hover" >

                <tr class="table-info">
                    <th>Sr. No</th>
                    <th>Size Image</th>
                    <th>Size  Name</th>
                    <th>Size  Abbreviated Name</th>
                    <th>Is Default</th>
                    <th>Size Active</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>





                <?php
                foreach ($CategorySizesListArray as $Record){
                    $SizeImage = $Record['size_image'] ;
                    $SizeId = $Record['size_id'] ;
                    $SizeSrNo = $Record['size_sr_no'] ;
                    $SizeName = $Record['size_name'] ;
                    $SizeAbbrName = $Record['size_name_short'] ;
                    $SizeIsDefault = $Record['size_is_default'] ;
                    $SizeActive = $Record['size_is_active'] ;
                    $ActiveButton = '' ;
                    if($SizeActive == 'yes'){
                        $ActiveButton = "<div class='btn btn-success' disabled><i class='fa fa-check'></i></div>" ;
                    } else if($SizeActive == 'no'){
                        $ActiveButton = "<div class='btn btn-danger' disabled><i class='fa fa-times'></i></div>" ;
                    }




                    echo "
                        <tr>
                            
                            <td>$SizeSrNo</td>
                            <td>
                                <img src='$IMAGE_BACKENDFRONT_LINK_PATH/$SizeImage' class='img-fluid' width = '80px' >
                            </td>
                            <td>$SizeName</td>
                            <td>$SizeAbbrName</td>
                            <td>$SizeIsDefault</td>
                            <td>$ActiveButton</td>
                            <td>
                                <form action='size_management/edit-size.php' method='post'>
                                    <input name='__size_id' type='hidden' value='$SizeId'>
                                    <input name='__category_id' type='hidden' value='$CategoryId'>

                                    <button class='btn btn-info' type='submit'>
                                        <i class='fa fa-edit'></i>  &nbsp; | &nbsp; Edit
                                    </button>
                                </form>
                            </td>

                            <td>
                                <form action='size_management/confirm-delete-size.php' method='post'>
                                    <input name='__size_id' type='hidden' value='$SizeId'>
                                    <input name='__category_id' type='hidden' value='$CategoryId' >
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
                <input name='__category_id' type='hidden' value='<?php echo "$CategoryId" ; ?>'>
                <div class='row'>
                    <div class='col-md-4'></div>
                    <button class='col-md-4 btn btn-info' type='submit'>Add new Size-Variation</button>
                    <div class='col-md-4'></div>

                </div>
            </form>


        </div>
    </div>





</div>










