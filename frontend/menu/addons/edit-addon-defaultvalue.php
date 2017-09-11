<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-8">



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
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';
//    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';

    $CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;
    $AddonGroupRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__addongroup_rel_id') ;




    $DBConnectionBackend = YOPDOSqlConnect() ;
    $AddonGroupInfo = getSingleAddonGroupInfoArray_PDO($DBConnectionBackend, $AddonGroupRelId) ;

    $AllAddonItemsInGroup = getListOfAllAddonItemsInAddonGroup_Array_PDO($DBConnectionBackend, $AddonGroupRelId) ;



    ?>



</head>



<body>
<?php require_once "../subcommon/includes/header.php" ?>

<section>
        <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12 bg-white">



                <div id="space_below_header">
                    <br><br><br>
                </div>

                <div id="heading">
                    <br>
                    <h1 class="text-center">Choose Default value for Addon Group <?php echo $AddonGroupInfo['addon_group_display_name']?></h1>
                    <br><br>
                </div>

                <form action="process-edit-addon-defaultvalue.php" method="post">

                    <div class="form-group row">
                        <input name="__category_id" type="hidden" value="<?php echo $CategoryId ?> ">
                        <input name="__addongroup_rel_id" type="hidden" value="<?php echo $AddonGroupRelId ?> ">


                        <label for="input-cpn-valid-users" class="col-3 col-form-label">Default Value</label>
                        <div class="col-md-9">
                            <div id="input-cpn-valid-users" class="form-check">


                            <?php

                            foreach ($AllAddonItemsInGroup as $AddonRecord) {
                                $AddonId = $AddonRecord['item_id'];
                                $AddonName = $AddonRecord['item_name'];
                                $AddonIsDefault = $AddonRecord['item_is_default'];

                                if($AddonIsDefault == 'yes'){
                                    echo "
                                        <label class='form-check-label'>
                                            <input checked='checked' name = '__addon_id'  class='form-check-inline' type='radio' value='$AddonId'>$AddonName
                                        </label>
                                        <br>
                                    " ;
                                } else if ($AddonIsDefault == 'no') {
                                    echo "
                                        <label class='form-check-label'>
                                            <input name = '__addon_id'  class='form-check-inline' type='radio' value='$AddonId'>$AddonName
                                        </label>
                                        <br>
                                    ";
                                }


                            }
                            ?>
                            </div>
                        </div>
                        <input type="submit" value="Submit">
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
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>


<script>
    $('.tickelement').click(function () {
        $('.tickelement').removeClass('card-success') ;
        $('.tickelement').addClass('card-primary') ;
        $(this).css('cursor:pointer') ;
        $(this).removeClass('card-primary') ;
        $(this).addClass('card-success') ;
    }) ;
</script>

</html>
