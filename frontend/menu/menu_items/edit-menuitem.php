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


<!--    <link rel="stylesheet" href="../subcommon/css/fmenu_default_style.css">-->
<!--    <link rel="stylesheet" href="../subcommon/css/menu.css">-->


    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';



    $MenuItemId = isSecure_isValidPositiveInteger(GetPostConst::Get, '___menu_item_id') ;


    $DBConnectionBackend = YOPDOSqlConnect() ;

    $MenuItemInfoArray = getSingleMenuItemInfo_EXTRAArray_PDO($DBConnectionBackend, $MenuItemId) ;


    $MenuItemName = $MenuItemInfoArray['item_name'] ;
    $MenuItemDescription = $MenuItemInfoArray['item_description'] ;
    $MenuItemImage = $MenuItemInfoArray['item_image_name'] ;
    $MenuItemCategoryCode = $MenuItemInfoArray['item_category_id'] ;
    $CategoryName = $MenuItemInfoArray['category_name'] ;
    $SubCategoryName = $MenuItemInfoArray['subcategory_display_name'] ;
    $MenuItemActive = $MenuItemInfoArray['item_is_active'] ;

    $ActiveCheckedString = null ;
    if($MenuItemActive == 'yes'){
        $ActiveCheckedString = "checked='checked' ";
    } else if($MenuItemActive == 'no'){
        $ActiveCheckedString = "";
    }



    ?>
</head>



<body style="background: whitesmoke;">



<div><?php require_once "../subcommon/includes/header.php" ?></div>
<section>
        <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">

            <div class="col-md-12">




                <div id="space_below_header">
                    <br><br><br>
                </div>


                <div class="row">
                    <div class="push-md-1 col-md-10">
                        <div class="card">
                            <div class="card-block">
                                <h1 class="text-center">Edit Menu Item:  <?php echo $MenuItemName ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <br><br>

                <form action="process-edit-menuitem.php" method="post" enctype="multipart/form-data" >




                <div class="row">

                    <div class="push-md-1 col-md-10" >
                        <div class="card">
                            <div class="card-block">



                            <input name="__item_id" type="hidden" value="<?php echo $MenuItemId ?>" >


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

                                $Query = "SELECT  `a`.`size_name`,`b`.*
                                FROM `menu_meta_size_table` AS `a` INNER JOIN `menu_meta_rel_size_items_table` AS `b`
                                ON `a`.`size_id` = `b`.`size_id`  
                                WHERE `b`.`item_id` = :item_id ORDER BY `a`.`size_sr_no` ASC  " ;

                                try {
                                    $QueryResult = $DBConnectionBackend->prepare($Query);
                                    $QueryResult->execute([
                                        'item_id' => $MenuItemId
                                    ]);
                                    $AllSizesPriceList = $QueryResult->fetchAll();
                                }catch (Exception $e){
                                    die("Error in getting the size price list : ".$e->getMessage()) ;
                                }

                                foreach($AllSizesPriceList as $Record){
                                    $SizeName = $Record['size_name'] ;
                                    $SizeId = $Record['size_id'] ;
                                    $ItemPrice = $Record['item_price'] ;
                                    $IsActive = $Record['item_size_active'] ;

                                    $ItemSizeActiveString = '' ;
                                    if($IsActive == 'yes'){
                                        $ItemSizeActiveString =   "checked='checked' ";
                                    } else if($IsActive == 'no') {
                                        $ItemSizeActiveString = '' ;
                                    }






                                        ?>
                                        <div class="form-group row">
                                            <label for="input-item-size-active_<?php echo $SizeId ?>" class="col-3 col-form-label">Item Price (<?php echo $SizeName ?>) </label>
                                            <div class="col-md-9 input-group">
                                                <input name = '__item_size_active_<?php echo $SizeId ?>' id='input-item-size-active_<?php echo $SizeId ?>' class='form-control' type='hidden' value='<?php echo $IsActive ?>' >
                                                <input id='input-item-size-active-presentation_<?php echo $SizeId ?>' type='checkbox' class='form-control' <?php echo $ItemSizeActiveString ?>  data-toggle='toggle' data-width='50' data-onstyle='success' data-offstyle='danger' data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                                <input name='__item_price_size_<?php echo $SizeId ?>' id='input-item-price-size_<?php echo $SizeId ?>' class='form-control' type='text' style='margin-left: 20px; ; ' value='<?php echo $ItemPrice ?>' >
                                                <input  id='input-item-price-size-presentation_<?php echo $SizeId ?>' class='form-control' type='text' style='margin-left: 20px; ;' placeholder='Empty' disabled >

                                            </div>
                                        </div>
                                        <?php




                                }



//

                                ?>


                            </div>







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





                            </div>
                        </div>

                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="push-md-1 col-md-10">
                        <div class="card">
                            <div class="card-block" style="text-align: center">
                                <div class="row">
                                    <button type="submit"  class="push-md-2 col-md-8 btn btn-info"  >Save Edits</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </form>



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
<script type="text/javascript">




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
                $('#' + HiddenInputId).val('yes') ;
            } else {
                // this is necessary if user checked it and then unchecked it.
                $('#' + HiddenInputId).val('no') ;
            }
        });
    }
    setupToggleButton('input-item-active-presentation', 'input-item-active-hidden') ;





    function setUpToggleButtonForSizeActive(SizeActiveInputId_Presentation, SizeActiveInputId, PriceInputId, PriceInputId_Presentaion){
        var OriginalPriceVal = $('#' + PriceInputId).val() ;
        var SizeActiveVal =  $('#' + SizeActiveInputId).val() ;



        if (OriginalPriceVal == '0.0' || SizeActiveVal == 'no'){
            $('#' + PriceInputId).hide() ;
            $('#' + PriceInputId_Presentaion).show() ;
        } else if (OriginalPriceVal != '0.0' && SizeActiveVal == 'yes') {
            $('#' + PriceInputId).show() ;
            $('#' + PriceInputId_Presentaion).hide() ;
        }


        $('#' + SizeActiveInputId_Presentation).on('change', function() {
            if(this.checked){
                $('#' + SizeActiveInputId).val('yes') ;
                $('#' + PriceInputId).val(OriginalPriceVal) ;
                $('#' + PriceInputId).prop('readonly', false) ;
                $('#' + PriceInputId).show() ;
                $('#' + PriceInputId_Presentaion).hide() ;


            } else {
                // this is necessary if user checked it and then unchecked it.
                $('#' + SizeActiveInputId).val('no') ;
                $('#' + PriceInputId).val('0.0') ;
                $('#' + PriceInputId).prop('readonly', true) ;
                $('#' + PriceInputId).hide() ;
                $('#' + PriceInputId_Presentaion).show() ;


            }
        });
    }

    var ItemSizePriceActive_Array = JSON.parse('<?php echo json_encode($AllSizesPriceList) ?>') ;
    for(i = 0;i<ItemSizePriceActive_Array.length; i++){
        var ItemId = ItemSizePriceActive_Array[i]['size_id'] ;
        console.log(ItemId) ;

        setUpToggleButtonForSizeActive('input-item-size-active-presentation_'+ItemId, 'input-item-size-active_'+ItemId, "input-item-price-size_" + ItemId, "input-item-price-size-presentation_"+ItemId ) ;

    }





</script>
</html>



