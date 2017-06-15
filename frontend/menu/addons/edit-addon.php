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

    <link rel="stylesheet" href="../subcommon/css/fmenu_default_style.css">
    <link rel="stylesheet" href="../subcommon/css/menu.css">



    <?php

    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';

    $CategoryCode = isSecure_checkGetInput('___category_code') ;
    $AddonItemId = isSecure_checkGetInput('___addon_item_id') ;

    
    $DBConnectionBackend = YOLOSqlConnect() ;
    $AddonItemInfoArray = getAddonItemInfoArray($DBConnectionBackend, $CategoryCode, $AddonItemId) ;
    
    $AddonItemName = $AddonItemInfoArray['item_name'] ;
    $AddonItemIsActive = $AddonItemInfoArray['item_is_active'] ;

    $ActiveCheckedString = null ;
    if($AddonItemIsActive == 'true'){
        $ActiveCheckedString = "checked='checked' ";
    } else if($AddonItemIsActive == 'false'){
        $ActiveCheckedString = "";
    }

    //    $NoOfSizeVariations = intval($AddonItemInfoArray['item_no_of_size_variations']) ;



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
                                <label for ='input-item-name' class="col-3 col-form-label">Addon-Item Name</label>
                                <div class="col-md-9">
                                    <input name="__addon_item_name" id="input-item-name" class="form-control" type="text" value="<?php echo $AddonItemName ; ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for='input-item-active-hidden' class="col-3 col-form-label">Addon-Item Active</label>
                                <div class="col-md-9">
                                    <input name="__addon_is_active" id="input-item-active-hidden" class="form-control" type="hidden" value="<?php echo $AddonItemIsActive ; ?>" >
                                    <input id="input-item-active-presentation" type="checkbox" class="form-control" <?php echo $ActiveCheckedString ?> data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
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
                                            <div class='col-md-9'>
                                                <input name='__addon_price_size_$SizeCode'  id='input-addon-price-size_$SizeCode' class='form-control' type='text' value='$ItemPrice' >
                                            </div>
                                        </div>  
                                        " ;


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
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_toggle.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>

<script type="text/javascript">


    function setupToggleButton(PresentationInputId, HiddenInputId){
        $('#' + PresentationInputId).on('change', function() {
            if(this.checked){
                $('#' + HiddenInputId).val('true') ;
            } else {
                // this is necessary if user checked it and then unchecked it.
                $('#' + HiddenInputId).val('false') ;
            }
        });
    }


    setupToggleButton('input-item-active-presentation', 'input-item-active-hidden') ;
</script>

</html>