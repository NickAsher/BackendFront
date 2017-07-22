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
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap_toggle.css" >

    <link rel="stylesheet" href="../../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../../lib/t3/t3.css" />



    <?php

    require_once '../../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';


    $DBConnectionBackend = YOLOSqlConnect() ;

    $CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;
    $CategoryInfoArray = getSingleCategoryInfoArray($DBConnectionBackend, $CategoryId) ;

    $CategoryName = $CategoryInfoArray['category_name'] ;



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

                            <input name="__category_id"  class="form-control" type="hidden" value="<?php echo $CategoryId ; ?>" >



                            <div class="form-group row">
                                <label for="input-item-category" class="col-3 col-form-label">Category</label>
                                <div class="col-md-9">
                                    <input  id="input-item-category" class="form-control" type="text"  value="<?php echo $CategoryName ; ?>" readonly>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="input-size-name" class="col-3 col-form-label">Size Name</label>
                                <div class="col-md-9">
                                    <input name="__size_name" id="input-size-name" class="form-control" type="text"  >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-size-name_abbr" class="col-3 col-form-label">Size Name Abbreviated</label>
                                <div class="col-md-9">
                                    <input name="__size_name_abbr" id="input-size-name_abbr" class="form-control" type="text"  >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="input-size-active-hidden" class="col-3 col-form-label">Size Active</label>
                                <div class="col-md-9">
                                    <input name="__size_is_active" id="input-size-active-hidden" class="form-control" type="hidden" value="no" >
                                    <input id="input-size-active-presentation" type="checkbox" class="form-control"  data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-times'></i>" >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-3 col-form-label">Size Image</label>
                                <div class="col-md-9 input-group">
                                    <input type="file" name="__size_image" style="width:0;padding:0px;" id="hidden-file-chooser">
                                    <input type="text" id="presentation-only-field" class="form-control" >
                                    <button id="btn-file-choose" class="input-group-addon">Browse</button>
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
<script type="text/javascript"  src="../../../../lib/bootstrap4/bootstrap_toggle.js" ></script>

<script>

    $('#btn-file-choose').click(function (event) {
        event.preventDefault() ;
        $('#hidden-file-chooser').click();

        $('#hidden-file-chooser').change(function(){
            $('#presentation-only-field').val($(this).val());
            return false ;
        });


    }) ;



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
    setupToggleButton('input-size-active-presentation', 'input-size-active-hidden') ;



</script>
<script >















</script>
</html>