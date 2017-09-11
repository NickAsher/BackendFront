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
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php'  ;
require_once 'utils/utils-blogpost.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;

$DBConnectionBackend = YOPDOSqlConnect() ;




$BlogId = isSecure_isValidPositiveInteger(GetPostConst::Get, '___blog_id') ;


$Temp = getBlogInfo($DBConnectionBackend, $BlogId) ;


$BlogId = $Temp['blog_id'];
$CreationTimeStamp = $Temp['blog_creation_date'] ;
$BlogTitle = $Temp['blog_title'];
$BlogDisplayImage = $Temp['blog_display_image'];
$BlogContent = $Temp['blog_content'] ;




$SomeVar = "<p>This is some <strong>bold for you</strong> and some <em>Italics too</em> for you babe.. Perhaps you would like some list</p>
<ul>
    <li>This is one</li>
    <li>This is two</li>
</ul>
<p>This is again normal text</p>" ;












?>
<body>

<div><?php require_once "includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12 bg-white" >


                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>





                <div class="row">
                    <div class = col-md-1></div>
                    <div class="col-md-10" >




                        <div id="Div_BlogDate">
                            <label for="input-blog-date" class="col-form-label">Creation Date:</label>
                            <div>
                                <input id="input-blog-date" class="form-control" type="text" value="<?php echo $CreationTimeStamp; ?>" readonly >
                            </div>
                        </div>


                        <br><br>
                        <div id="Div_BlogTitle">
                            <label for="input-blog-title" class="col-form-label">Blog Title:</label>
                            <div>
                                <input id="input-blog-title" class="form-control" type="text" value="<?php echo $BlogTitle; ?>" readonly >
                            </div>
                            <br><br>
                        </div>


                        <div id="Div_BlogDisplayImage">
                            <label for="presentation-only-field-display" class="col-form-label">Blog DisplayImage:</label>
                            <div class="row">
                                <div class="col-6">
                                    <img src='<?php echo "$IMAGE_FOLDER_LINK_PATH/$BlogDisplayImage" ; ?>' alt='<?php echo "$IMAGE_FOLDER_LINK_PATH/$BlogDisplayImage"; ?>' class="img-fluid form-control" width="100px" />
                                </div>
                            </div>
                            <br><br>
                        </div>

                        <br>

                        <div id="Div_BlogContent">
                            <label for="input-blog-description" class="col-form-label">Blog Content:</label>
                            <div>
                                <div class="form-control bg-faded"><?php echo $BlogContent; ?></div>
                            </div>
                        </div>





                        <br><br><br>
                        <div class="form-group row">
                            <div class="col-4" ></div>
                            <a href='<?php echo "edit-blogpost.php?__blog_id=$BlogId" ?>' class='col-4 btn btn-outline-info' >Edit this BlogPost</a>
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


<div><?php require_once "../common/includes/footer.php" ?></div>
</body>

<script type="text/javascript" src="../../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../lib/t3/t3.js"></script>

<script >









</script>

</html>