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
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php'  ;
    require_once 'utils/gallery-utils.php';

    if(  !isset($_GET['___gallery_id'])  || empty($_GET['___gallery_id'])  ){
        die("Gallery Item id is empty or not set") ;
    }

    $GalleryItemId = $_GET['___gallery_id'] ;

    $DBConnectionBackend = YOLOSqlConnect() ;
    $GalleryItemInfo = getGalleryItemInfo($DBConnectionBackend, $GalleryItemId) ;
    if($GalleryItemInfo == -1){
        die("Problem in getting the Gallery item info") ;
    }

    $GalleryItem_Id = $GalleryItemInfo['gallery_item_id'] ;
    $GalleryItem_ImageName = $GalleryItemInfo['gallery_item_image_name'] ;
    $GalleryItem_Title = $GalleryItemInfo['gallery_item_title'] ;
    $GalleryItem_Description = $GalleryItemInfo['gallery_item_description'] ;

    $ImageLinkPath = "$IMAGE_FOLDER_LINK_PATH/$GalleryItem_ImageName" ;



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
                        <h3 class="ytext-heading">Gallery Item : <?php echo "$GalleryItem_Id" ?></h3>
                    </div>
                    <div class="card-block">
                        <br>
                        <form action="process-add-new-gallery-item.php" method="post" enctype="multipart/form-data">



<!--                            <div class="form-group row">-->
<!--                                <label for="input-image-id" class="col-3 col-form-label">Galley Item Id</label>-->
<!--                                <div class="col-md-9">-->
<!--                                    <input id="input-image-id" class="form-control" type="text" value='--><?php //echo "$GalleryItem_Id" ; ?><!--' readonly>-->
<!--                                </div>-->
<!--                            </div>-->



                            <div class="form-group row">
                                <label class="col-3 col-form-label">Image</label>
                                <div class="col-3"></div>
                                <div class="col-3 form-control">
                                <img src='<?php echo $ImageLinkPath ; ?>' class="img-fluid">
                                </div>
                                <div class="col-3"></div>
                            </div>

                            <br><br>


                            <div class="form-group row">
                                <label for="input-image-title" class="col-3 col-form-label">Image Title</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" type="text" value='<?php echo "$GalleryItem_Title" ; ?>' id="input-image-title" >
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="input-image-description" class="col-3 col-form-label">Image Description</label>
                                <div class="col-md-9">
                                    <textarea  class="form-control" rows="3" id="input-image-description" ><?php echo "$GalleryItem_Description" ; ?></textarea>
                                </div>
                            </div>



                            <br>

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
</html>