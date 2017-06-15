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
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';

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
                                        $HrefDivColumn = "#Div_".$CategoryCode."_table" ;

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
                        $NoOfSizes = $CategoryRecord['category_no_of_size_variations'] ;



                        $NameDivColumn = "Div_" . $CategoryCode . "_table";

                        if($FirstItem){
                            $ActiveShowString = " active show" ;
                        } else {
                            $ActiveShowString = "  " ;
                        }
                        $FirstItem = false ;
                        
                        echo "
                            <div id='$NameDivColumn' class = 'tab-pane fade $ActiveShowString'>
                                <table  class='table table-bordered table-hover' >

                                    <tr class='table-info'>
                                        <th>Item Image</th>
                                        <th>Item Name</th>
                                        <th>Item Price</th>
                                        <th>Item Active</th>
                                        <th>Item Edit</th>
                                        <th>Item Delete</th>
                                    </tr>
                        " ;

                                    $ListOfMenuItemsInCategory = getListOfAllMenuItemsInCategory_Array($DBConnectionBackend, $CategoryCode) ;
                                    foreach($ListOfMenuItemsInCategory as $Record){
                                            $ItemId = $Record['item_id'] ;
                                            $ItemName = $Record['item_name'] ;
                                            $ItemPriceString = getItemPriceString($DBConnectionBackend, $CategoryCode, $ItemId) ;
                                            $ItemImage = $Record['item_image_name'] ;
                                            $ItemDescription = $Record['item_description'] ;
                                            $ItemActive = $Record['item_is_active'] ;
                                            if($ItemActive == 'true'){
                                                $ActiveButton = "<div class='btn btn-success' disabled><i class='fa fa-check'></i></div>" ;
                                            } else if($ItemActive == 'false'){
                                                $ActiveButton = "<div class='btn btn-danger' disabled><i class='fa fa-times'></i></div>" ;
                                            }

                                            $DetailPageLink = "show-menuitem.php?___menu_item_id=$ItemId" ;

                                            echo "
                                                    <tr >
                                                        <td class='addon-link' data-href='$DetailPageLink'><img src='$IMAGE_BACKENDFRONT_LINK_PATH/$ItemImage' class='img-fluid' width = '80px' ></td>
                                                        <td class='addon-link' data-href='$DetailPageLink'><p class='link-black'>$ItemName</p></td>
                                                        <td class='addon-link' data-href='$DetailPageLink'>$ItemPriceString</td>
                                                        <td class='addon-link' data-href='$DetailPageLink'>$ActiveButton</td>
                                                        <td>
                                                            <form method='get' action='edit-menuitem.php'>
                                                                <input type='hidden' name='___menu_item_id' value='$ItemId'>
                                                                <input type='submit' class='btn btn-info' value='Edit' >
                                                            </form>
                                                        </td>                                
                                                        <td>
                                                            <form method='post' action='confirm-delete-menuitem.php'>
                                                                <input type='hidden' name='__menu_item_id' value='$ItemId'>
                                                                <input type='submit' class='btn btn-danger' value='Delete' >
                                                            </form>
                                                        </td>                     
                                                    </tr>
                                                    ";
                                    }

                        echo "
                                </table>
                                
                                
                                <br><br>
                                <div class='row'>
                                    <div class='col-4'></div>
                                    <a class='col-4 btn btn-outline-info' href='add-menuitem.php?___category_code=$CategoryCode'>
                                        Add New Item
                                    </a>
                                    <div class='col-4'></div>
                                </div>
                                
                                
                            </div>
                            
                            
                            
                            
                            
                            
                            
                        
                        " ;
                    
                        
                        
                        
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
