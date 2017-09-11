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

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />
    
    <link rel="stylesheet" href="../subcommon/css/fmenu_default_style.css">
    <link rel="stylesheet" href="../subcommon/css/menu.css">



    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php';

    $DBConnectionBackend = YOPDOSqlConnect() ;

    $ListOfAllCategories = getListOfAllCategories_Array_PDO($DBConnectionBackend) ;


    ?>



</head>



<body>
<?php require_once "../subcommon/includes/header.php" ?>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12 bg-white">

                <div id="space_below_header">
                    <br><br><br>
                </div>



                <div class="row">
                    <div class="push-md-1 col-md-10">
                        <div class="card">
                            <div class="card-block">
                                <h1 class="text-center">All Categories </h1>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <br><br>

                    <div id="NavTabsPanel" class="row" >
                        <div class="push-md-1 col-md-10" >

                            <div class="card" >
                                <div class="card-block">


                                    <div style='display: block'>
                                        <h1 style='display: inline-block; float: left;' >$SubCategoryName</h1>
                                        <form action='sort-category.php' method='post'>
                                            <input type='submit' class='btn btn -info' style='display: inline-block;float: right' value='Sort This'>
                                        </form>
                                        <br><br>
                                    </div>

                                    <table  class='table table-bordered table-hover' >

                                        <tr class='table-info'>
                                            <th>Sr No</th>
                                            <th>Item Image</th>
                                            <th>Item Name</th>
                                            <th>Item Active</th>
                                            <th> Action</th>

                                        </tr>

                                    <?php
                                    foreach ($ListOfAllCategories as $Record){
                                        $SrNo = $Record['category_sr_no'] ;
                                        $CategoryId = $Record['category_id'] ;
                                        $CategoryName = $Record['category_name'] ;
                                        $CategoryImage = $Record['category_image'] ;
                                        $CategoryActive = $Record['category_is_active'] ;



                                        $ActiveButton = '' ;
                                        if($CategoryActive == 'yes'){
                                            $ActiveButton = "<div class='btn btn-success' disabled><i class='fa fa-check'></i></div>" ;
                                        } else if($CategoryActive == 'no'){
                                            $ActiveButton = "<div class='btn btn-danger' disabled><i class='fa fa-times'></i></div>" ;
                                        }

                                        $DetailPageLink = "show-category.php?___category_item_id=$CategoryId" ;

                                        echo "
                <tr >
                    <td class='addon-link' data-href='$DetailPageLink'>$SrNo</td>
                    <td class='addon-link' data-href='$DetailPageLink'><img src='$IMAGE_BACKENDFRONT_LINK_PATH/$CategoryImage' class='img-fluid' width = '80px' ></td>
                    <td class='addon-link' data-href='$DetailPageLink'><p class='link-black'>$CategoryName</p></td>
                    <td class='addon-link' data-href='$DetailPageLink'>$ActiveButton</td>
                    <td>
                        <div style='display: inline-block'>
                        <form method='get' action='edit-category.php'>
                            <input type='hidden' name='___category_id' value='$CategoryId'>
                            <button type='submit' class='btn btn-info'><i class='fa  fa-edit' ></i></button>
                        </form>
                        </div>
                        &nbsp; &nbsp; 
                        <div style='display: inline-block'>
                        <form method='post' action='confirm-delete-category.php'>
                            <input type='hidden' name='__category_id' value='$CategoryId'>
                            <button type='submit' class='btn btn-danger'><i class='fa fa-trash'></i></button>
                        </form>
                        </div>
                        
                        
                    </td>                                
                                        
                </tr>
                ";
                                    }
                                    ?>
                                    </table>




                                </div>
                            </div>
                        </div>
                    </div>





                
                
















                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>




            </div>
        </div>
    </div>
</section>



<!--<div>--><?php //require_once "../../common/includes/footer.php" ?><!--</div>-->


</body>
<script type="text/javascript"  src="../../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
</html>
