<?php

session_start() ;


if(!isset($_SESSION['printed_order_no'])){
    $_SESSION['printed_order_no'] = 1 ;

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
        var Sessionvalue = "<?php echo $_SESSION['printed_order_no'] ?>" ;
        var lastOrderNo ;
        $.ajax({
            url : 'background_fetcher.php',

            success : function( resp ) {
                lastOrderNo = $('#outer_inner_div' , resp).html() ;
                $('#somelist').html( $('#internal_list' , resp).html() );


                console.log("Last order no is " + lastOrderNo ) ;
                console.log("Returned rows are :  " + $('#internal_list' , resp).html()) ;
                console.log("Cookie value is " +Sessionvalue) ;





            }
        }) ;


    }
//    loadContent2() ;

//    setInterval(loadContent2, 4000) ;


    function loadSession(){

        var lastOrderNo ;
        $.ajax({
            url : 'yolo.php',
            method: 'POST',

            success : function( resp ) {
                console.log("Session value is " + "<?php echo $_SESSION['printed_order_no'] ?>") ;
            }
        }) ;



    }
    loadSession() ;
    setInterval(loadSession, 4000) ;

</script>
</html>