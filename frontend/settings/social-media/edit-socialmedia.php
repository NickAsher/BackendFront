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

    <link rel="stylesheet" href="../../../lib/toastr/toastr.min.css">

    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />


    <link rel="stylesheet" href="../../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../../common/css/classes.css">




    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;

    $DBConnectionBackend = YOPDOSqlConnect() ;



    $Query = "SELECT * FROM `info_social_media_table`  " ;
    try{
        $QueryResult = $DBConnectionBackend->query($Query) ;
        $TempArray = $QueryResult->fetchAll() ;
    }catch (Exception $e){
        throw new Exception("Error in getting the contact information: ".$e->getMessage()) ;
    }















    ?>


</head>
<body>

<?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/header.php'; ?>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12 " style="background-color: #eee">




                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>



                <div class="row">
                    <div class = col-md-2></div>
                    <div id="Section_AddNewItemForm" class="col-md-9" >

                        <form action="process-edit-socialmedia.php" method="post">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="ytext-heading">Social Media Links</h3>
                            </div>
                            <div class="card-block">

                                <?php
                                foreach ($TempArray as $Record){
                                    $SocialMedia_Id = $Record['socialmedia_id'] ;
                                    $SocialMedia_Name = $Record['socialmedia_name'] ;
                                    $SocialMedia_Link = $Record['socialmedia_link'] ;



                                    echo "
                                        <div class='form-group row'>
                                            <label for='input-social-media-$SocialMedia_Id' class='col-3 col-form-label'>".$SocialMedia_Name."</label>
                                            <div class='col-md-9'>
                                                <input name='__socialmedia_$SocialMedia_Id' id='input-social-media-$SocialMedia_Id' class='form-control' type='text'  value='$SocialMedia_Link' >
                                            </div>
                                        </div>
                                    " ;

                                }
                                ?>




                            </div>
                        </div>

                        <br><br>











                            <div class="form-group row">
                                <div class="col-4" ></div>
                                <input type="submit" class=" col-4 btn btn-outline-info" value="Save">
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
<script type="text/javascript" src="../../../lib/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../../lib/toastr/toastr.min.js" ></script>

<script type="text/javascript" src="../../../lib/t3/t3.js"></script>





</html>