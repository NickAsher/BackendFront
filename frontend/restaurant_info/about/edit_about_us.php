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

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../../common/css/classes.css">


<!--    <link rel="stylesheet" href="../../common/css/default_style.css">-->


    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;

    $DBConnectionBackend = YOPDOSqlConnect() ;


    $Query = "SELECT * FROM `info_about_table` WHERE `restaurant_id` = '1' " ;
    try{
        $QueryResult = $DBConnectionBackend->query($Query) ;
        $TempArray = $QueryResult->fetch(PDO::FETCH_ASSOC) ;

    } catch (Exception $e){
        die("Error in getting the info : ".$e->getMessage()) ;
    }





    $RestaurantId = $TempArray['restaurant_id'] ;
    $AboutUs1 = $TempArray['about_us1'] ;
    $AboutUs2 = $TempArray['about_us2'] ;
    $AboutUsImage = $TempArray['about_us_image'] ;








    ?>


</head>
<body>

<div><?php require_once "../includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12 bg-whitegrey">




                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>



                <div class="row">
                    <div class = col-md-1></div>
                    <div id="Section_AddNewItemForm" class="col-md-10" >
                    <form action="process-edit-about_us.php" method="post" enctype="multipart/form-data">



                        <div id="Div_AboutUsHeaderImage">
                            <label for="presentation-only-field-display" class="col-form-label">About Us Header Image: </label>
                            <div class="row form-control">
                                <div class="col-3">
                                    <img class="img-fluid" src='<?php echo "$IMAGE_FOLDER_LINK_PATH/$AboutUsImage" ; ?>'  />
                                </div>
                                <div class="col-3"></div>
                                <div class="col-6">
                                    <div class="row input-group">
                                        <input type="file" name="__new_about_us_image" style="width:0;" id="hidden-file-chooser-display">
                                        <input type="text" id="presentation-only-field-display" placeholder="Choose new image ..." class="form-control"  readonly>
                                        <button id="btn-file-choose-display" class="input-group-addon">Browse</button>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <br><br>
                        <div>
                            <label for="input-para1" class="col-3 col-form-label">About us Description : </label>
                            <div >
                                <textarea name="__new_about_us_description" id="input-para1" class="form-control"><?php echo $AboutUs1; ?></textarea>
                            </div>
                        </div>








                        <br><br<br><br>



                        <div class="form-group row">
                            <div class="col-4" ></div>
                            <input type="submit" class=" col-4 btn btn-info" value="Save">
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
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
<script type="text/javascript"  src='../../../lib/tinymce/js/tinymce/tinymce.min.js'></script>

<script>

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

    handleBrowseButton("btn-file-choose-display","hidden-file-chooser-display","presentation-only-field-display") ;


    tinymce.init({
        selector: '#input-para1',
        height: 500,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ]
    });
</script>


</html>