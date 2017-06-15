<html>
<head>
    <title> Vesu Online Ordering Cms</title>
    <link rel="stylesheet" href="../../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../../lib/bootstrap4/bootstrap-reboot.min.css" >

    <link rel="stylesheet" href="../../lib/toastr/toastr.min.css">

    <link rel="stylesheet" href="../../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../../lib/t3/t3.css" />


    <link rel="stylesheet" href="css/index.css" >
    <link rel="stylesheet" href="css/menu.css" >
    <link rel="stylesheet" href="css/tables.css" >

    <?php
    require_once '../../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/utils/menu-utils.php' ;
    require_once 'utils/utils-order-parsing.php';
    ?>

</head>
<body>


<?php require_once 'includes/header3.php'; ?>



<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12 bg-grey" >




                <div id="TabPanel_Header">
                    <div id="space_below_header" class="row" style="height: 50px;background-color: #333;"></div>
                    <div id="NavTabsPanel" class="row" style="background-color: #333;">
                        <div class="col-md-12" >

                            <div class="card-header" style="background-color: #333">
                                <ul class="nav nav-tabs card-header-tabs nav-fill ">
                                    <li class="nav-item">
                                        <a id="navTab_NewOrders" class="nav-link active text-info" data-toggle="tab" href="#new_orders">
                                            New orders
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a id="navTab_WorkingOrders" class="nav-link text-warning" data-toggle="tab" href="#working_orders">
                                            Working orders
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a id="navTab_CompletedOrders" class="nav-link text-success" data-toggle="tab" href="#complete_orders">
                                            Completed orders
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a id="navTab_CancelledOrders" class="nav-link text-danger" data-toggle="tab" href="#cancelled_orders">
                                            Cancelled orders
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </div>
                    </div>

                </div>








                <div id="space_after_tabPanel">
                    <br><br><br>
                </div>



                <div  class="row">
                    <div class="col-md-12">

                        <div id="TabContentPanel" class="tab-content">
                            <div class="tab-pane fade show active" id="new_orders"></div>
                            <div class="tab-pane fade" id="working_orders"></div>
                            <div class="tab-pane fade" id="cancelled_orders"></div>
                            <div class="tab-pane fade" id="complete_orders"></div>

                        </div>
                    </div>
                </div>


                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>





            </div>
        </div>
    </div>
</section>



<?php require_once "includes/footer.php" ?>


</body>
<script type="text/javascript"   src="../../lib/jquery/jquery.js" ></script>
<script type="text/javascript"   src="../../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../../lib/toastr/toastr.min.js" ></script>
<script type="text/javascript" src="../../lib/t3/t3.js"></script>

<script type="text/javascript" >





    function makeToast(toastStyle, toastMessage) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        } ;

        toastr[toastStyle](toastMessage) ;
    }







    /*
     *The following code is used to load the content of the page.
     * By default we have empty divs in this page with all the structure and css but no text
     * And we make a Single Ajax Call and then from that Single Ajax Response, we refresh multiple Divs with content
     *
     * This is possible only because of jquery functions.
     * We make a simple request for data in ajax.php file. There we only receive the information without any markup
     * But the information is received in divs
     * Then we use the jquery to get the values of individual divs of the response and then
     * also have  these individual divs in our order_management page to get the values from individual divs of ajax page
     *
     * Now because of the fact that we get the information in these individual divs in ajax
     * We then refresh this information after evey 4 seconds .
     *
     *
    */
    function loadContent2(){
        var badgeOrderNo ;
        $.ajax({
            url : 'ajax_page.php',

            success : function( resp ) {
                badgeOrderNo = $('#TitleBadgeNo' , resp).html() ;


                $('#navTab_NewOrders').html( $('#Ajax_navTab_NewOrders' , resp).html() );
                $('#navTab_WorkingOrders').html( $('#Ajax_navTab_WorkingOrders' , resp).html() );
                $('#navTab_CompletedOrders').html( $('#Ajax_navTab_CompletedOrders' , resp).html() );
                $('#navTab_CancelledOrders').html( $('#Ajax_navTab_CancelledOrders' , resp).html() );

                $('#new_orders').html( $('#Ajax_new_orders' , resp).html() );
                $('#working_orders').html( $('#Ajax_working_orders' , resp).html() );
                $('#cancelled_orders').html( $('#Ajax_cancelled_orders' , resp).html() );
                $('#complete_orders').html( $('#Ajax_complete_orders' , resp).html() );

                console.log(badgeOrderNo ) ;
                document.title = "(" + badgeOrderNo + ")   New Orders" ;





            }
        }) ;


    }
    loadContent2() ;

    setInterval(loadContent2, 4000) ;








    /*
     *  This here is the onclick listener for handling the order logic of individual orders
     *  It handles Accepting and Cancelling Orders in the New Orders Tab and Serving and Cancelling orders
     *  in the working orders tab.
     *  The reason that we haven't used the click function on the button is that when we the element is added
     *  to the DOM after the ajax call, the click method doesn't work. So we use "on" method for that
     *
     *  The Logic behind the working is this:
     *  The Id of a button is the "OrderId - typeOfButton" So we get the id and use split function
     *  to get OrderId and the 'typeOfButton' means accept the order or cancel the order
     *
     *  Then we make a get Request to the orderManagement_controller.php class, with OrderId and Type of Operation
     *  that we want to perform by making a function for every operation
     *  Then, if the operation(Changing order_Status) is performed successfully, we refresh the content of page
     */
    $('#TabContentPanel').on('click','.order-btn', function (event) {
        event.preventDefault() ;
        // ElementId id of form   OrderId-new_order_accept
        var ElementId =  $(this).attr('id') ;
        var splitarray = ElementId.split("-");
        var OrderId = splitarray[0] ;
        var Operation = splitarray[1] ;
        console.log("Id of the Selected Element is " + OrderId) ;

        var builtURL = 'http://localhost/BackendFront/frontend/order/controller/ordermanagement_controller.php?oper=' + Operation + '&order_id=' + OrderId ;
        console.log(builtURL) ;



        $.ajax({
            url: builtURL,
            success: function (returnString) {
                // returnString is of form  success-OrderId
                var splitarray = returnString.split("-");
                var returncode = splitarray[0];
                var order_id = splitarray[1];

                if(returncode == 'success'){
                    if(Operation == 'new_order_accept'){
                        console.log("Order: " + order_id + " has been accepted, Added to working orders") ;
                        makeToast("info", "Order: "+order_id+" has been accepted, \n Added to Working Orders") ;

                    }
                    else if(Operation == 'new_order_cancel'){
                        console.log("Order: " + order_id + " has been cancelled, Added to Cancelled orders") ;
                        makeToast("error", "Order: "+order_id+" has been cancelled, \n Added to Cancelled Orders") ;

                    }
                    else if(Operation == 'working_order_complete'){
                        console.log("Order: " + order_id + " has been served, Added to completed orders") ;
                        makeToast("warning", "Order: "+order_id+" has been served, \n Added to Completed Orders") ;

                    }
                    else if(Operation == 'working_order_cancel'){
                        console.log("Order: " + order_id + " has been cancelled, Added to cancelled orders") ;
                        makeToast("error", "Order: "+order_id+" has been cancelled, \n Added to Cancelled Orders") ;

                    }
                    loadContent2() ;
                    //location.reload(1) ;
                } else {
                    console.log("return code is not success") ;
                    console.log(returnString) ;
                }
            },
            error : function (xhr, status, errorMsg) {
                console.log("Error cattched: " +  errorMsg) ;
            }
        }) ;
    }) ;







</script>

</html>