<?php

?>
<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-16">
    <link rel="stylesheet" href="../../../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap_addon.css" >

    <link rel="stylesheet" href="../../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../../lib/t3/t3.css" />



    <?php

    require_once '../../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';


    $DBConnectionBackend = YOLOSqlConnect() ;

    $CategoryCode = isSecure_checkPostInput('__category_code') ;
    $CategoryInfoArray = getSingleCategoryInfoArray($DBConnectionBackend, $CategoryCode) ;

    $CategoryName = $CategoryInfoArray['category_display_name'] ;



    ?>


</head>
<body>

<div><?php require_once "../../subcommon/includes/header.php" ?></div>

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
                        <form action="process-add-size.php" method="post" enctype="multipart/form-data">

                            <input name="__category_code"  class="form-control" type="hidden" value="<?php echo $CategoryCode ; ?>" >



                            <div class="form-group row">
                                <label for="input-item-category" class="col-3 col-form-label">Category</label>
                                <div class="col-9">
                                    <input  id="input-item-category" class="form-control" type="text"  value="<?php echo $CategoryName ; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-size-code" class="col-3 col-form-label">Size Code</label>
                                <div class="col-9">
                                    <input name="__size_code" id="input-size-code" class="form-control" type="text"  >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-size-name" class="col-3 col-form-label">Size Name</label>
                                <div class="col-9">
                                    <input name="__size_name" id="input-size-name" class="form-control" type="text"  >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-size-name_abbr" class="col-3 col-form-label">Size Name Abbreviated</label>
                                <div class="col-9">
                                    <input name="__size_name_abbr" id="input-size-name_abbr" class="form-control" type="text"  >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-size-sr_no" class="col-3 col-form-label">Size Sr No</label>
                                <div class="col-9">
                                    <input name="__size_sr_no" id="input-size-sr_no" class="form-control" type="number"  >
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



<!--<div>--><?php //require_once "../common/includes/footer.php" ?><!--</div>-->


</body>
<script type="text/javascript"  src="../../../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../../../lib/t3/t3.js"></script>
<script >















</script>
</html>