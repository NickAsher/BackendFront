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

    <link rel="stylesheet" href="../subcommon/css/fmenu_default_style.css">
    <link rel="stylesheet" href="../subcommon/css/menu.css">



    <?php

    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once '../utils/menu-utils.php';

    
    $CategoryCode = isSecure_checkGetInput('___category_code') ;
    $AddonItemId = isSecure_checkGetInput('___addon_item_id') ;

    
    $DBConnectionBackend = YOLOSqlConnect() ;


    $SingleCategoryInfoArray = getSingleCategoryInfoArray($DBConnectionBackend, $CategoryCode) ;
    $AddonItemInfoArray = getAddonItemInfoArray($DBConnectionBackend, $CategoryCode, $AddonItemId) ;
    
    $NoOfSizeVariations = intval($SingleCategoryInfoArray['category_no_of_size_variations']) ;
    $AddonItemName = $AddonItemInfoArray['item_name'] ;
    $AddonPriceSize1 = $AddonItemInfoArray['item_price_size1'] ;
    $AddonPriceSize2 = $AddonItemInfoArray['item_price_size2'] ;
    $AddonPriceSize3 = $AddonItemInfoArray['item_price_size3'] ;

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


                            <input name='__category_code'  type='hidden' value="<?php echo $CategoryCode ; ?>">
                            <input name='__addon_item_id'  type='hidden' value="<?php echo $AddonItemId ; ?>">



                            <div class="form-group row">
                                <label class="col-3 col-form-label">Addon-Item Name</label>
                                <div class="col-9">
                                    <input name="__addon_item_name" id="input-item-name" class="form-control" type="text" value="<?php echo $AddonItemName ; ?>" >
                                </div>
                            </div>



                            <div>

                                <?php

                                switch ($NoOfSizeVariations){
                                    case 1:
                                        echo "
                                    <div class='form-group row'>
                                        <label for='input-addon-price-size1' class='col-3 col-form-label'>Addon-Item Price</label>
                                        <div class='col-9'>
                                            <input name='__addon_price_size1' id='input-addon-price-size1' class='form-control' type='text' value='$AddonPriceSize1'>
                                        </div>
                                    </div>
                                            <input name='__addon_price_size2'  type='hidden' value='$AddonPriceSize2'>
                                            <input name='__addon_price_size3'  type='hidden' value='$AddonPriceSize3'>

                                " ;
                                        break ;


                                    case 2:
                                        echo "
                                
                                    <div class='form-group row'>
                                        <label for='input-addon-price-size1' class='col-3 col-form-label'>Addon-Item Price(Size1)</label>
                                        <div class='col-9'>
                                            <input name='__addon_price_size1' id='input-addon-price-size1' class='form-control' type='text' value='$AddonPriceSize1'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='input-addon-price-size2' class='col-3 col-form-label'>Addon-Item Price(Size2)</label>
                                        <div class='col-9'>
                                            <input name='__addon_price_size2' id='input-addon-price-size2' class='form-control' type='text' value='$AddonPriceSize2'>
                                        </div>
                                    </div>
                                    
                                    <input name='__addon_price_size3'  type='hidden' value='$AddonPriceSize3'>
                                
                                " ;
                                        break ;


                                    case 3 :
                                        echo "
                                    <div class='form-group row'>
                                        <label for='input-addon-price-size1' class='col-3 col-form-label'>Addon-Item Price(Size1)</label>
                                        <div class='col-9'>
                                            <input name='__addon_price_size1' id='input-addon-price-size1' class='form-control' type='text' value='$AddonPriceSize1'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='input-addon-price-size2' class='col-3 col-form-label'>Addon-Item Price(Size2)</label>
                                        <div class='col-9'>
                                            <input name='__addon_price_size2' id='input-addon-price-size2' class='form-control' type='text' value='$AddonPriceSize2'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label for='input-addon-price-size3' class='col-3 col-form-label'>Addon-Item Price(Siz3)</label>
                                        <div class='col-9'>
                                            <input name='__addon_price_size3' id='input-addon-price-size3' class='form-control' type='text' value='$AddonPriceSize3'>
                                        </div>
                                    </div>
                                " ;

                                        break ;
                                    default :
                                        echo "<h1>Unknown Size variation</h1>" ;
                                        break ;

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
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>


</html>