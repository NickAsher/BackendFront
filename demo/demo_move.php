<?php

require_once '../sql/sqlconnection.php' ;
require_once '../frontend/start-stop/start_stop_utils.php' ;
$DBConnection = YOLOSqlConnect() ;


if(isset($_POST['__submit'])){
    echo $_POST['__real_textbox'] ;
}


?>
<html>
<head>
    <link rel="stylesheet" href="../lib/bootstrap4/bootstrap.min.css" >
    <link rel="stylesheet" href="../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel="stylesheet" href="../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel="stylesheet" href="../lib/bootstrap4/bootstrap_toggle.css" >

</head>
<body>

yolo <br>
<form method="post">

    <input type="hidden" name="__real_textbox"  id="hidden-toggle-chooser" value="false">



    <input id="toggleer" type="checkbox" data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" >
    <input name="__submit" type="submit" value="Submit" >
</form>
</body>





<script src="../lib/jquery/jquery.js" ></script>
<script src="../lib/bootstrap4/bootstrap.min.js" ></script>
<script src="../lib/bootstrap4/bootstrap_toggle.js" ></script>

<script>

    function setupToggleButton(PresentationInputId, HiddenInputId){
        $('#' + PresentationInputId).on('change', function() {
            if(this.checked){
                $('#' + HiddenInputId).val('true') ;
            } else {
                // this is necessary if user checked it and then unchecked it.
                $('#' + HiddenInputId).val('false') ;
            }
        });
    }
    setupToggleButton('toggleer', 'hidden-toggle-chooser') ;

</script>
</html>