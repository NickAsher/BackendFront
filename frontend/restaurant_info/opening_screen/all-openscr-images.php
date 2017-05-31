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
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;


    $DBConnectionBackend = YOLOSqlConnect() ;


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






                <table  class="table table-bordered table-hover" >



                    <tr class="table-info">
                        <th>Image Id </th>
                        <th>Image </th>
                        <th>Delete</th>

                    </tr>




                    <?php


                    $Query = "SELECT * FROM `opening_screen_image_table` " ;
                    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
                    if($QueryResult){
                        foreach($QueryResult as $Record){
                            $Id = $Record['item_id'] ;
                            $Name = $Record['item_image'] ;


                            $ImageLinkPath = "$IMAGE_FOLDER_LINK_PATH/$Name" ;
                            $DetailPageLink = "show-openscr-image.php?___item_id=$Id" ;

                            echo "

                            <tr>
                                <td class='addon-link' data-href='$DetailPageLink'> $Id </td>
                                <td class='addon-link' data-href='$DetailPageLink'>
                                    <img src='$ImageLinkPath' width='90px' class='img-fluid' >
                                </td>
                                <td>
                                    <form method='post' action='confirm-delete-openscr-image.php'>
                                        <input type='hidden' name='__item_id' value='$Id'>
                                        <button type='submit' class='btn btn-danger'>
                                            <i class='fa fa-trash'> &nbsp; | &nbsp; </i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                             " ;



                        }
                    } else {
                        echo "Problem in fetching the Records from gallery table <br>".mysqli_error($DBConnectionBackend) ;
                    }




                    ?>
                </table>






                <br><br>



                <div class="row">
                    <div class="col-4"></div>
                    <a class="col-4 btn btn-outline-info" href="add-new-openscr-image.php">
                        Add New Image
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
