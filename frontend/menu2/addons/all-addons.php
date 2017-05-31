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
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once '../utils/menu-utils.php';
    require_once '../utils/menu_item-utils.php';

    $DBConnectionBackend = YOLOSqlConnect() ;

    $ListOfAllCategories = getListOfAllCategories_Array($DBConnectionBackend) ;


    ?>



</head>



<body>
<?php require_once "../subcommon/includes/header.php" ?>

<section>
        <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12 bg-white">

                <div id="TabPanel_Header">
                    <div id="space_below_header" class="row" style="height: 55px;background-color: #333;"></div>
                    <div id="NavTabsPanel" class="row" style="background-color: #333;">
                        <div class="col-md-12" >

                            <div class="card-header" style="background-color: #333">
                                <ul class="nav nav-tabs card-header-tabs nav-fill ">

                                    <?php
                                    $FirstItem = true ;
                                    foreach ($ListOfAllCategories as $CategoryRecord){
                                        $CategoryCode = $CategoryRecord['category_code'] ;
                                        $CategoryName = $CategoryRecord['category_display_name'] ;
                                        $HrefDivColumn = "#MainDiv_".$CategoryCode ;

                                        if($FirstItem){
                                            $ActiveClassString = " active " ;
                                        } else {
                                            $ActiveClassString = "  " ;
                                        }
                                        $FirstItem = false ;


                                        echo "
                                            <li class='nav-item'>
                                                <a class='nav-link $ActiveClassString text-info' data-toggle='tab' href='$HrefDivColumn'>
                                                    $CategoryName
                                                </a>
                                            </li>
                                    
                                        " ;
                                    }

                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>



                <div id="space_below_TabPanelHeader">
                    <br><br><br>
                </div>





                <div class="tab-content">
                    <?php
                    $FirstItem = true ;
                    foreach ($ListOfAllCategories as $CategoryRecord) {
                        $CategoryCode = $CategoryRecord['category_code'];
                        $CategoryName = $CategoryRecord['category_display_name'];
                        $NameDivColumn = "MainDiv_" . $CategoryCode;

                        if($FirstItem){
                            $ActiveShowString = " active show" ;
                        } else {
                            $ActiveShowString = "  " ;
                        }
                        $FirstItem = false ;


                        echo "<div id='$NameDivColumn' class = 'tab-pane fade $ActiveShowString'> " ;



                        require "include-all-addons.php";


                        echo "</div>" ;




                    }
                    ?>
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
