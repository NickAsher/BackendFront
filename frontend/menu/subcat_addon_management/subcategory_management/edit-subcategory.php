<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-16">
    <link rel="stylesheet" href="../../../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap_addon.css" >
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap_toggle.css" >

    <link rel="stylesheet" href="../../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../../../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../../../common/css/classes.css">





    <?php

    require_once '../../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;

    $DBConnectionBackend = YOPDOSqlConnect() ;

    $CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code') ;
    $SubCategoryRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__subcategory_rel_id') ;

    $SubCategoryInfoArray = getSingleSubCategoryInfoArray_PDO($DBConnectionBackend, $SubCategoryRelId) ;
    $RelId = $SubCategoryInfoArray['rel_id'] ;
    $CategoryCode = $SubCategoryInfoArray['category_code'] ;
    $SubCategoryName = $SubCategoryInfoArray['subcategory_display_name'] ;
    $SubCategoryIsActive = $SubCategoryInfoArray['subcategory_is_active'] ;
    $SubCategorySrNo = $SubCategoryInfoArray['subcategory_sr_no'] ;

    $ActiveCheckedString = null ;
    if($SubCategoryIsActive == 'yes'){
        $ActiveCheckedString = "checked='checked' ";
    } else if($SubCategoryIsActive == 'no'){
        $ActiveCheckedString = "";
    }



    ?>


</head>
<body>

<!--<div>--><?php //require_once "../../subcommon/includes/header.php" ?><!--</div>-->

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

                    <div class="col-md-10" >
                        <form action="process-edit-subcategory.php" method="post">

                            <input name="__rel_id" type="hidden" value="<?php echo $RelId ; ?>">





                            <div class="form-group row">
                                <label for="input-subcat-code" class="col-3 col-form-label">Subcategory Name</label>
                                <div class="col-md-9">
                                    <input name="__subcategory_name" id="input-subcat-name" class="form-control" type="text" value='<?php echo $SubCategoryName ; ?>'>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-subcat-active-hidden" class="col-3 col-form-label">Subcategory Active</label>
                                <div class="col-md-9">
                                    <input name="__subcategory_is_active" id="input-subcat-active-hidden" class="form-control" type="hidden" value='<?php echo $SubCategoryIsActive ; ?>'>
                                    <input id="input-subcat-active-presentation" type="checkbox" class="form-control" <?php echo $ActiveCheckedString ?> data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                </div>
                            </div>









                            <br><br>



                            <div class="form-group row">
                                <div class="col-4" ></div>
                                <input type="submit" class=" col-4 btn btn-info" value="Save Changes">
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
<script type="text/javascript"  src="../../../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../../../lib/t3/t3.js"></script>
<script type="text/javascript"  src="../../../../lib/bootstrap4/bootstrap_toggle.js" ></script>

<script>

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
    setupToggleButton('input-subcat-active-presentation', 'input-subcat-active-hidden') ;



</script>
</html>