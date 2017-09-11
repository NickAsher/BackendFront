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

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />


    <?php

    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';


    $DBConnectionBackend = YOPDOSqlConnect() ;

    $TaxId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__tax_id') ;


    $Query = "SELECT * FROM `tax_table` WHERE `tax_id` = :tax_id " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute(['tax_id' => $TaxId]);
        $Record = $QueryResult->fetch(PDO::FETCH_ASSOC) ;
    } catch (Exception $e) {
        die("Unable to fetch the tax from tax_table: ".$e) ;
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




                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>



                <div class="row">
                    <div class = col-md-1></div>
                    <div id="Section_AddNewItemForm" class="col-md-10" >
                        <form action="process-edit-tax.php" method="post">

                        <input name="__tax_id" value="<?php echo $Record['tax_id'] ?>" type="hidden">



                        <div class="form-group row">
                            <label for="input-tax-name" class="col-3 col-form-label">Tax Name</label>
                            <div class="col-md-9">
                                <input name="__tax_name" id="input-tax-name" class="form-control" type="text" value="<?php echo $Record['tax_name']?>" >
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="input-tax-percentage" class="col-3 col-form-label">Tax Percentage </label>
                            <div class="col-md-9">
                                <input name="__tax_percentage" id="input-tax-percentage" class="form-control" type="text"  value="<?php echo $Record['tax_percentage']?>" >
                            </div>
                        </div>





                        <br><br>


                        <div class="form-group row">
                            <div class="col-4" ></div>
                            <input type="submit" class=" col-4 btn btn-info" value="Save this">
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



<!--<div>--><?php //require_once "../common/includes/footer.php" ?><!--</div>-->


</body>
<script type="text/javascript"  src="../../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
<script >















</script>
</html>