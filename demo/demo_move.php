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

    <link rel="stylesheet" href="../lib/jquery_ui/jquery-ui.min.css">
    <link rel="stylesheet" href="../lib/jquery_ui/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="../lib/jquery_ui/jquery-ui.theme.min.css">


</head>
    <style>
        .listo-group li{
            background-color: lightgreen;
            color: whitesmoke;
            font-weight: 700;
            padding: 5px;
            list-style-type: none;
            margin: 2px;
            width: 180px;
            border: 1px solid black;
        }

        .highlight {
            border: 1px solid red;
            font-weight: bold;
            font-size: 45px;
            background-color: #333333;
        }
    </style>
<body>



    <ul id="sorting" class="listo-group">
        <li id="item1">Some1</li>
        <li id="item2">Some2</li>
        <li id="item3">Some3</li>
        <li id="item4">Some4</li>
        <li id="item5">Some5</li>
        <li id="item6">Some6</li>
        <li id="item7">Some7</li>
        <li id="item8">Some8</li>
    </ul>


    <br><br>
    <button id="savebtn" class="btn btn-info">Save This</button>




</body>





<script type="text/javascript" src="../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../lib/bootstrap4/bootstrap_toggle.js" ></script>
<script type="text/javascript" src="../lib/jquery_ui/jquery-ui.js" ></script>

<script>
    $('#sorting').sortable({
        axis:'y',
        opacity:0.7,
        placeholder: "highlight",
    }) ;

    $('#savebtn').click(function(){
        var sortedarray = $('#sorting').sortable("toArray") ;
        console.log(sortedarray) ;
    }) ;





</script>
</html>