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


<!--    <link rel="stylesheet" href="../subcommon/css/fmenu_default_style.css">-->
<!--    <link rel="stylesheet" href="../subcommon/css/menu.css">-->


    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';


    $DBConnectionBackend = YOPDOSqlConnect() ;


    $MenuItemId = isSecure_isValidPositiveInteger(GetPostConst::Get, '___menu_item_id') ;



    $MenuItemInfoArray = getSingleMenuItemInfo_EXTRAArray_PDO($DBConnectionBackend, $MenuItemId) ;


    $MenuItemName = $MenuItemInfoArray['item_name'] ;
    $MenuItemDescription = $MenuItemInfoArray['item_description'] ;
    $MenuItemImage = $MenuItemInfoArray['item_image_name'] ;
    $MenuItemCategoryCode = $MenuItemInfoArray['item_category_id'] ;
    $CategoryName = $MenuItemInfoArray['category_name'] ;
    $SubCategoryName = $MenuItemInfoArray['subcategory_display_name'] ;
    $MenuItemActive = $MenuItemInfoArray['item_is_active'] ;
//    print_r($MenuItemInfoArray) ;



    $ActiveCheckedString = null ;
    if($MenuItemActive == 'yes'){
        $ActiveCheckedString = "checked='checked' ";
    } else if($MenuItemActive == 'no'){
        $ActiveCheckedString = "";
    }






    ?>
</head>



<body style="background: whitesmoke;">



<?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/header.php'; ?>
<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">

            <div class="col-md-12">




                <div id="space_below_header">
                    <br><br><br>
                </div>



                <div class="row">
                    <div class="push-md-1 col-md-10">
                        <div class="card">
                            <div class="card-block">
                                <h1 class="text-center">Menu Item:  <?php echo $MenuItemName ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <br><br>




                <div class="row">
<!--                    <div class = col-md-1></div>-->
                    <div class="push-md-1 col-md-10" >
                        <div class="card">
                            <div class="card-block">


                        <br>
                        <div class="form-group row">
                            <label for="input-item-name" class="col-3 col-form-label">Item Name</label>
                            <div class="col-md-9">
                                <input id="input-item-name" class="form-control" type="text" value="<?php echo $MenuItemName ; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-item-description" class="col-3 col-form-label">Item Description</label>
                            <div class="col-md-9">
                                <textarea  id="input-item-description" class="form-control" rows="5" readonly ><?php echo $MenuItemDescription ; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-item-category" class="col-3 col-form-label">Item Category</label>
                            <div class="col-md-9">
                                <input id="input-item-category" class="form-control" type="text" value="<?php echo $CategoryName ; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-item-category" class="col-3 col-form-label">Item Sub-Category</label>
                            <div class="col-md-9">
                                <input id="input-item-category" class="form-control" type="text" value="<?php echo $SubCategoryName ; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-item-active" class="col-3 col-form-label">Item Active</label>
                            <div class="col-md-9">
                                <input id="input-item-active" class="form-control" type="hidden" value="<?php echo $MenuItemActive ; ?>" readonly >
                                <input id="input-item-active-presentation" type="checkbox" class="form-control" <?php echo $ActiveCheckedString ?> disabled data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                            </div>
                        </div>


                                <br><Br><Br>





                        <div id="Div_Price">
                            <?php

                            $Query = "SELECT  `a`.`size_name`,`b`.*
                                FROM `menu_meta_size_table` AS `a` INNER JOIN `menu_meta_rel_size_items_table` AS `b`
                                ON `a`.`size_id` = `b`.`size_id`  
                                WHERE `b`.`item_id` = :item_id ORDER BY `a`.`size_sr_no` ASC  " ;

                            try {
                                $QueryResult = $DBConnectionBackend->prepare($Query);
                                $QueryResult->execute([
                                    'item_id' => $MenuItemId
                                ]);
                                $AllSizesPriceList = $QueryResult->fetchAll();
                            }catch (Exception $e){
                                die("Error in getting the size price list : ".$e->getMessage()) ;
                            }

                            foreach ($AllSizesPriceList as $Record){
                                $SizeName = $Record['size_name'] ;
                                $SizeId = $Record['size_id'] ;
                                $ItemPrice = $Record['item_price'] ;
                                $IsActive = $Record['item_size_active'] ;

                                $ItemSizeActiveString = '' ;
                                if($IsActive == 'yes'){
                                    $ItemSizeActiveString =   "checked='checked' ";
                                } else if($IsActive == 'no') {
                                    $ItemSizeActiveString = '' ;
                                }

                                if($ItemPrice == '0.0' || $IsActive == 'no'){
                                   ?>
                                    <div class="form-group row">
                                        <label for="input-item-size-active_<?php echo $SizeId ?>" class="col-3 col-form-label">Item Price (<?php echo $SizeName ?>) </label>
                                        <div class="col-md-9 input-group">
                                            <input id='input-item-size-active-presentation_<?php echo $SizeId ?>' type='checkbox' class='form-control' <?php echo $ItemSizeActiveString ?> disabled data-toggle='toggle' data-width='50' data-onstyle='success' data-offstyle='danger' data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                            <input id='input-item-price-size_<?php echo $SizeId ?>' class='form-control' type='text' style='margin-left: 20px; ; ' placeholder="Empty"  readonly>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="form-group row">
                                        <label for="input-item-size-active_<?php echo $SizeId ?>" class="col-3 col-form-label">Item Price (<?php echo $SizeName ?>) </label>
                                        <div class="col-md-9 input-group">
                                            <input id='input-item-size-active-presentation_<?php echo $SizeId ?>' type='checkbox' class='form-control' <?php echo $ItemSizeActiveString ?> disabled data-toggle='toggle' data-width='50' data-onstyle='success' data-offstyle='danger' data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                            <input id='input-item-price-size_<?php echo $SizeId ?>' class='form-control' type='text' style='margin-left: 20px; ; ' value='<?php echo $ItemPrice ?>'   readonly>
                                        </div>
                                    </div>
                                    <?php
                                }

                            }







                            ?>
                        </div>





                        <div class="form-group row">
                            <label  class="col-3 col-form-label">Item Image</label>
                            <div class="col-6 ">

                                <center><img src="<?php echo "$IMAGE_BACKENDFRONT_LINK_PATH/$MenuItemImage "; ?>" class="img-fluid" width='180'></center>
                            </div>
                        </div>

                        <br><br><br>





                            </div>
                        </div>
                    </div>
<!--                    <div class="col-md-1"></div>-->
                </div>

                <br><br>

                <div class="row">
                    <div class="push-md-1 col-md-10">
                        <div class="card">
                            <div class="card-block" style="text-align: center">
                                <div class="row">
                                    <a id="btn-edit" class="push-md-2 col-md-8 btn btn-info" href="edit-menuitem.php?___menu_item_id=<?php echo $MenuItemId ; ?>"  >Edit this Item</a>
                                </div>
                            </div>
                        </div>
                    </div>
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



