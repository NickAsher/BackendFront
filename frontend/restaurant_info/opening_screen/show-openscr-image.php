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
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;


    $OpeningScreenItemId = isSecure_checkGetInput('___item_id') ;

    $DBConnectionBackend = YOLOSqlConnect() ;


    $Query = "SELECT * FROM `opening_screen_image_table` WHERE `item_id` = '$OpeningScreenItemId' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if($QueryResult){
        if(mysqli_num_rows($QueryResult) != 1){
            die("No of rows returned is not 1") ;
        }


    } else {
        die("error in fetching the item <br> ".mysqli_error($DBConnectionBackend)) ;
    }

    $OpeningScreenItemInfo = mysqli_fetch_assoc($QueryResult) ;





    $Item_Id = $OpeningScreenItemInfo['item_id'] ;
    $Item_ImageName = $OpeningScreenItemInfo['item_image'] ;

    $ImageLinkPath = "$IMAGE_FOLDER_LINK_PATH/$Item_ImageName" ;



    ?>


</head>
<body>

<div><?php require_once "../includes/header.php" ?></div>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push">
        <div class="row">
            <div class="col-md-12 bg-black">





                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>




                <div id="Div_Content" >
                    <div>
                        <img src='<?php echo $ImageLinkPath ; ?>' class="img-fluid">
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