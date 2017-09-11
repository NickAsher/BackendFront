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

    <link rel="stylesheet" href="../../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../../common/css/classes.css">




    <?php

    require_once '../../../utils/constants.php' ;
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';

    $CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Get, '___category_id') ;
    $AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Get, '___addongroup_rel_id') ;


    $DBConnectionBackend = YOPDOSqlConnect() ;

    $SingleCategoryInfoArray = getSingleCategoryInfoArray_PDO($DBConnectionBackend, $CategoryId) ;


    
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
                        <form action="process-add-addon.php" method="post">


                            <input name="__addon_category_code" type="hidden" value='<?php echo "$CategoryId" ; ?> '>
                            <input name="___addongroup_rel_id" type="hidden" value='<?php echo "$AddonGroupRelId" ; ?> '>



                            <div id="Div_Name" class="form-group row">
                                <label for="input-addon-name" class="col-3 col-form-label">Addon-Item Name</label>
                                <div class="col-md-9">
                                    <input name="__addon_name" id="input-addon-name" class="form-control" type="text" placeholder="pizza_toppings">
                                </div>
                            </div>


                            <div id="Div_Name" class="form-group row">
                                <label for="input-addon-active-hidden" class="col-3 col-form-label">Addon-Item Active</label>
                                <div class="col-md-9">
                                    <input name="__addon_is_active" id="input-addon-active-hidden" class="form-control" type="hidden" value="yes" >
                                    <input id="input-addon-active-presentation" type="checkbox" class="form-control" checked="checked" data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >

                                </div>
                            </div>




                            <div id="Div_Price">
                                <?php
                                try {
                                    $AllSizes = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $CategoryId);
                                } catch (Exception $e) {
                                    die($e) ;
                                }


                                foreach ($AllSizes as $Record){
                                $SizeName = $Record['size_name'] ;
                                $SizeId = $Record['size_id'] ;
                                ?>

                                <div class="form-group row">
                                    <label for="input-addon-size-active_<?php echo $SizeId ?>" class="col-3 col-form-label">Addon Price (<?php echo $SizeName ?>) </label>
                                    <div class="col-md-9 input-group">
                                        <input name = '__addon_size_active_<?php echo $SizeId ?>' id='input-addon-size-active_<?php echo $SizeId ?>' class='form-control' type='hidden' value='yes' >
                                        <input id='input-addon-size-active-presentation_<?php echo $SizeId ?>' type='checkbox' class='form-control' checked="checked"  data-toggle='toggle' data-width='50' data-onstyle='success' data-offstyle='danger' data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                        <input name='__addon_price_size_<?php echo $SizeId ?>' id='input-addon-price-size_<?php echo $SizeId ?>' class='form-control' type='text' style='margin-left: 20px; ; '  >
                                        <input  id='input-addon-price-size-presentation_<?php echo $SizeId ?>' class='form-control' type='text' style='margin-left: 20px; ;' placeholder='Empty' disabled >

                                    </div>
                                </div>

                                <?php
                                }




                                ?>
                            </div>













                            <br><br>



                            <div class="form-group row">
                                <div class="col-4" ></div>
                                <input type="submit" class=" col-4 btn btn-outline-info" value="Add">
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


    setupToggleButton('input-addon-active-presentation', 'input-addon-active-hidden') ;






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

        setUpToggleButtonForSizeActive('input-addon-size-active-presentation_'+SizeId, 'input-addon-size-active_'+SizeId, "input-addon-price-size_" + SizeId, "input-addon-price-size-presentation_"+SizeId ) ;

    }



</script>
</html>