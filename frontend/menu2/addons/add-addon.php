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

    require_once '../../../utils/constants.php' ;
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once '../utils/menu-utils.php';

    $CategoryCode = isSecure_checkGetInput('___category_code') ;
    $AddonGroupCode = isSecure_checkGetInput('___addongroup_code') ;


    $DBConnectionBackend = YOLOSqlConnect() ;

    $SingleCategoryInfoArray = getSingleCategoryInfoArray($DBConnectionBackend, $CategoryCode) ;
    $NoOfSizeVariations = intval($SingleCategoryInfoArray['category_no_of_size_variations']) ;


    
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
                            <input name="__addon_group_code" type="hidden" value='<?php echo "$AddonGroupCode" ; ?> '>
                            <input name="__item_no_of_size_variations" type="hidden" value='<?php echo "$NoOfSizeVariations" ; ?> '>



                            <div id="Div_Name" class="form-group row">
                                <label for="input-addon-name" class="col-3 col-form-label">Addon-Item Name</label>
                                <div class="col-9">
                                    <input name="__addon_name" id="input-addon-name" class="form-control" type="text" placeholder="pizza_toppings">
                                </div>
                            </div>

                            <div id="Div_Price">

                            <?php
                            switch ($NoOfSizeVariations){
                                case 1 :
                                    echo "
                                            <div class='form-group row'>
                                                <label for='input-addon-price-size1' class='col-3 col-form-label'>Addon-Item Price</label>
                                                <div class='col-9'>
                                                    <input name='__addon_price_size1' id='input-addon-price-size1' class='form-control' type='text' placeholder='pizza_toppings'>
                                                </div>
                                            </div>
                                             
                                            <input name='__addon_price_size2' type='hidden' value='-1'>
                                            <input name='__addon_price_size3' type='hidden' value='-1'>
                                        " ;
                                    break ;
                                case 2 :
                                    echo "
                                            <div class='form-group row'>
                                                <label for='input-addon-price-size1' class='col-3 col-form-label'>Addon-Item Price-Size1</label>
                                                <div class='col-9'>
                                                    <input name='__addon_price_size1' id='input-addon-price-size1' class='form-control' type='text' placeholder='40'>
                                                </div>
                                            </div>
                                             
                                            <div class='form-group row'>
                                                <label for='input-addon-price-size2' class='col-3 col-form-label'>Addon-Item Price-Size2</label>
                                                <div class='col-9'>
                                                    <input name='__addon_price_size2' id='input-addon-price-size2' class='form-control' type='text' placeholder='40'>
                                                </div>
                                            </div>
                                            
                                            <input name='__addon_price_size3' type='hidden' value='-1'>
                                        " ;
                                    break ;
                                case 3 :
                                    echo "
                                            <div class='form-group row'>
                                                <label for='input-addon-price-size1' class='col-3 col-form-label'>Addon-Item Price-Size1</label>
                                                <div class='col-9'>
                                                    <input name='__addon_price_size1' id='input-addon-price-size1' class='form-control' type='text' placeholder='40'>
                                                </div>
                                            </div>
                                             
                                            <div class='form-group row'>
                                                <label for='input-addon-price-size2' class='col-3 col-form-label'>Addon-Item Price-Size2</label>
                                                <div class='col-9'>
                                                    <input name='__addon_price_size2' id='input-addon-price-size2' class='form-control' type='text' placeholder='40'>
                                                </div>
                                            </div>
                                            
                                             <div class='form-group row'>
                                                <label for='input-addon-price-size3' class='col-3 col-form-label'>Addon-Item Price-Size3</label>
                                                <div class='col-9'>
                                                    <input name='__addon_price_size3' id='input-addon-price-size3' class='form-control' type='text' placeholder='40'>
                                                </div>
                                            </div>
                                        " ;
                                    break ;

                                default :
                                    echo "
                                        <h1> Unknown Size Variation type </h1>
                                        " ;
                                    break ;
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
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
</html>