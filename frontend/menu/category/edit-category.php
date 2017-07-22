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


    $CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Get, '___category_item_id') ;



    $CategoryInfoArray = getSingleCategoryInfoArray_PDO($DBConnectionBackend, $CategoryId) ;

    $CategoryId = $CategoryInfoArray['category_id'] ;
    $CategoryName = $CategoryInfoArray['category_name'] ;
    $CategoryImageCode = $CategoryInfoArray['category_image'] ;
    $CategoryActive = $CategoryInfoArray['category_is_active'] ;
    //    print_r($CategoryInfoArray) ;



    $ActiveCheckedString = null ;
    if($CategoryActive == 'yes'){
        $ActiveCheckedString = "checked='checked' ";
    } else if($CategoryActive == 'no'){
        $ActiveCheckedString = "";
    }






    ?>
</head>



<body style="background: whitesmoke;">



<?php //require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/header.php'; ?>
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
                                <h1 class="text-center">Edit Category :  <?php echo $CategoryName ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <br><br>


            <form action="process-edit-category.php" method="post">

                <div class="row">
                    <!--                    <div class = col-md-1></div>-->
                    <div class="push-md-1 col-md-10" >
                        <div class="card">
                            <div class="card-block">

                                <input name="__category_id" type="hidden" value="<?php echo $CategoryId ?>">


                                <br>
                                <div class="form-group row">
                                    <label for="input-category-name" class="col-3 col-form-label">Category Name</label>
                                    <div class="col-md-9">
                                        <input name="__category_name" id="input-category-name" class="form-control" type="text" value="<?php echo $CategoryName ; ?>" >
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="input-category-active" class="col-3 col-form-label">Category Active</label>
                                    <div class="col-md-9">
                                        <input name="__category_is_active" id="input-category-active" class="form-control" type="hidden" value="<?php echo $CategoryActive ; ?>"  >
                                        <input id="input-category-active-presentation" type="checkbox" class="form-control" <?php echo $ActiveCheckedString ?> disabled data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                    </div>
                                </div>







                                <div class="form-group row">
                                    <label  class="col-3 col-form-label">Category Image</label>
                                    <div class="col-md-9 ">
                                        <div class="form-control">
                                            <center>
                                                <div style="text-align: center;display: inline-block">
                                                    <i class="fa fa-5x fa-heart-o" ></i>
                                                    <br><br>
                                                    <input name="__category_image" class="form-control" value="<?php echo $CategoryImageCode ?>" >
                                                </div>
                                                <br><BR>

                                            </center>
                                        </div>

                                    </div>
                                </div>

                                <br>





                            </div>
                        </div>
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="push-md-1 col-md-10">
                        <div class="card">
                            <div class="card-block" style="text-align: center">
                                <br>
                                <div class="row">
                                    <button type="submit"  class="push-md-2 col-md-8 btn btn-info"  >Save Edits</button>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
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
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_toggle.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>

<script>

    function setupToggleButton(PresentationInputId, HiddenInputId){
        $('#' + PresentationInputId).on('change', function() {
            if(this.checked){
                $('#' + HiddenInputId).val('yes') ;
            } else {
                // this is necessary if user checked it and then unchecked it.
                $('#' + HiddenInputId).val('no') ;
            }
        });
    }
    setupToggleButton('input-category-active-presentation', 'input-category-active-hidden') ;





</script>


</html>



