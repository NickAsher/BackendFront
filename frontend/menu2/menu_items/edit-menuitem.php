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


    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once '../utils/menu-utils.php';
    require_once '../utils/menu_item-utils.php';


    $MenuItemId = isSecure_checkGetInput('___menu_item_id') ;


    $DBConnectionBackend = YOLOSqlConnect() ;

    $MenuItemInfoArray = getSingleMenuItemInfoView_Array($DBConnectionBackend, $MenuItemId) ;


    $MenuItemName = $MenuItemInfoArray['item_name'] ;
    $MenuItemDescription = $MenuItemInfoArray['item_description'] ;
    $MenuItemImage = $MenuItemInfoArray['item_image_name'] ;
    $MenuItemCategoryCode = $MenuItemInfoArray['item_category_code'] ;
    $MenuItemSubCategoryCode = $MenuItemInfoArray['item_subcategory_code'] ;
    $CategoryName = $MenuItemInfoArray['category_display_name'] ;
    $SubCategoryName = $MenuItemInfoArray['subcategory_display_name'] ;
    $NoOfSizeVariations = $MenuItemInfoArray['category_no_of_size_variations'] ;





    ?>
</head>



<body>



<div><?php require_once "../subcommon/includes/header.php" ?></div>
<section>
        <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">

            <div class="col-md-12">




                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>




                <div class="row">
                    <div class = col-md-1></div>
                    <div class="col-md-10" >

                        <form action="process-edit-menuitem.php" method="post" enctype="multipart/form-data" >


                            <input name="__item_id" type="hidden" value="<?php echo $MenuItemId ?>" >
                            <input name="__category_no_of_size_variations" type="hidden" value="<?php echo $NoOfSizeVariations ?>" >


                            <div class="form-group row">
                                <label for="input-item-category" class="col-3 col-form-label">Item Category</label>
                                <div class="col-9">
                                    <input id="input-item-category" class="form-control" type="text" value="<?php echo $CategoryName ; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-item-category" class="col-3 col-form-label">Item Sub-Category</label>
                                <div class="col-9">
                                    <input id="input-item-category" class="form-control" type="text" value="<?php echo $SubCategoryName ; ?>" readonly>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="input-item-name" class="col-3 col-form-label">Item Name</label>
                                <div class="col-9">
                                    <input name="__item_name" id="input-item-name" class="form-control" type="text" value="<?php echo $MenuItemName ; ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-item-description" class="col-3 col-form-label">Item Description</label>
                                <div class="col-9">
                                    <textarea  name="__item_description" id="input-item-description" class="form-control" rows="5" ><?php echo $MenuItemDescription ; ?></textarea>
                                </div>
                            </div>






                            <div id="Div_Price">
                                <?php
                                for($i = 1; $i<=$NoOfSizeVariations; $i++){
                                    $Query = "SELECT * FROM `menu_items_price_view` WHERE `item_id` = '$MenuItemId' AND `size_sr_no` = '$i' " ;
                                    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
                                    $Record = mysqli_fetch_assoc($QueryResult) ;

                                    $SizeName = $Record['size_name'] ;
                                    $ItemPrice = $Record['item_price'] ;

                                    echo "
                                        <div class='form-group row'>
                                            <label for='input-item-price-size$i' class='col-3 col-form-label'>Item Price ($SizeName)</label>
                                            <div class='col-9'>
                                                <input name='__item_price_size$i' id='input-item-price-size$i' class='form-control' type='text' value='$ItemPrice'>
                                            </div>
                                        </div>  
                                    " ;
                                }
                                ?>
                            </div>

                            <?php




                            ?>







                            <br>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Item Image</label>
                                <div class="col-9">
                                    <div class="row form-control">
                                        <div class="col-6">
                                            <img src="<?php echo "$IMAGE_BACKENDFRONT_LINK_PATH/$MenuItemImage "; ?>" class="img-fluid" width="180" >
                                        </div>
                                        <div class="col-6 ">
                                            <br><br><br><br>
                                            <div class="row input-group">
                                                <button id="btn-file-choose" class="input-group-addon">Change Image</button>
                                                <input type="file" name="__new_item_image" style="width:0;" id="hidden-file-chooser">
                                                <input type="text" id="presentation-only-field" class="form-control" >
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <br><br><br>



                            <div class="row">
                                <div class="col-4" ></div>
                                <input type="submit" class=" col-4 btn btn-outline-info" value="Save Edits">
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

<!--<div>--><?php //require_once "../../common/includes/footer.php" ?><!--</div>-->


</body>
<script type="text/javascript"  src="../../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
<script>
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


