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

    $CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '___category_code') ;
    $AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '___addongroup_rel_id') ;


    $DBConnectionBackend = YOPDOSqlConnect() ;

    $SingleCategoryInfoArray = getSingleCategoryInfoArray_PDO($DBConnectionBackend, $CategoryCode) ;
//    $NoOfSizeVariations = intval($SingleCategoryInfoArray['category_no_of_size_variations']) ;


    
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


                            <input name="__addon_category_code" type="hidden" value='<?php echo "$CategoryCode" ; ?> '>
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
                                    $AllSizes = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $CategoryCode);
                                } catch (Exception $e) {
                                    die($e) ;
                                }

                                    foreach ($AllSizes as $Record){
                                        $SizeName = $Record['size_name'] ;
                                        $SizeId = $Record['size_id'] ;
                                        echo "
                                        <div class='form-group row'>
                                            <label for='input-addon-price-size_$SizeId' class='col-3 col-form-label'>Item Price ($SizeName)</label>
                                            <div class='col-md-9'>
                                                <input name='__addon_price_size_$SizeId' id='input-addon-price-size_$SizeId' class='form-control' type='text' placeholder='ex. 20'>
                                            </div>
                                        </div>  
                                    " ;
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
                $('#' + HiddenInputId).val('true') ;
            } else {
                // this is necessary if user checked it and then unchecked it.
                $('#' + HiddenInputId).val('false') ;
            }
        });
    }


    setupToggleButton('input-addon-active-presentation', 'input-addon-active-hidden') ;
</script>
</html>