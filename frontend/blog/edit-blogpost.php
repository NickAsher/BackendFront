<html>
<head>
    <title>SendToken | Single</title>

<!--    <link rel="stylesheet" href="../../lib/reset/reset.css" >-->

    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-reboot.min.css" >


    <link rel="stylesheet" href="../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../common/css/my_general_classes.css">
    <link rel="stylesheet" href="../common/css/default_style.css">





</head>
<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php'  ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$BlogId = isSecure_checkGetInput('__blog_id') ;

$DBConnectionBackend = YOLOSqlConnect() ;

$Query = "SELECT * FROM `blogs_table` WHERE `blog_id` = '$BlogId'  " ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
$Temp = '' ;
if($QueryResult) {
    foreach ($QueryResult as $Record) {
        $Temp = $Record;
    }
} else {
    die("Problem in getting the blogpost from blogs_table <br> ".mysqli_error($DBConnectionBackend)) ;
}




$BlogId = $Temp['blog_id'];
$BlogTitle = $Temp['blog_title'];
$BlogDisplayImage = $Temp['blog_display_image'];
$BlogContent = $Temp['blog_content'] ;



?>
<body>

<div><?php require_once "includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12">


            <div id="space_below_header">
                <br><br><br><br><br>
            </div>





            <div class="row">
                <div class = col-md-2></div>
                <div class="col-md-9" >
                    <form action="process-edit-blogpost.php" method="post" enctype="multipart/form-data">


                        <input type="hidden" name="__blog_id" value="<?php echo $BlogId ; ?>">




                        <div class="card">
                            <div class="card-block">

                                <div id="Div_BlogTitle">
                                    <label for="input-blog-title" class="col-form-label">Blog Title:</label>
                                    <div>
                                        <input name = '__new_blog_title' id="input-blog-title" class="form-control" type="text" value="<?php echo $BlogTitle; ?>" >
                                    </div>
                                    <br><br>
                                </div>





                                <div id="Div_BlogDisplayImage">
                                    <label for="presentation-only-field-display" class="col-form-label">Blog DisplayImage: </label>

                                    <div class="row">
                                        <div class="col-6">
                                            <img class="img-fluid" src='<?php echo "$IMAGE_FOLDER_LINK_PATH/$BlogDisplayImage" ; ?>' alt="<?php echo "$IMAGE_FOLDER_LINK_PATH/$BlogDisplayImage"; ?>"  />
                                        </div>
                                        <div class="col-6">
                                            <div class="row input-group">
                                                <input type="file" name="__new_blog_display_image" style="width:0;" id="hidden-file-chooser-display">
                                                <input type="text" id="presentation-only-field-display" placeholder="Choose image ..." class="form-control"  readonly>
                                                <button id="btn-file-choose-display" class="input-group-addon">Browse</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                </div>



                                <div id="Div_BlogContent">
                                    <label for="input-blog-description" class="col-form-label">Blog Content:</label>
                                    <div>
                                        <textarea name="__new_blog_content" id="input-blog-content" class="form-control"><?php echo $BlogContent; ?></textarea>
                                    </div>
                                </div>




                            </div>
                        </div>






                        <br><br>
                        <div class="form-group row">
                            <div class="col-4" ></div>
                            <input type="submit" class=" col-4 btn btn-outline-info" value="Save this Post">
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


<div><?php require_once "../common/includes/footer.php" ?></div>
</body>

<script type="text/javascript" src="../../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../lib/t3/t3.js"></script>
<script type="text/javascript" src='../../lib/tinymce/js/tinymce/tinymce.min.js'></script>


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

    handleBrowseButton("btn-file-choose-display","hidden-file-chooser-display","presentation-only-field-display") ;


    tinymce.init({
        selector: '#input-blog-content',
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



?>

</html>