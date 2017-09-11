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

    <link rel="stylesheet" href="../../../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../../../common/css/classes.css">





    <?php

    require_once '../../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;



    $DBConnectionBackend = YOPDOSqlConnect() ;

    $AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addongroup_rel_id') ;

    $AddonGroupInfoArray = getSingleAddonGroupInfoArray_PDO($DBConnectionBackend, $AddonGroupRelId) ;
    $CategoryId = $AddonGroupInfoArray['category_id'] ;
    $AddonGroupName = $AddonGroupInfoArray['addon_group_display_name'] ;
    $AddonGroupType = $AddonGroupInfoArray['addon_group_type'] ;
    $AddonGroupIsActive = $AddonGroupInfoArray['addon_group_is_active'] ;
    $AddonGroupSrNo = $AddonGroupInfoArray['addon_group_sr_no'] ;

    $AddonGroupTypeString = null;
    if($AddonGroupType == 'radio'){
        $AddonGroupTypeString = "Single-Select" ;
    } else if($AddonGroupType == 'checkbox'){
        $AddonGroupTypeString = "Multi-Select" ;

    }


    $ActiveCheckedString = null ;
    if($AddonGroupIsActive == 'yes'){
        $ActiveCheckedString = "checked='checked' ";
    } else if($AddonGroupIsActive == 'no'){
        $ActiveCheckedString = "";
    }












    ?>


</head>
<body>

<?php require_once $ROOT_FOLDER_PATH.'/frontend/menu/subcommon/includes/header.php'; ?>


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
                        <form action="process-edit-addongroup.php" method="post">

                            <input name="__category_id" type="hidden" value='<?php echo "$CategoryId" ; ?>'>
                            <input name="__addongroup_rel_id" type="hidden" value='<?php echo "$AddonGroupRelId" ; ?>'>





                            <div class="form-group row">
                                <label for="input-addon-code" class="col-3 col-form-label">Addon-Group Name</label>
                                <div class="col-md-9">
                                    <input name="__addongroup_name" id="input-addon-name" class="form-control" type="text" value="<?php echo $AddonGroupName?>" >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="input-addon-type" class="col-3 col-form-label">Addon-Group Type</label>
                                <div class="col-md-9">
                                    <input id="input-addon-type" class="form-control" type="text" value="<?php echo $AddonGroupTypeString ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-addon-active-hidden" class="col-3 col-form-label">Addon-Group Active</label>
                                <div class="col-md-9">
                                    <input name="__addongroup_is_active" id="input-addon-active-hidden" class="form-control" type="hidden" value="<?php echo $AddonGroupIsActive ?>">
                                    <input id="input-addon-active-presentation" type="checkbox" class="form-control" <?php echo $ActiveCheckedString ?> data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
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
    setupToggleButton('input-addon-active-presentation', 'input-addon-active-hidden') ;



</script>
</html>