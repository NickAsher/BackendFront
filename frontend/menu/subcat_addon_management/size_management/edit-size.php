<?php

?>
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



    <?php

    require_once '../../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';
//    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';


    $DBConnectionBackend = YOPDOSqlConnect() ;

    $CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code') ;
    $SizeId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__size_id') ;

    $CategoryInfoArray = getSingleCategoryInfoArray_PDO($DBConnectionBackend, $CategoryCode) ;
    $CategoryName = $CategoryInfoArray['category_display_name'] ;
    try {
        $Record = getSingleSizeInfoArray_PDO($DBConnectionBackend, $SizeId);
    }catch (Exception $e){
        die($e->getMessage()) ;
    }


    $SizeId = $Record['size_id'] ;
    $SizeName = $Record['size_name'] ;
    $SizeNameAbbr = $Record['size_name_short'] ;
    $SizeIsActive = $Record['size_is_active'] ;
    $SizeSrNo = $Record['size_sr_no'] ;


    $ActiveCheckedString = null ;
    if($SizeIsActive == 'yes'){
        $ActiveCheckedString = "checked='checked' ";
    } else if($SizeIsActive == 'no'){
        $ActiveCheckedString = "";
    }


    ?>


</head>
<body>

<div><?php require_once "../../subcommon/includes/header.php" ?></div>

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
                        <form action="process-edit-size.php" method="post" enctype="multipart/form-data">

                            <input name="__category_code"  class="form-control" type="hidden" value="<?php echo $CategoryCode ; ?>" >
                            <input name="__size_id"  class="form-control" type="hidden" value="<?php echo $SizeId ; ?>" >


                            <div class="form-group row">
                                <label for="input-item-category" class="col-3 col-form-label">Category</label>
                                <div class="col-md-9">
                                    <input  id="input-item-category" class="form-control" type="text"  value="<?php echo $CategoryName ; ?>" readonly>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="input-size-name" class="col-3 col-form-label">Size Name</label>
                                <div class="col-md-9">
                                    <input name="__size_name" id="input-size-name" class="form-control" type="text"  value="<?php echo $SizeName ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-size-name_abbr" class="col-3 col-form-label">Size Name Abbreviated</label>
                                <div class="col-md-9">
                                    <input name="__size_name_abbr" id="input-size-name_abbr" class="form-control" type="text"  value="<?php echo $SizeNameAbbr ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-size-active-hidden" class="col-3 col-form-label">Size Active</label>
                                <div class="col-md-9">
                                    <input name="__size_is_active" id="input-size-active-hidden" class="form-control" type="hidden" value="<?php echo $SizeIsActive ?>" >
                                    <input id="input-size-active-presentation" type="checkbox" class="form-control" <?php echo $ActiveCheckedString ?> data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                </div>
                            </div>






                            <br><br>



                            <div class="form-group row">
                                <div class="col-4" ></div>
                                <input type="submit" class=" col-4 btn btn-info" value="Save">
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
    setupToggleButton('input-size-active-presentation', 'input-size-active-hidden') ;



</script>
<script >















</script>
</html>