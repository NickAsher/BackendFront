<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-16">
    <link rel="stylesheet" href="../../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap_addon.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap_toggle.css" >

    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />


    <link rel="stylesheet" href="../subcommon/css/fmenu_default_style.css">
    <link rel="stylesheet" href="../subcommon/css/menu.css">


    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';



    $MenuItemId = isSecure_checkGetInput('___menu_item_id') ;


    $DBConnectionBackend = YOLOSqlConnect() ;

    $MenuItemInfoArray = getSingleMenuItemInfoArray($DBConnectionBackend, $MenuItemId) ;


    $MenuItemName = $MenuItemInfoArray['item_name'] ;
    $MenuItemDescription = $MenuItemInfoArray['item_description'] ;
    $MenuItemImage = $MenuItemInfoArray['item_image_name'] ;
    $MenuItemCategoryCode = $MenuItemInfoArray['item_category_code'] ;
    $MenuItemSubCategoryCode = $MenuItemInfoArray['item_subcategory_code'] ;
    $CategoryName = $MenuItemInfoArray['category_display_name'] ;
    $SubCategoryName = $MenuItemInfoArray['subcategory_display_name'] ;
    $MenuItemActive = $MenuItemInfoArray['item_is_active'] ;
//    $NoOfSizeVariations = $MenuItemInfoArray['category_no_of_size_variations'] ;
    $ActiveCheckedString = null ;
    if($MenuItemActive == 'true'){
        $ActiveCheckedString = "checked='checked' ";
    } else if($MenuItemActive == 'false'){
        $ActiveCheckedString = "";
    }



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

                        <form action="process-edit-menuitem2.php" method="post" enctype="multipart/form-data" >


                            <input name="__item_id" type="hidden" value="<?php echo $MenuItemId ?>" >
                            <input name="__category_no_of_size_variations" type="hidden" value="<?php echo $NoOfSizeVariations ?>" >


                            <div class="form-group row">
                                <label for="input-item-category" class="col-3 col-form-label">Item Category</label>
                                <div class="col-md-9">
                                    <input id="input-item-category" class="form-control" type="text" value="<?php echo $CategoryName ; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-item-category" class="col-3 col-form-label">Item Sub-Category</label>
                                <div class="col-md-9">
                                    <input id="input-item-category" class="form-control" type="text" value="<?php echo $SubCategoryName ; ?>" readonly>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="input-item-name" class="col-3 col-form-label">Item Name</label>
                                <div class="col-md-9">
                                    <input name="__item_name" id="input-item-name" class="form-control" type="text" value="<?php echo $MenuItemName ; ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-item-description" class="col-3 col-form-label">Item Description</label>
                                <div class="col-md-9">
                                    <textarea  name="__item_description" id="input-item-description" class="form-control" rows="5" ><?php echo $MenuItemDescription ; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-item-active-hidden" class="col-3 col-form-label">Item Active</label>
                                <div class="col-md-9">
                                    <input name="__item_is_active" id="input-item-active-hidden" class="form-control" type="hidden" value="<?php echo $MenuItemActive ; ?>" >
                                    <input id="input-item-active-presentation" type="checkbox" class="form-control" <?php echo $ActiveCheckedString ?> data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >

                                </div>
                            </div>







                            <div id="Div_Price">
                                <?php

                                $Query = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_code` = '$MenuItemCategoryCode' " ;
                                $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
                                if(!$QueryResult){
                                    die("Unable to get the sizes for the item: ".mysqli_error($DBConnectionBackend)) ;
                                }

                                foreach ($QueryResult as $Record) {
                                    $SizeName = $Record['size_name'] ;
                                    $SizeCode = $Record['size_code'] ;

                                    $Query2 = "SELECT * FROM `menu_meta_rel_size-items_table` WHERE `item_id` = '$MenuItemId' AND `size_code` = '$SizeCode'  " ;
                                    $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
                                    if(!$QueryResult2) {
                                        die("Unable to fetch the record for the item for size $SizeCode :".mysqli_error($DBConnectionBackend) ) ;
                                    }
                                    $Record2 = mysqli_fetch_assoc($QueryResult2) ;
                                    $ItemPrice = $Record2['item_price'] ;

                                    echo "
                                        <div class='form-group row'>
                                            <label for='input-item-price-size_$SizeCode' class='col-3 col-form-label'>Item Price ($SizeName)</label>
                                            <div class='col-md-9'>
                                                <input name='__item_price_size_$SizeCode' id='input-item-price-size_$SizeCode' class='form-control' type='text' value='$ItemPrice'>
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
                                <div class="col-md-9">
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
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_toggle.js" ></script>

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




    function setupToggleButton(PresentationInputId, HiddenInputId){
        $('#' + PresentationInputId).on('change', function() {
            if(this.checked){
                $('#' + HiddenInputId).val('true') ;
            } else {
                // this is necessary if user checked it and then unchecked it.
                $('#' + HiddenInputId).val('false') ;
            }
        });
    }
    setupToggleButton('input-item-active-presentation', 'input-item-active-hidden') ;



</script>
</html>



