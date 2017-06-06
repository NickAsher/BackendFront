<?php

?>
<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-16">
    <link rel="stylesheet" href="../../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap_addon.css" >

    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../subcommon/css/fmenu_default_style.css">
    <link rel="stylesheet" href="../subcommon/css/menu.css">




    <link rel="stylesheet" href="../../items/css/fmenu_default_style.css">
    <link rel="stylesheet" href="../../items/css/menu.css">

    <?php

    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';


    $DBConnectionBackend = YOLOSqlConnect() ;

    $CategoryCode = isSecure_checkGetInput('___category_code') ;
    $CategoryInfoArray = getSingleCategoryInfoArray($DBConnectionBackend, $CategoryCode) ;
    $ListoFSubCatetgoriesForCategory = getListOfAllSubCategory_InACategory_Array($DBConnectionBackend ,$CategoryCode) ;
    
    $CategoryName = $CategoryInfoArray['category_display_name'] ;
    $NoOfSizeVariations = intval($CategoryInfoArray['category_no_of_size_variations']) ;
    

    ?>


</head>
<body>

<div><?php require_once "../subcommon/includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12 bg-white">




                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>



                <div class="row">
                    <div class = col-md-1></div>

                    <div id="Section_AddNewItemForm" class="col-md-10" >
                        <form action="process-add-menuitem.php" method="post" enctype="multipart/form-data">

                            <input name="__item_no_of_size_variations" value='<?php echo $NoOfSizeVariations ?>' type="hidden">



                            <div class="form-group row">
                                <label for="input-item-category" class="col-3 col-form-label">Category</label>
                                <div class="col-9">
                                    <input name="__item_category" id="input-item-category" class="form-control" type="text" value="<?php echo $CategoryCode ; ?>" readonly>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="input-item-subcategory" class="col-3 col-form-label">Item Category</label>
                                <div class="col-9">
                                    <select name = "__item_subcategory" class="form-control" id="input-item-subcategory" >
                                        <option selected disabled>Choose an Item SubCategory</option>
                                        <?php
                                        foreach ($ListoFSubCatetgoriesForCategory as $Record) {
                                            $SubCategoryCode = $Record['subcategory_code'] ;
                                            $SubcategoryName = $Record['subcategory_display_name'] ;
                                            echo "
                                            <option value='$SubCategoryCode'>$SubcategoryName</option>
                                            " ;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            



                            <div class="form-group row">
                                <label for="input-item-name" class="col-3 col-form-label">Item Name</label>
                                <div class="col-9">
                                    <input name="__item_name" class="form-control" type="text" placeholder="Ex. Super Cheesy Pizza" id="input-item-name" >
                                </div>
                            </div>




                            <div id="Div_Price">
                                <?php
                                $Query = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_code` = '$CategoryCode' ORDER BY `size_id` " ;
                                $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
                                if($QueryResult){
                                    foreach ($QueryResult as $Record){
                                        $SizeName = $Record['size_name'] ;
                                        $SizeCode = $Record['size_code'] ;
                                        echo "
                                        <div class='form-group row'>
                                            <label for='input-item-price-size_$SizeCode' class='col-3 col-form-label'>Item Price ($SizeName)</label>
                                            <div class='col-9'>
                                                <input name='__item_price_size_$SizeCode' id='input-item-price-size_$SizeCode' class='form-control' type='text' placeholder='ex. 20'>
                                            </div>
                                        </div>  
                                    " ;
                                    }
                                } else {
                                    die("Unable to get the sizes for the item :".mysqli_error($DBConnectionBackend) ) ;
                                }


                                ?>
                            </div>




                            <div class="form-group row">
                                <label for="input-item-description" class="col-3 col-form-label">Item Description</label>
                                <div class="col-9">
                                    <textarea name='__item_description' class="form-control" rows="3" id="input-item-description" ></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-3 col-form-label">Item Image</label>
                                <div class="col-9 input-group">
                                    <input type="file" name="__item_image" style="width:0;" id="hidden-file-chooser">
                                    <input type="text" id="presentation-only-field" class="form-control" >
                                    <button id="btn-file-choose" class="input-group-addon">Browse</button>
                                </div>
                            </div>

                            <br><br>



                            <div class="form-group row">
                                <div class="col-4" ></div>
                                <input type="submit" class=" col-4 btn btn-info" value="Add">
                                <div class="col-4" ></div>
                            </div>










                        </form>
                    </div>

                    <div class="col-md-1"></div>


                </div>

                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>





            </div>
        </div>
    </div>
</section>



<!--<div>--><?php //require_once "../common/includes/footer.php" ?><!--</div>-->


</body>
<script type="text/javascript"  src="../../../lib/jquery/jquery.js"></script>
<script src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script src="../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript" src="../../../lib/t3/t3.js"></script>
<script >

    $('#btn-file-choose').click(function (event) {
        event.preventDefault() ;
        $('#hidden-file-chooser').click();

        $('#hidden-file-chooser').change(function(){
            $('#presentation-only-field').val($(this).val());
            return false ;
        });


    }) ;













</script>
</html>