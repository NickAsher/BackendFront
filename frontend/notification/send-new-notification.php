<html>
<head>
    <title>SendToken | Single</title>

    <link rel="stylesheet" href="../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-reboot.min.css" >

    <link rel="stylesheet" href="../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../lib/t3/t3.css" />

    <link rel="stylesheet" href="../common/css/my_general_classes.css">
    <link rel="stylesheet"  href="../common/css/classes.css">

    <link rel="stylesheet" href="css/default_style.css">

    <?php require_once '../../utils/constants.php'; ?>


</head>
<body>

<div><?php require_once "includes/header.php" ?></div>

<section>
    <?php  require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12 bg-grey" >


            <div id="space_below_header">
                <br><br><br><br><br>
            </div>




            <div class="row">
                <div class = col-md-2></div>
                <div class="col-md-9" >
                    <form action="process-send-notification2.php" method="post">


                        <div class="card">
                            <div class="card-block">
                                <div class="form-group row">
                                    <label for="input-notf-title" class="col-3 col-form-label">Title </label>
                                    <div class="col-md-9">
                                        <input name = '__notf_title' id="input-notf-title" class="form-control" type="text" placeholder="Title of the Notification" >
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="input-notf-message" class="col-3 col-form-label">Message Id</label>
                                    <div class="col-md-9">
                                        <textarea name = '__notf_message' id="input-notf-message" class="form-control" type="text" placeholder="Message of the Notification"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="input-notf-exp-time" class="col-3 col-form-label">Expiration Date: </label>
                                    <div class="col-md-9">
                                        <input name = '__notf_exp_time' id="input-notf-exp-time" class="form-control" type="number" placeholder="Time in Seconds" >
                                    </div>
                                </div>
                            </div>
                        </div>



                        <br><br>







                        <br><br>





                        <div class="form-group row">
                            <div class="col-4" ></div>
                            <input type="submit" class=" col-4 btn btn-outline-info" value="Send Notification">
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



<div><?php require_once "../common/includes/footer.php" ?></div>
</body>
<script type="text/javascript" src="../../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../lib/t3/t3.js"></script>

<script type="text/javascript">


</script>

</html>