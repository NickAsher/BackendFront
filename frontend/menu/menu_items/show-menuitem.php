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
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';


    $DBConnectionBackend = YOLOSqlConnect() ;


    $MenuItemId = isSecure_checkGetInput('___menu_item_id') ;
    $MenuItemInfoArray = getSingleMenuItemInfoView_Array($DBConnectionBackend, $MenuItemId) ;


    $MenuItemName = $MenuItemInfoArray['item_name'] ;
    $MenuItemDescription = $MenuItemInfoArray['item_description'] ;
    $MenuItemImage = $MenuItemInfoArray['item_image_name'] ;
    $MenuItemCategoryCode = $MenuItemInfoArray['item_category_code'] ;
    $MenuItemSubCategoryCode = $MenuItemInfoArray['item_subcategory_code'] ;
    $CategoryName = $MenuItemInfoArray['category_display_name'] ;
    $SubCategoryName = $MenuItemInfoArray['subcategory_display_name'] ;

    $NoOfSizeVariations = $MenuItemInfoArray['category_no_of_size_variations'] ;






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
                    <div class = col-md-1></div>
                    <div class="col-md-10" >



                        <div class="form-group row">
                            <label for="input-item-name" class="col-3 col-form-label">Item Name</label>
                            <div class="col-9">
                                <input id="input-item-name" class="form-control" type="text" value="<?php echo $MenuItemName ; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-item-description" class="col-3 col-form-label">Item Description</label>
                            <div class="col-9">
                                <textarea  id="input-item-description" class="form-control" rows="5" readonly ><?php echo $MenuItemDescription ; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-item-category" class="col-3 col-form-label">Item Category</label>
                            <div class="col-9">
                                <input id="input-item-category" class="form-control" type="text" value="<?php echo $CategoryName ; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input-item-category" class="col-3 col-form-label">Item Sub-Category</label>
                            <div class="col-9">
                                <input id="input-item-category" class="form-control" type="text" value="<?php echo $SubCategoryName ; ?>" readonly>
                            </div>
                        </div>





                        <div id="Div_Price">
                            <?php

                            $Query = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_code` = '$MenuItemCategoryCode' " ;
                            $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
                            if(!$QueryResult){
                                die("Unable to get the sizes for the item: ".mysqli_error($DBConnectionBackend)) ;
                            }

                            foreach ($QueryResult as $Record) {
                                $SizeName = $Record['size_name'] ;
                                $SizeCode = $Record['size_code'] ;

                                $Query2 = "SELECT * FROM `menu_meta_rel_size-items_table` WHERE `item_id` = '$MenuItemId' AND `size_code` = '$SizeCode'  " ;
                                $QueryResult2 = mysqli_query($DBConnectionBackend, $Query2) ;
                                if(!$QueryResult2) {
                                    die("Unable to fetch the record for the item for size $SizeCode :".mysqli_error($DBConnectionBackend) ) ;
                                }
                                $Record2 = mysqli_fetch_assoc($QueryResult2) ;
                                $ItemPrice = $Record2['item_price'] ;

                                echo "
                                        <div class='form-group row'>
                                            <label for='input-item-price-size_$SizeCode' class='col-3 col-form-label'>Item Price ($SizeName)</label>
                                            <div class='col-9'>
                                                <input id='input-item-price-size_$SizeCode' class='form-control' type='text' value='$ItemPrice' readonly>
                                            </div>
                                        </div>  
                                        " ;


                            }

                            ?>
                        </div>





                        <div class="form-group row">
                            <label  class="col-3 col-form-label">Item Image</label>
                            <div class="col-6">
                                <center><img src="<?php echo "$IMAGE_BACKENDFRONT_LINK_PATH/$MenuItemImage "; ?>" class="img-fluid" width='180'></center>
                            </div>
                        </div>

                        <br><br><br>

                        <div class="row">
                            <div class="col-4" ></div>
                            <a id="btn-edit" class="col-4 btn btn-info" href="edit-menuitem.php?___menu_item_id=<?php echo $MenuItemId ; ?>"  >Edit this Item</a>
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



