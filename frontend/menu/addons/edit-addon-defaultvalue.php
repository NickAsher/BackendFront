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
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';

    $CategoryCode = isSecure_checkGetInput('___category_code') ;
    $AddonGroupCode = isSecure_checkGetInput('___addongroup_code') ;




    $DBConnectionBackend = YOLOSqlConnect() ;

    $AllAddonItemsInGroup = getListOfAllAddonItemsInAddonGroup_Array($DBConnectionBackend, $CategoryCode, $AddonGroupCode) ;



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

                <form action="process-edit-addon-defaultvalue.php" method="post">

                    <div class="form-group row">
                        <input name="__category_code" type="hidden" value="<?php echo $CategoryCode ?> ">
                        <input name="__addongroup_code" type="hidden" value="<?php echo $AddonGroupCode ?> ">


                        <label for="input-cpn-valid-users" class="col-3 col-form-label">User Validity</label>
                        <div class="col-md-9">
                            <div id="input-cpn-valid-users" class="form-check">


                            <?php

                            foreach ($AllAddonItemsInGroup as $AddonRecord) {
                                $AddonId = $AddonRecord['item_id'];
                                $AddonName = $AddonRecord['item_name'];
                                $AddonIsDefault = $AddonRecord['item_is_default'];
                                echo "
                                    <label class='form-check-label'>
                                        <input name = '__addon_id'  class='form-check-inline' type='radio' value='$AddonId'>$AddonName
                                    </label>
                                " ;


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
