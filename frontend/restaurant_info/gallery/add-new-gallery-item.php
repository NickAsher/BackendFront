<?php

?>
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

    <link rel="stylesheet" href="../../../lib/t3/t3.css" >


    <link rel="stylesheet" href="../../common/css/my_general_classes.css">
    <link rel="stylesheet" href="../../common/css/default_style.css">



    <?php require_once '../../../utils/constants.php';


    ?>


</head>
<body>

<div><?php require_once "../includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push">
        <div class="row">
            <div class="col-md-12 bg-grey">





                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>




                <div id="Section_AddNewItemForm" class="card w-70" >
                    <div class="card-header">
                        <h3 class="ytext-heading">Add New Item Details</h3>
                    </div>
                    <div class="card-block">
                        <form action="process-add-new-gallery-item.php" method="post" enctype="multipart/form-data">



                    <div class="form-group row">
                        <label for="input-image-id" class="col-3 col-form-label">Image Id</label>
                        <div class="col-md-9">
                            <input id="input-image-id" class="form-control" type="text" placeholder="Predefault Id…" readonly>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-3 col-form-label">Image</label>
                        <div class="col-md-9 input-group">
                            <input type="file" name="__newimage_imageFile" style="width:0;" id="hidden-file-chooser">
                            <input type="text" id="presentation-only-field" class="form-control" >
                            <button id="btn-file-choose" class="input-group-addon">Browse</button>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="input-image-title" class="col-3 col-form-label">Image Title</label>
                        <div class="col-md-9">
                            <input type="text" name="__newimage_title" class="form-control" placeholder="Some Title here" id="input-image-title" >
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="input-image-description" class="col-3 col-form-label">Image Description</label>
                        <div class="col-md-9">
                            <textarea name='__newimage_description' class="form-control" rows="3" id="input-image-description" ></textarea>
                        </div>
                    </div>



                    <br><br>



                    <div class="form-group row">
                        <div class="col-4" ></div>
                        <input type="submit" class="col-4 btn btn-outline-info" value="Add">
                        <div class="col-4" ></div>
                    </div>










                </form>
                    </div>
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
<script type="text/javascript" src="../../../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript" src="../../../lib/t3/t3.js"></script>

<script >

    function handleBrowseButton(ButtonId, HiddenInputId, PresentationInputId){
        $('#'+ButtonId).click(function (event) {
            event.preventDefault() ;
            $('#'+HiddenInputId).click();

            $('#'+HiddenInputId).change(function(){
                $('#'+PresentationInputId).val($(this).val());
                return false ;
            });


        }) ;
    }

    handleBrowseButton("btn-file-choose","hidden-file-chooser","presentation-only-field") ;







</script>
</html>