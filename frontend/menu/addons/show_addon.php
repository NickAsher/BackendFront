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

    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';

    $CategoryCode = isSecure_IsValidItemCode(GetPostConst::Get, '___category_code') ;
    $AddonItemId = isSecure_isValidPositiveInteger(GetPostConst::Get, '___addon_item_id') ;

    $DBConnectionBackend = YOPDOSqlConnect() ;

    $CategoryInfoArray = getSingleCategoryInfoArray_PDO($DBConnectionBackend, $CategoryCode) ;
    $AddonItemDetailInfoArray = getSingleAddonItemInfoArray_PDO($DBConnectionBackend, $AddonItemId) ;


    $AddonItemId = $AddonItemDetailInfoArray['item_id'] ;
    $AddonItemName = $AddonItemDetailInfoArray['item_name'] ;
    $AddonItemIsActive = $AddonItemDetailInfoArray['item_is_active'] ;

    $ActiveCheckedString = null ;
    if($AddonItemIsActive == 'yes'){
        $ActiveCheckedString = "checked='checked' ";
    } else if($AddonItemIsActive == 'no'){
        $ActiveCheckedString = "";
    }






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




                        <div class="form-group row">
                            <label class="col-3 col-form-label">Addon-Item Name</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" value="<?php echo $AddonItemName ; ?>" readonly>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for='input-item-active-hidden' class="col-3 col-form-label">Addon-Item Active</label>
                            <div class="col-md-9">
                                <input id="input-item-active-hidden" class="form-control" type="hidden" value="<?php echo $AddonItemIsActive ; ?>" readonly >
                                <input id="input-item-active-presentation" type="checkbox" class="form-control" <?php echo $ActiveCheckedString ?> disabled data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                            </div>
                        </div>




                        <div id="Div_Price">
                            <?php

                            $ListOfAllSizes = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $CategoryCode) ;

                            foreach ($ListOfAllSizes as $Record) {
                                $SizeName = $Record['size_name'];
                                $SizeId = $Record['size_id'];


                                $AddonSizePriceInfo = getSingleAddonItemPriceInfoArray_PDO($DBConnectionBackend, $AddonItemId, $SizeId);

                                    $ItemPrice = $AddonSizePriceInfo['addon_price'];

                                    echo "
                                            <div class='form-group row'>
                                                <label for='input-addon-price-size_$SizeId' class='col-3 col-form-label'>Addon Price ($SizeName)</label>
                                                <div class='col-md-9'>
                                                    <input id='input-addon-price-size_$SizeId' class='form-control' type='text' value='$ItemPrice' readonly>
                                                </div>
                                            </div>  
                                            ";




                            }

                            ?>
                        </div>




                        <br><br><br>

                        <div class="row">
                            <div class="col-4" ></div>
                            <a id="btn-edit" class="col-4 btn btn-info" href="edit-addon.php?<?php echo "___addon_item_id=$AddonItemId&___category_code=$CategoryCode" ; ?>"  >Edit this Item</a>
                            <div class="col-4" ></div>
                        </div>

                        
                        

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
</html>



