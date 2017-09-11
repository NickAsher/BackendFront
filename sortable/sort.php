<?php

require_once '../sql/sqlconnection.php' ;
//require_once '../frontend/start-stop/start_stop_utils.php' ;
$DBConnection = YOLOSqlConnect() ;
$Query = "SELECT * FROM `demo` ORDER BY `item_sr_no`ASC " ;
$QueryResult = mysqli_query($DBConnection, $Query) ;
$ItemArray = array() ;
if($QueryResult){
    foreach ($QueryResult as $Record) {
        $ItemArray[] = $Record ;
    }
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
    .highlight {
        background-color: #333333;
        width: 300px;
        padding: 5px ;
    }


    .hidden-list-numbering li{
        background-color: lightgreen;
        color: black;
        font-weight: 700;
        padding: 5px 0;
        margin: 2px;
        width: 0px;
        border: 1px solid black;
    }
    .ui-sortable-handle{
        background-color: lightgreen;
        color: whitesmoke;
        font-weight: 700;
        padding: 5px;
        margin: 2px;
        width: 300px;
        list-style-type: none;
        border: 1px solid black;
    }

    .listo-group{
        list-style-type: none;

    }


</style>
<body>

<ol id="yo" class="hidden-list-numbering" style="display: inline-block;float: left">
    <?php
    foreach ($QueryResult as $Record){
        echo "<li></li>" ;
    }
    ?>

</ol>

<ul id="sorting" class="listo-group">
    <?php
    foreach ($QueryResult as $Record){
        $ItemId = $Record['item_id'] ;
        $ItemName = $Record['item_name'] ;

        echo "<li id='$ItemId'>$ItemName</li>" ;
    }
    ?>

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
        placeholder: "highlight",
        forcePlaceholderSize: true,
        axis:'y',
        opacity:0.7
    }) ;

    $('#savebtn').click(function(){
        var sortedarray = $('#sorting').sortable("toArray") ;
        $.ajax({
            url: "process-save-sort.php",
            method: "POST",
            data: { '__sortarray': sortedarray },
            success:function(data, status, xhr) {
                console.log("Success acheived: " + data) ;
            },
            error:function (xhr, status, error){
                console.log("Error acheived: " + error) ;
            }

        }) ;
//        console.log(sortedarray) ;
    }) ;





</script>
</html>