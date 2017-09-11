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

    $PostAddonItemId = isSecure_isValidPositiveInteger(GetPostConst::Get, '___addon_item_id') ;

    
    $DBConnectionBackend = YOPDOSqlConnect() ;
    try {
        $AddonItemInfoArray = getSingleAddonItemInfoArray_PDO($DBConnectionBackend, $PostAddonItemId);
    } catch (Exception $e) {
        die($e->getMessage()) ;
    }

    $CategoryId = $AddonItemInfoArray['item_category_id'] ; //fetched to avoid prepared statements
    $AddonItemId = $AddonItemInfoArray['item_id'] ; // fetched to avoid prepared statements
    
    $AddonItemName = $AddonItemInfoArray['item_name'] ;
    $AddonItemIsActive = $AddonItemInfoArray['item_is_active'] ;

    $ActiveCheckedString = null ;
    if($AddonItemIsActive == 'yes'){
        $ActiveCheckedString = "checked='checked' ";
    } else if($AddonItemIsActive == 'no'){
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
                    <div class = col-md-2></div>
                    <div class="col-md-9" >


                        <form action="process-edit-addon.php" method="post">


                            <input name='__category_id'  type='hidden' value="<?php echo $CategoryId ; ?>">
                            <input name='__addon_item_id'  type='hidden' value="<?php echo $AddonItemId ; ?>">



                            <div class="form-group row">
                                <label for ='input-item-name' class="col-3 col-form-label">Addon-Item Name</label>
                                <div class="col-md-9">
                                    <input name="__addon_item_name" id="input-item-name" class="form-control" type="text" value="<?php echo $AddonItemName ; ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for='input-item-active-hidden' class="col-3 col-form-label">Addon-Item Active</label>
                                <div class="col-md-9">
                                    <input name="__addon_is_active" id="input-item-active-hidden" class="form-control" type="hidden" value="<?php echo $AddonItemIsActive ; ?>" >
                                    <input id="input-item-active-presentation" type="checkbox" class="form-control" <?php echo $ActiveCheckedString ?> data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                </div>
                            </div>



                            <div id="Div_Price">
                                
                                
                                

                                <?php




                                $Query = "SELECT `a`.`size_name`, `b`.*
                                FROM `menu_meta_size_table` AS `a` INNER JOIN `menu_meta_rel_size_addons_table` AS `b`
                                ON `a`.`size_id` = `b`.`size_id` 
                                WHERE `b`.`addon_id` = :addon_id  ORDER BY `a`.`size_sr_no` ASC  " ;

                                try {
                                    $QueryResult = $DBConnectionBackend->prepare($Query);
                                    $QueryResult->execute([
                                        'addon_id' => $AddonItemId
                                    ]);
                                    $AllSizesPriceList = $QueryResult->fetchAll();
                                }catch (Exception $e){
                                    die("Error in getting the size price list : ".$e->getMessage()) ;
                                }

                                foreach($AllSizesPriceList as $Record){
                                    $SizeName = $Record['size_name'] ;
                                    $SizeId = $Record['size_id'] ;
                                    $AddonPrice = $Record['addon_price'] ;
                                    $IsActive = $Record['addon_size_active'] ;

                                    $ItemSizeActiveString = '' ;
                                    if($IsActive == 'yes'){
                                        $ItemSizeActiveString =   "checked='checked' ";
                                    } else if($IsActive == 'no') {
                                        $ItemSizeActiveString = '' ;
                                    }






                                    ?>
                                    <div class="form-group row">
                                        <label for="input-addon-size-active_<?php echo $SizeId ?>" class="col-3 col-form-label">Addon Price (<?php echo $SizeName ?>) </label>
                                        <div class="col-md-9 input-group">
                                            <input name = '__addon_size_active_<?php echo $SizeId ?>' id='input-addon-size-active_<?php echo $SizeId ?>' class='form-control' type='hidden' value='<?php echo $IsActive ?>' >
                                            <input id='input-addon-size-active-presentation_<?php echo $SizeId ?>' type='checkbox' class='form-control' <?php echo $ItemSizeActiveString ?>  data-toggle='toggle' data-width='50' data-onstyle='success' data-offstyle='danger' data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                            <input name='__addon_price_size_<?php echo $SizeId ?>' id='input-addon-price-size_<?php echo $SizeId ?>' class='form-control' type='text' style='margin-left: 20px; ; ' value='<?php echo $AddonPrice ?>' >
                                            <input  id='input-addon-price-size-presentation_<?php echo $SizeId ?>' class='form-control' type='text' style='margin-left: 20px; ;' placeholder='Empty' disabled >

                                        </div>
                                    </div>
                                    <?php




                                }



                                ?>



                            </div>










                            <br><br><br>


                            <div class="form-group row">
                                <div class="col-4" ></div>
                                <input type="submit" class=" col-4 btn btn-info" value="Save Edits">
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

<div><?php require_once "../../common/includes/footer.php" ?></div>


</body>
<script type="text/javascript"  src="../../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_toggle.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>

<script type="text/javascript">


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
        var SizeId = ItemSizePriceActive_Array[i]['size_id'] ;
        console.log(SizeId) ;

        setUpToggleButtonForSizeActive('input-addon-size-active-presentation_'+SizeId, 'input-addon-size-active_'+SizeId, "input-addon-price-size_" + SizeId, "input-addon-price-size-presentation_"+SizeId ) ;

    }
    
</script>

</html>