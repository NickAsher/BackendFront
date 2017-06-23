<html>
<head>
    <title>Some yolo </title>
    <link rel='stylesheet' href='../../../lib/bootstrap4/bootstrap-reboot.min.css' type="text/css" media='all'>
    <link rel='stylesheet' href='../../../lib/bootstrap4/bootstrap.min.css' type="text/css" media='all'>
    <link rel='stylesheet' href='../../../lib/bootstrap4/bootstrap-grid.min.css' type="text/css" media='all'>

    <style media='all'>
        .invoice-box{
            max-width:800px;
            margin:auto;
            padding:30px;
            border:1px solid #eee;
            box-shadow:0 0 10px rgba(0, 0, 0, .15);
            font-size:16px;
            line-height:24px;
            font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color:#555;
        }

        .left{
            text-align: left;  }
        .center{
            text-align: center;  }
        .right{
            text-align: right;  }



        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td{
                width:100%;
                display:block;
                text-align:center;
            }


        }
    </style>
</head>
<body>
<!--    <iframe src="receipt_23.php" name="frame"></iframe>-->
<!--    <input type="button" onclick="frames['frame'].print()" value="printletter">-->

    <button id="somebtn">Click this to Add things to below div</button>
    <div id="outerdiv">
        <div id="getcontentdiv"></div>
    </div>
</body>
<script type="text/javascript"   src="../../../lib/jquery/jquery.js" ></script>
<script type="text/javascript"   src="../../../lib/jquery/jquery.print.js" ></script>
<script type="text/javascript">







    $('#somebtn').click(function () {

        var printdata;
        $.ajax({
            url: 'receipt_2.html',

            success: function (resp) {
                printdata = $(resp).find('#outerbox').html();
                console.log("Success is acheived: " + printdata);

                $('#getcontentdiv').html(printdata);
                $('#outerdiv').hide() ;

                $('#getcontentdiv').print({
                    globalStyles: true,
                    mediaPrint: false,
                    stylesheet: null,
                    noPrintSelector: ".no-print",
                    iframe: true,
                    append: null,
                    prepend: null,
                    manuallyCopyFormValues: true,
                    deferred: $.Deferred(),
                    timeout: 750,
                    title: null,
                    doctype: '<!doctype html>'
                });

            }
        });

    });
//        $("<iframe>")                             // create a new iframe element
//            .hide()                               // make it invisible
//            .attr("src", "/url/to/page/to/print") // point the iframe to the page you want to print
//            .appendTo("body");    }) ;

</script>
</html>