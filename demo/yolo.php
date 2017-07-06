

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" href="../lib/jquery_ui/jquery-ui.css">
    <link rel="stylesheet" href="../lib/jquery_ui/jquery-ui.structure.css">
    <link rel="stylesheet" href="../lib/jquery_ui/jquery-ui.theme.css">


      <link rel="stylesheet" href="../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.css" />

  </head>
  <body>


              <form method="post">
                  Tey: <input type='text' name="__time" id='time' > <br>
                  roy: <button type="submit"  id="yolo">Submit</button> <br>
              </form>











</body>
<script type="text/javascript" src="../bower_components/jquery/dist/jquery.js"></script>
<script type="text/javascript" src="../lib/jquery_ui/jquery-ui.js" ></script>
<script type="text/javascript" src="../bower_components/momentjs/min/moment.min.js"></script>
<script type="text/javascript" src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.js"></script>

    <script type="text/javascript">



        $('#time').timepicker({
            timeFormat: "hh:mm tt"
        });




        $('#yolo').click(function () {

//            $('#time').datetimepicker('setDate', (new Date() ) );
            $('#time').datetimepicker('setDate', ("2017 12 12 07:08 am" ) );

//            alert($('#time').datetimepicker('getDate'));
        }) ;



</script>

</html>