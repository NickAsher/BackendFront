<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-8">



<!--    <link rel="stylesheet" href="../../../../lib/reset/reset.css" >-->

    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../../../../lib/bootstrap4/bootstrap_addon.css" >

    <link rel = "stylesheet" href="../../../../lib/jquery_ui/jquery-ui.min.css" >
    <link rel = "stylesheet" href="../../../../lib/jquery_ui/jquery-ui.structure.css" >
    <link rel = "stylesheet" href="../../../../lib/jquery_ui/jquery-ui.theme.css" >



    <link rel="stylesheet" href="../../../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../../../common/css/sort.css" />



    <?php
    require_once '../../../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
    require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu_item-utils.php';


    $DBConnectionBackend = YOLOSqlConnect() ;
    $CategoryCode = isSecure_checkPostInput('__category_code') ;

    $CategorySubCategoriesListArray = getListOfAllSubCategory_InACategory_Array($DBConnectionBackend, $CategoryCode) ;


    ?>
    <



</head>



<body>
<?php require_once "../../subcommon/includes/header.php" ?>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div class="col-md-12 bg-white">





                <div id="space_below_TabPanelHeader">
                    <br><br><br>
                </div>

                <div>
                    <center><h1>Sort SubCategories</h1></center>
                    <br><br>
                </div>


                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <ol id="yo" class="hidden-list-numbering" style="display: inline-block;float: left">
                            <?php
                            foreach ($CategorySubCategoriesListArray as $Record){
                                echo "<li></li>" ;
                            }
                            ?>

                        </ol>

                        <ol id="sorting" class="listo-group">
                            <?php
                            foreach ($CategorySubCategoriesListArray as $Record){
                                $RelId = $Record['rel_id'] ;
                                $SubCategoryDisplayName = $Record['subcategory_display_name'] ;

                                echo "<li id='$RelId'>$SubCategoryDisplayName</li>" ;
                            }
                            ?>

                        </ol>
                    </div>
                    <div class="col-md-4"></div>
                </div>

                <br><br>


                <div class="form-group row">
                    <div class="col-4" ></div>
                    <button id="SaveBtn" class=" col-4 btn btn-info" >Add</button>
                    <div class="col-4" ></div>
                </div>

                <br>
                <div id="MessageContainer">

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
<script type="text/javascript"  src="../../../../lib/jquery/jquery.js"></script>
<script type="text/javascript"  src="../../../../lib/jquery_ui/jquery-ui.min.js"></script>

<script type="text/javascript"  src="../../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"  src="../../../../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript"  src="../../../../lib/t3/t3.js"></script>
<script>
    $('#sorting').sortable({
        placeholder: "highlight",
        forcePlaceholderSize: true,
        axis:'y',
        opacity:0.7
    }) ;


    $('#SaveBtn').click(function(){
        var sortedarray = $('#sorting').sortable("toArray") ;
        var categoryCode = '<?php echo $CategoryCode ?> ' ;
        $.ajax({
            url: "process-save-sort.php",
            method: "POST",
            data: { '__sortarray': sortedarray, '__category_code': categoryCode},
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
