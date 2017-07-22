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
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils-pdo.php';

    $DBConnectionBackend = YOPDOSqlConnect() ;





    ?>



</head>



<body style="background: whitesmoke;">
<?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/header.php'; ?>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12">


                <div id="space_below_Header">
                    <br><br><br>
                </div>


                <div id="Heading" class="row">
                    <div class="push-md-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h1 class="text-center">Sync Changes</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <br><br>



                <div class="row">
                    <div class="push-md-3 col-md-6" >
                        <div class="card">
                            <div class="card-block">
                                <br>
                                <table  class='table  table-hover table-sm' >



                                <tr>
                                    <td>About Us</td>
                                    <td>
                                        <button id="AboutUsSyncButton" class="btn btn-info" >Sync</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Blog</td>
                                    <td>
                                        <button id="BlogSyncButton" class="btn btn-info" >Sync</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Contact</td>
                                    <td>
                                        <button id="ContactSyncButton" class="btn btn-info" >Sync</button>
                                    </td>
                                </tr>


                                <tr>
                                    <td>Gallery</td>
                                    <td>
                                        <button id="GallerySyncButton" class="btn btn-info" >Sync</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Menu</td>
                                    <td>
                                        <button id="MenuSyncButton" class="btn btn-info" >Sync</button>
                                    </td>
                                </tr>

                            </table>
                            </div>
                        </div>
                    </div>
                </div>


                <br><br>

                <div class="row">
                    <div class="push-md-3 col-md-6">
                        <div class="card">
                            <div id="Div_ReturnText" class="card-block">
                            </div>
                        </div>
                    </div>
                </div>

                <br><br>



















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

<script type="text/javascript">

    function UpdateSyncState(ButtonId, ColumnName){



        $('#' + ButtonId).click(function(){
            $.ajax({
                url: "process-update-sync.php",
                method: "POST",
                data: { '__update_column': ColumnName},

                success:function(data, status, xhr) {
                    $('#Div_ReturnText').html("<p style='color: green'> " +  data + "</p>") ;

                },
                error:function (xhr, status, error){
                    $('#Div_ReturnText').html("<p style='color: red'>" + error + "</p>") ;
                }

            }) ;
            console.log(categoryCode) ;
        }) ;
    }


    UpdateSyncState('AboutUsSyncButton', 'aboutus_sync') ;
    UpdateSyncState('BlogSyncButton', 'blog_sync') ;
    UpdateSyncState('ContactSyncButton', 'contact_sync') ;
    UpdateSyncState('GallerySyncButton', 'gallery_sync') ;
    UpdateSyncState('MenuSyncButton', 'menu_sync') ;



</script>




</html>
