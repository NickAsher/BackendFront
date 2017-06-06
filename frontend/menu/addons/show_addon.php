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
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';

    $CategoryCode = isSecure_checkGetInput('___category_code') ;
    $AddonItemId = isSecure_checkGetInput('___addon_item_id') ;

    $DBConnectionBackend = YOLOSqlConnect() ;

    $CategoryInfoArray = getSingleCategoryInfoArray($DBConnectionBackend, $CategoryCode) ;
    $AddonItemDetailInfoArray = getAddonItemInfoArray($DBConnectionBackend, $CategoryCode, $AddonItemId) ;


    $AddonItemId = $AddonItemDetailInfoArray['item_id'] ;
    $AddonItemName = $AddonItemDetailInfoArray['item_name'] ;
    $NoOfSizeVariations = intval($AddonItemDetailInfoArray['item_no_of_size_variations']) ;






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
                            <div class="col-9">
                                <input class="form-control" type="text" value="<?php echo $AddonItemName ; ?>" readonly>
                            </div>
                        </div>




                        <div id="Div_Price">
                            <?php

                            $Query = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_code` = '$CategoryCode' " ;
                            $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
                            if(!$QueryResult){
                                die("Unable to get the sizes for the item: ".mysqli_error($DBConnectionBackend)) ;
                            }

                            foreach ($QueryResult as $Record) {
                                $SizeName = $Record['size_name'] ;
                                $SizeCode = $Record['size_code'] ;

                                $Query2 = "SELECT * FROM `menu_meta_rel_size-addons_table` WHERE `addon_id` = '$AddonItemId' AND `size_code` = '$SizeCode'  " ;
                                $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
                                if(!$QueryResult2) {
                                    die("Unable to fetch the record for the item for size $SizeCode :".mysqli_error($DBConnectionBackend) ) ;
                                }
                                $Record2 = mysqli_fetch_assoc($QueryResult2) ;
                                $ItemPrice = $Record2['addon_price'] ;

                                echo "
                                        <div class='form-group row'>
                                            <label for='input-addon-price-size_$SizeCode' class='col-3 col-form-label'>Addon Price ($SizeName)</label>
                                            <div class='col-9'>
                                                <input id='input-addon-price-size_$SizeCode' class='form-control' type='text' value='$ItemPrice' readonly>
                                            </div>
                                        </div>  
                                        " ;


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
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
</html>



