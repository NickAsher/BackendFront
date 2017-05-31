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

    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../../common/css/classes.css">





    <?php

    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once '../utils/menu-utils.php';

    $CategoryCode = isSecure_checkPostInput('__category_code') ;
    
    
    $DBConnectionBackend = YOLOSqlConnect() ;








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

                    <div class="col-md-10" >
                        <form action="process-add-addongroup.php" method="post">

                            <input name="__category_code" type="hidden" value='<?php echo "$CategoryCode" ; ?>'>


                            <div class="form-group row">
                                <label for="input-addon-code" class="col-3 col-form-label">Addon-Group Code</label>
                                <div class="col-9">
                                    <input name="__addongroup_code" id="input-addon-code" class="form-control" type="text" placeholder="pizza_toppings">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="input-addon-code" class="col-3 col-form-label">Addon-Group Name</label>
                                <div class="col-9">
                                    <input name="__addongroup_name" id="input-addon-name" class="form-control" type="text" placeholder="Toppings">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="input-addon-type" class="col-3 col-form-label">Addon-Group Type</label>
                                <div class="col-9">
                                    <select name = "__addongroup_type" id="input-addon-type" class="form-control"  >
                                        <option selected disabled>Choose a Type</option>
                                        <option value="radio">Single-Select</option>
                                        <option value="checkbox">Multi-Select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-addon-ordering-no" class="col-3 col-form-label">Addon-Group Ordering No</label>
                                <div class="col-9">
                                    <input name="__addongroup_ordering_no" id="input-addon-ordering-no" class="form-control" type="number" placeholder="5">
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



<!--<div>--><?php //require_once "../../common/includes/footer.php" ?><!--</div>-->


</body>
<script type="text/javascript"  src="../../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
</html>