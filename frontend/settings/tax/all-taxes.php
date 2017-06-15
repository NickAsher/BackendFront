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




    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';

    $DBConnectionBackend = YOLOSqlConnect() ;


    $Query = "SELECT * FROM `tax_table` ORDER BY `tax_sr_no` ASC" ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    if(!$QueryResult){
        die("Unable to fetch the taxes from the tax_table".mysqli_error($DBConnectionBackend)) ;
    }


    ?>



</head>



<body>
<?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/header.php'; ?>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12 bg-white">




                <div id="space_below_TabPanelHeader">
                    <br><br><br>
                </div>






                <div id='Div_MainTableContent' >
                    <table  class='table table-bordered table-hover' >

                        <tr class='table-info'>
                            <th>Sr No</th>
                            <th>Tax Name</th>
                            <th>Item Percentage</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>


                    <?php
                    $FirstItem = true ;
                    foreach ($QueryResult as $Record) {
                        $TaxId = $Record['tax_id'];
                        $TaxName = $Record['tax_name'];
                        $TaxPercentage = $Record['tax_percentage'] ;
                        $TaxSrNo = $Record['tax_sr_no'] ;


                        $DetailPageLink = "show-tax.php?___tax_id=$TaxId" ;


                        echo "
                            <tr>
                                <td class='addon-link' data-href='$DetailPageLink'>$TaxSrNo</td>
                                <td class='addon-link' data-href='$DetailPageLink'>$TaxName</td>
                                <td class='addon-link' data-href='$DetailPageLink'>$TaxPercentage</td>
                                <td>
                                    <form method='post' action='edit-tax.php'>
                                        <input type='hidden' name='__tax_id' value='$TaxId'>
                                        <input type='submit' class='btn btn-info' value='Edit' >
                                    </form>
                                </td>                                
                                <td>
                                    <form method='post' action='confirm-delete-tax.php'>
                                        <input type='hidden' name='__tax_id' value='$TaxId'>
                                        <input type='submit' class='btn btn-danger' value='Delete' >
                                    </form>
                                </td>                     
                            </tr>
                            ";
                        }


                    ?>
                        </table>


                        <br><br>
                        <div class='row'>
                            <div class='col-4'></div>
                            <a class='col-4 btn btn-outline-info' href='add-tax.php'>
                                Add New Item
                            </a>
                            <div class='col-4'></div>
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
