<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="../../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap_addon.css" >

    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" >


    <link rel="stylesheet" href="../../common/css/my_general_classes.css">
    <link rel="stylesheet" href="../../common/css/default_style.css">






    <?php
    require_once '../../../utils/constants.php';

    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once 'utils/gallery-utils.php' ;


    $DBConnectionBackend = YOPDOSqlConnect() ;


    ?>



</head>



<body>

<?php require_once "../includes/header.php" ?>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push">
        <div class="row">

            <div class="col-md-12 bg-white">

                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>




                <a href="sort-gallery-item.php" style="float: right" class="btn btn-primary">Change Order</a>


                <table  class="table table-bordered table-hover" >



                    <tr class="table-info">
                        <th>Sr No </th>
                        <th>Item </th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Delete</th>

                    </tr>




                    <?php

                    try{
                        $ListOfAllGalleryItems = getListOfAllGalleryItems($DBConnectionBackend) ;
                        foreach($ListOfAllGalleryItems as $Record){
                            $SrNo = $Record['gallery_item_sr_no'] ;
                            $Id = $Record['gallery_item_id'] ;
                            $Name = $Record['gallery_item_image_name'] ;
                            $Title = $Record['gallery_item_title'] ;
                            $Description = $Record['gallery_item_description'] ;
                            $ImageLinkPath = "$IMAGE_FOLDER_LINK_PATH/$Name" ;

                            $DetailPageLink = "show-gallery-item.php?___gallery_id=$Id" ;


                            echo "
                                <tr>
                                    <td class='td-link' data-href='$DetailPageLink'>$SrNo</td>
                                    <td class='td-link' data-href='$DetailPageLink'><img src='$ImageLinkPath' width='90px' class='img-fluid' ></td>
                                    <td class='td-link' data-href='$DetailPageLink'> $Title </td>
                                    <td class='td-link' data-href='$DetailPageLink'> $Description</td>
                                    <td>
                                        <form method='post' action='confirm-delete-gallery-item.php'>
                                            <input type='hidden' name='__gallery_id' value='$Id'>
                                            <input type='submit' class='btn btn-danger' value='Delete'>
                                        </form>
                                    </td>
                                </tr>
                            " ;
                        }
                    } catch (Exception $e){
                        die("Problem in fetching the Records from gallery table <br>".$e->getMessage() );
                    }




                    ?>
                </table>






                <br><br>



                <div class="row">
                    <div class="col-4"></div>
                    <a class="col-4 btn btn-outline-info" href="add-new-gallery-item.php">
                        Add New Item
                    </a>
                    <div class="col-4"></div>
                </div>







                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>





            </div>
        </div>
    </div>
</section>



<?php require_once "../../common/includes/footer.php" ?>



</body>
<script type="text/javascript" src="../../../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../../lib/bootstrap4/bootstrap_addon.js" ></script>

<script type="text/javascript" src="../../../lib/t3/t3.js"></script>




</html>
