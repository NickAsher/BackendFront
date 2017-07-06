<?php

session_start() ;


if(!isset($_SESSION['printed_order_no'])){
    $_SESSION['printed_order_no'] = 0 ;

}

?>


<html>
<head></head>
<body>
    <ul id="somelist"></ul>
</body>

<script type="text/javascript"   src="../../../lib/jquery/jquery.js" ></script>
<script type="text/javascript"   src="../../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript"   src="../../../lib/toastr/toastr.min.js" ></script>
<script type="text/javascript"   src="../../../lib/t3/t3.js"></script>

<script type="text/javascript" >
    function loadContent2(){

        var lastOrderNo ;
        $.ajax({
            url : 'background_fetcher.php',

            success : function( resp ) {
//                console.log("data is" + resp) ;

                var printdata = $(resp).find('#printed_order_counter').html();
                console.log("Orders Printed Upto: " + printdata);






            }
        }) ;


    }
    loadContent2() ;

    setInterval(loadContent2, 4000) ;


//    function loadSession(){
//
//        var lastOrderNo ;
//        $.ajax({
//            url : 'yolo.php',
//            method: 'POST',
//
//            success : function( resp ) {
//                console.log("Session value is " + "<?php //echo $_SESSION['printed_order_no'] ?>//") ;
//            }
//        }) ;
//
//
//
//    }
//    loadSession() ;
//    setInterval(loadSession, 4000) ;

</script>
</html>