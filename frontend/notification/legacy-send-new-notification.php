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
                                    <label for="input-notf-label" class="col-3 col-form-label">Notification Label </label>
                                    <div class="col-md-9">
                                        <input name = '__notf_label' id="input-notf-label" class="form-control" type="text" placeholder="Label of the Notification" >
                                    </div>
                                </div>
                            </div>
                        </div>



                        <br><br>



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
                                        <input name = '__notf_message' id="input-notf-message" class="form-control" type="text" placeholder="Message of the Notification" >
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



                        <div class="card">
                            <div class="card-block">

                                <div class="form-group row">
                                    <label for="input-notf-target" class="col-3 col-form-label">Target Devices</label>
                                    <div class="col-md-9">
                                        <div id="input-notf-target" class="form-check-input form-check">
                                            <label class="form-check-label">
                                                <input name = '__notf_target' onchange='controlTargetRadio_default()'  id="input-notf-target-all" class="form-check-inline" type="radio" value="all" checked="checked">All Users
                                            </label>
                                            <label class="form-check-label">
                                                <input name = '__notf_target' onchange='controlTargetRadio_Email()' id="input-notf-target-user" class="form-check-inline" type="radio" value="single">Single User
                                            </label>
                                            <label class="form-check-label">
                                                <input name = '__notf_target' onchange='controlTargetRadio_Group()' id="input-notf-target-group" class="form-check-inline" type="radio" value="group">Groups/Topics
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div id="hidden_div_target_email" class="form-group row">
                                    <label for="input--user-email" class="col-3 col-form-label">User Email</label>
                                    <div class="col-md-9">
                                        <input name = '__notf_user_email' id="input-user-email" class="form-control" type="text" placeholder="Email Id" >
                                    </div>
                                </div>


                                <div id="hidden_div_target_group" class="form-group row">
                                    <label for="input-notf-group" class="col-3 col-form-label">Group: </label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="input-notf-group" name="__notf_groups">
                                            <option value="topic0" disabled>Choose Any Topic</option>
                                            <option value="topic1">All Users</option>
                                            <option value="topic2">Android Users</option>
                                            <option value="topic3">Iphone Users/option>
                                            <option value="topic4">Atleast 5 Purchases</option>
                                            <option value="topic5">Atleast 10 Purchases</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>



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
    function controlTargetRadio_Email(){

        $('#hidden_div_target_email').show() ;
        $('#hidden_div_target_group').hide() ;

    }

    function controlTargetRadio_Group(){

        $('#hidden_div_target_email').hide() ;
        $('#hidden_div_target_group').show() ;

    }


    function controlTargetRadio_default(){
        $('#hidden_div_target_email').hide() ;
        $('#hidden_div_target_group').hide() ;
    }



    controlTargetRadio_default() ;

</script>

</html>