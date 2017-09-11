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
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap_toggle.css" >

    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../subcommon/css/fmenu_default_style.css">
    <link rel="stylesheet" href="../subcommon/css/menu.css">




    <?php

    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';


    $DBConnectionBackend = YOPDOSqlConnect() ;

    $CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Get, '___category_id') ;
    try {

    $CategoryInfoArray = getSingleCategoryInfoArray_PDO($DBConnectionBackend, $CategoryId) ;
    $ListoFSubCatetgoriesForCategory = getListOfAllSubCategory_InACategory_Array_PDO($DBConnectionBackend ,$CategoryId) ;
    $AllSizes = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $CategoryId);
    } catch (Exception $e) {
        die($e) ;
    }
    $CategoryName = $CategoryInfoArray['category_name'] ;


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




                            <div class="form-group row">
                                <label for="input-item-category" class="col-3 col-form-label">Category</label>
                                <div class="col-md-9">
                                    <input name="__item_category" id="input-item-category" class="form-control" type="text" value="<?php echo $CategoryId ; ?>" readonly>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="input-item-subcategory" class="col-3 col-form-label">Item Category</label>
                                <div class="col-md-9">
                                    <select name = "__item_subcategory_rel_id" class="form-control" id="input-item-subcategory" >
                                        <option selected disabled>Choose an Item SubCategory</option>
                                        <?php
                                        foreach ($ListoFSubCatetgoriesForCategory as $Record) {
                                            $SubCategoryRelId = $Record['rel_id'] ;
                                            $SubcategoryName = $Record['subcategory_display_name'] ;
                                            echo "
                                            <option value='$SubCategoryRelId'>$SubcategoryName</option>
                                            " ;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            



                            <div class="form-group row">
                                <label for="input-item-name" class="col-3 col-form-label">Item Name</label>
                                <div class="col-md-9">
                                    <input name="__item_name" id="input-item-name" class="form-control" type="text" placeholder="Ex. Super Cheesy Pizza"  >
                                </div>
                            </div>




                            <div id="Div_Price">
                                <?php


                                    foreach ($AllSizes as $Record){
                                        $SizeName = $Record['size_name'] ;
                                        $SizeId = $Record['size_id'] ;
                                        ?>

                                        <div class="form-group row">
                                            <label for="input-item-size-active_<?php echo $SizeId ?>" class="col-3 col-form-label">Item Price (<?php echo $SizeName ?>) </label>
                                            <div class="col-md-9 input-group">
                                                <input name = '__item_size_active_<?php echo $SizeId ?>' id='input-item-size-active_<?php echo $SizeId ?>' class='form-control' type='hidden' value='yes' >
                                                <input id='input-item-size-active-presentation_<?php echo $SizeId ?>' type='checkbox' class='form-control' checked="checked"  data-toggle='toggle' data-width='50' data-onstyle='success' data-offstyle='danger' data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                                <input name='__item_price_size_<?php echo $SizeId ?>' id='input-item-price-size_<?php echo $SizeId ?>' class='form-control' type='text' style='margin-left: 20px; ; '  >
                                                <input  id='input-item-price-size-presentation_<?php echo $SizeId ?>' class='form-control' type='text' style='margin-left: 20px; ;' placeholder='Empty' disabled >

                                            </div>
                                        </div>

                                        <?php
                                    }



                                ?>
                            </div>




                            <div class="form-group row">
                                <label for="input-item-description" class="col-3 col-form-label">Item Description</label>
                                <div class="col-md-9">
                                    <textarea name='__item_description' id="input-item-description" class="form-control" rows="3"  ></textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="input-item-active-hidden" class="col-3 col-form-label">Item Active</label>

                                <div class="col-md-9">
                                    <input name="__item_is_active" id="input-item-active-hidden" class="form-control" type="hidden" value="no"  >
                                    <input id="input-item-active-presentation" type="checkbox" class="form-control" data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-3 col-form-label">Item Image</label>
                                <div class="col-md-9 input-group">
                                    <input type="file" name="__item_image" style="width:0;padding:0px;" id="hidden-file-chooser">
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
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_toggle.js" ></script>

<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
<script >

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

            $('#' + PriceInputId_Presentaion).hide() ;



        $('#' + SizeActiveInputId_Presentation).on('change', function() {
            if(this.checked){
                $('#' + SizeActiveInputId).val('yes') ;
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

    var AllSizeArray = JSON.parse('<?php echo json_encode($AllSizes) ?>') ;
    for(i = 0; i<AllSizeArray.length; i++){
        var SizeId = AllSizeArray[i]['size_id'] ;
        console.log(SizeId) ;

        setUpToggleButtonForSizeActive('input-item-size-active-presentation_'+SizeId, 'input-item-size-active_'+SizeId, "input-item-price-size_" + SizeId, "input-item-price-size-presentation_"+SizeId ) ;

    }











</script>
</html>