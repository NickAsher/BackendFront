/* **** This is the Day Picker *** */

$(".datepicker_input").datepicker({
    dateFormat: 'yy-mm-dd',



    onSelect: function(dateText) {
        var newUrl = "http://localhost/BackendFront/frontend/analytics/day.php?date=" + dateText  ;
        window.location = newUrl;


    }
});
$("#datepicker_btn").click(function() {
    $(".datepicker_input").datepicker( "show" );

});







/* **** This is the Month Picker *** */

$(".monthpicker_input").datepicker({
    dateFormat: 'yy-mm',
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,

    onClose: function(dateText, inst) {

        /* These three classes are pre-defined in the jquery-ui library
         *      ui-datepicker-div    ui-datepicker-month   ui-datepicker-year
         *
         */

        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

        var monthText = $.datepicker.formatDate('yy-mm', new Date(year, month, 1)) ;
        var newUrl = "http://localhost/BackendFront/frontend/analytics/month.php?month=" + monthText  ;
        window.location = newUrl;

        //$(this).val(monthText);

        //console.log(monthText) ;


    }
});

$(".monthpicker_input").focus(function () {
    $(".ui-datepicker-calendar").hide();

});

$('#monthpicker_btn').click(function () {
    $(".monthpicker_input").datepicker('show') ;
}) ;
















$(".yearpicker_input").datepicker({
    dateFormat: 'yy',
    changeYear: true,
    showButtonPanel: true,

    onClose: function(dateText, inst) {


        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

        var yearText = $.datepicker.formatDate('yy', new Date(year, 1, 1)) ;
        var newUrl = "http://localhost/BackendFront/frontend/analytics/year.php?year=" + yearText  ;
        window.location = newUrl;
        $(this).val(yearText);

        //console.log(monthText) ;


    }
});

$(".yearpicker_input").focus(function () {
    $(".ui-datepicker-calendar").hide();

});

$('#yearpicker_btn').click(function () {
    $(".yearpicker_input").datepicker('show') ;
}) ;







/* **************** ********************** Datepicker for Compare Day  ***************** ******** */

/* **** This is the Day Picker *** */

$("#datepicker_input1").datepicker({
    dateFormat: 'yy-mm-dd',



    onSelect: function(dateText) {
        console.log("Date 1 is " + dateText) ;

    }
});
$("#btn_CompareDatePicker_1").click(function() {
    $("#datepicker_input1").datepicker( "show" );

});



$("#datepicker_input2").datepicker({
    dateFormat: 'yy-mm-dd',



    onSelect: function(dateText) {
        console.log("Date 2 is " + dateText) ;

    }
});
$("#btn_CompareDatePicker_2").click(function() {
    $("#datepicker_input2").datepicker( "show" );

});


$('#btn_Go_CompareDay').click(function () {
    var day1 = $('#datepicker_input1').val() ;
    var day2 = $('#datepicker_input2').val() ;

    var newUrl = "http://localhost/BackendFront/frontend/analytics/compare_day.php?day1=" + day1 + "&day2=" + day2  ;
    window.location = newUrl;
});



    /*  *********************** Compare Month Datepicker *********** */

$("#monthpicker_input1").datepicker({
    dateFormat: 'yy-mm',
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,




    onClose: function(dateText, inst) {

        /* These three classes are pre-defined in the jquery-ui library
         *      ui-datepicker-div    ui-datepicker-month   ui-datepicker-year
         *
         */

        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

        var monthText = $.datepicker.formatDate('yy-mm', new Date(year, month, 1)) ;
        // var newUrl = "http://localhost/BackendFront/dashboard/month.php?month=" + monthText  ;
        // window.location = newUrl;

        $(this).val(monthText);

        console.log("Month 1 is " + monthText) ;



    }
});

$("#monthpicker_input1").focus(function () {
    $(".ui-datepicker-calendar").hide();

});

$('#btn_CompareMonthPicker_1').click(function () {
    $("#monthpicker_input1").datepicker('show') ;
}) ;



$("#monthpicker_input2").datepicker({
    dateFormat: 'yy-mm',
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,

    onClose: function(dateText, inst) {

        /* These three classes are pre-defined in the jquery-ui library
         *      ui-datepicker-div    ui-datepicker-month   ui-datepicker-year
         *
         */

        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

        var monthText = $.datepicker.formatDate('yy-mm', new Date(year, month, 1)) ;
        // var newUrl = "http://localhost/BackendFront/dashboard/month.php?month=" + monthText  ;
        // window.location = newUrl;

        $(this).val(monthText);

        console.log("Month 2 is " + monthText) ;


    }
});

$("#monthpicker_input2").focus(function () {
    $(".ui-datepicker-calendar").hide();

});

$('#btn_CompareMonthPicker_2').click(function () {
    $("#monthpicker_input2").datepicker('show') ;
}) ;

$('#btn_Go_CompareMonth').click(function () {
    var month1 = $('#monthpicker_input1').val() ;
    var month2 = $('#monthpicker_input2').val() ;

    var newUrl = "http://localhost/BackendFront/frontend/analytics/compare_month.php?month1=" + month1 + "&month2=" + month2  ;
    window.location = newUrl;
});



    /*************************** Datepicker for comparae Year ********************** */

$("#yearpicker_input1").datepicker({
    dateFormat: 'yy',
    changeYear: true,
    showButtonPanel: true,

    onClose: function(dateText, inst) {


        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

        var yearText = $.datepicker.formatDate('yy', new Date(year, 1, 1)) ;
        // var newUrl = "http://localhost/BackendFront/dashboard/year.php?year=" + yearText  ;
        // window.location = newUrl;
        $(this).val(yearText);

        console.log("Year 1 is " + yearText) ;


    }
});

$("#yearpicker_input1").focus(function () {
    $(".ui-datepicker-calendar").hide();

});

$('#btn_CompareYearPicker_1').click(function () {
    $("#yearpicker_input1").datepicker('show') ;
}) ;





$("#yearpicker_input2").datepicker({
    dateFormat: 'yy',
    changeYear: true,
    showButtonPanel: true,

    onClose: function(dateText, inst) {


        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

        var yearText = $.datepicker.formatDate('yy', new Date(year, 1, 1)) ;
        // var newUrl = "http://localhost/BackendFront/dashboard/year.php?year=" + yearText  ;
        // window.location = newUrl;
        $(this).val(yearText);

        console.log("Year 2 is " + yearText) ;


    }
});

$("#yearpicker_input2").focus(function () {
    $(".ui-datepicker-calendar").hide();

});

$('#btn_CompareYearPicker_2').click(function () {
    $("#yearpicker_input2").datepicker('show') ;
}) ;




$('#btn_Go_CompareYear').click(function () {
    var year1 = $('#yearpicker_input1').val() ;
    var year2 = $('#yearpicker_input2').val() ;

    var newUrl = "http://localhost/BackendFront/frontend/analytics/compare_year.php?year1=" + year1 + "&year2=" + year2  ;
    window.location = newUrl;
});


