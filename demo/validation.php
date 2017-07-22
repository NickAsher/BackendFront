<?php

?>
<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-16">
    <link rel="stylesheet" href="../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap_addon.css" >

    <link rel="stylesheet" href="../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../lib/t3/t3.css" />





    <?php

    require_once '../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;



    $DBConnectionBackend = YOLOSqlConnect() ;



    ?>


</head>
<body>

<!--<div>--><?php //require_once "../subcommon/includes/header.php" ?><!--</div>-->

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
                        <form id="yoloform"  method="post" enctype="multipart/form-data">



                            <div class="form-group row">
                                <label for="__item_category" class="col-3 col-form-label ">Category</label>
                                <div class="col-md-9">
                                    <input name="__item_category" id="__item_category" class="form-control validate-isrequired" type="text"  >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="__item_subcategory" class="col-3 col-form-label">Item Category</label>
                                <div class="col-md-9">
                                    <select name = "__item_subcategory" class="form-control" id="__item_subcategory" >
                                        <option selected disabled>Choose an Item SubCategory</option>
                                        <option value='pizza'>Pizza</option>
                                        <option value='burger'>Burger</option>

                                    </select>
                                </div>
                            </div>





                            <div class="form-group row">
                                <label for="__item_name" class="col-3 col-form-label">Item Name</label>
                                <div class="col-md-9">
                                    <input name="__item_name" class="form-control" type="text" id="__item_name" >
                                </div>
                            </div>


                            <div class='form-group row'>
                                <label for='__item_price_size' class='col-3 col-form-label'>Item Price ($SizeName)</label>
                                <div class='col-md-9'>
                                    <input name='__item_price_size' id='__item_price_size' class='form-control' type='text' >
                                </div>
                            </div>


                            <div class='form-group row'>
                                <label for='__item_email' class='col-3 col-form-label'>Email </label>
                                <div class='col-md-9'>
                                    <input name='__item_email' id='__item_email' class='form-control' type='text' >
                                </div>
                            </div>

                            <div class='form-group row'>
                                <label for='__item_active' class='col-3 col-form-label'>Is Active </label>
                                <div class='col-md-9'>
                                    <input name='__item_active' id='__item_active' class='form-control' type='text' >
                                </div>
                            </div>






                            <div class="form-group row">
                                <label for="__item_description" class="col-3 col-form-label">Item Description</label>
                                <div class="col-md-9">
                                    <textarea name='__item_description' class="form-control" rows="3" id="__item_description" ></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-3 col-form-label">Item Image</label>
                                <div class="col-md-9 input-group">
                                    <input type="file" name="__item_image" style="width:0;" id="hidden-file-chooser">
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
<script type="text/javascript"  src="../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../lib/t3/t3.js"></script>
<script type="text/javascript"  src="../lib/validate/jquery.validate.js"></script>
<script type="text/javascript"  src="../lib/validate/jquery-validate-addon.js"></script>


<script >

    $('#btn-file-choose').click(function (event) {
        event.preventDefault() ;
        $('#hidden-file-chooser').click();

        $('#hidden-file-chooser').change(function(){
            $('#presentation-only-field').val($(this).val());
            return false ;
        });


    }) ;

//    $.validator.setDefaults({
//        highlight: function(element) {
//            $(element).closest('.form-group').addClass('has-error');
//        },
//        unhighlight: function(element) {
//            $(element).closest('.form-group').removeClass('has-error');
//        },
//        errorElement: 'span',
//        errorClass: 'help-block',
//        errorPlacement: function(error, element) {
//            if(element.parent('.input-group').length) {
//                error.insertAfter(element.parent());
//            } else {
//                error.insertAfter(element);
//            }
//        }
//    });


    $("#yoloform").validate({

        rules: {
            __item_category:{
                required: true
            },
            __item_name: {
                required: true
            },
            __item_price_size: {
                required: true,
                number: true,
                isSecure_IsValidPositiveDecimal: true
            },
            __item_active :{
                required:true,
                isSecure_ValidYesNo:true,
            },
            __item_email: {
                required: true,
                email: true
            },

            __item_description: {
                required: true
            }
        },
        messages: {
            __item_category:{
                required: "Please enter a Category for the product",
            },
            __item_name: {
                required: "Please enter a Name for the product",
            },
            __item_price_size: {
                required: "Please provide a price",
                number: "Your Price must be a numer",
            },
            __item_email:{
                required: "Email address cannot be left empty",
                email: "Please enter a valid email address"
            },
            __item_description:{
                required: "Please enter a Description for the product",
            }
        },
        // this piece of code, allows us to execute any of the validation of an element on the "onfocusout" event
        onfocusout: function(element) {
                this.element(element);
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success');
            $(element).removeClass('form-control-success');

            $(element).closest('.form-group').addClass('has-danger');
            $(element).addClass('form-control-danger');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-danger');
            $(element).removeClass('form-control-danger');

            $(element).closest('.form-group').addClass('has-success');
            $(element).addClass('form-control-success');

        },
//        errorElement: 'span',
        errorClass: 'form-control-feedback'
//        errorPlacement: function(error, element) {
//            if(element.parent('.input-group').length) {
//                error.insertAfter(element.parent());
//            } else {
//                error.insertAfter(element);
//            }
//        }
    });


















</script>
</html>