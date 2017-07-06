<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-8">



<!--    <link rel="stylesheet" href="../../../../lib/reset/reset.css" >-->

    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../../../lib/bootstrap4/bootstrap_addon.css" >

    <link rel = "stylesheet" href="../../../lib/jquery_ui/jquery-ui.min.css" >
    <link rel = "stylesheet" href="../../../lib/jquery_ui/jquery-ui.structure.css" >
    <link rel = "stylesheet" href="../../../lib/jquery_ui/jquery-ui.theme.css" >



    <link rel="stylesheet" href="../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../../common/css/sort.css" />



    <?php
    require_once '../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
//    require_once 'utils/gallery-utils.php';


    $DBConnectionBackend = YOPDOSqlConnect() ;

    $Query = "SELECT * FROM `tax_table` ORDER BY `tax_sr_no` ASC" ;
    try {
        $QueryResult = $DBConnectionBackend->query($Query);
        $AllTaxes = $QueryResult->fetchAll() ;
    } catch (Exception $e) {
        die("Unable to fetch the taxes from the tax_table: ".$e) ;
    }


    ?>




</head>



<body style="background:whitesmoke;">
<?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/header.php'; ?>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12 bg-whitegrey">





                <div id="space_below_TabPanelHeader">
                    <br><br><br>
                </div>


                    <div class="row">
                        <div class="push-md-3 col-md-6">
                            <div class="card">
                                <div class="card-block">
                                    <h1 class="text-center">Sort Taxes</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br><br>


                <div class="row">
                    <div class="push-md-3 col-md-6">
                        <div class="card">
                            <div class="card-block text-center">
<!--                                <center>-->

                                <ol id="yo" class="hidden-list-numbering" style="display: inline-block;float: left;">
                                    <?php
                                    foreach ($AllTaxes as $Record){
                                        echo "<li></li>" ;
                                    }
                                    ?>

                                </ol>

                                <ol id="sorting" class="listo-group" style="display: inline-block">
                                    <?php
                                    foreach ($AllTaxes as $Record){
                                        $ItemId =  $Record['tax_id'] ;
                                        $TaxName = $Record['tax_name'] ;
                                        echo "<li id='$ItemId'>$TaxName</li>" ;
                                    }
                                    ?>

                                </ol>
<!--                                </center>-->
                            </div>
                        </div>
                    </div>
                </div>




                <br><br>

                <div class="row">
                    <div class="push-md-3 col-md-6">
                        <div class="card">
                            <div class="card-block" style="text-align: center">
                                <div class="row">
                                    <button id="SaveBtn" class="push-md-2 col-md-8 btn btn-info" style="width: inherit" >Save Sort Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <br>
                <div id="MessageContainer" >

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
<script type="text/javascript"  src="../../../lib/jquery_ui/jquery-ui.min.js"></script>

<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../../lib/t3/t3.js"></script>
<script>
    $('#sorting').sortable({
        placeholder: "highlight",
        forcePlaceholderSize: true,
        axis:'y',
        opacity:0.7
    }) ;


    $('#SaveBtn').click(function(){
        var sortedarray = $('#sorting').sortable("toArray") ;
        $.ajax({
            url: "process-save-sort.php",
            method: "POST",
            data: { '__sortarray': sortedarray },
            success:function(data, status, xhr) {
                $('#MessageContainer').html("<p class='green'>Success acheived : " + data + "</p>") ;

            },
            error:function (xhr, status, error){
                $('#MessageContainer').html("<p class='red'>There seems to be some error with ajax request: " + error + "</p>") ;
            }

        }) ;
        console.log(categoryCode) ;
    }) ;







</script>
</html>
