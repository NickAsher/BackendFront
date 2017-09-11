function loadChart(ChartId, ChartMonth, ChartYear, ChartDiv){
    $.ajax({
        method: "POST",
        url:'/BackendFront/frontend/analytics/controller/controller_ajax_month.php',
        data : {'chart_id':ChartId, 'chart_month':ChartMonth, 'chart_year' : ChartYear, 'chart_div':ChartDiv},

        success : function (dataa) {
            $(ChartDiv).html(dataa) ;
        },

        error : function(jqXHR, textStatus, errorThrown){

            alert("Failed to load the data"  + errorThrown ) ;

        }


    }) ;
}

function loadDefaultState(){
    loadChart("Month_MainChart_TotalSale_Day", YOLO_GLOBAL_MONTH, YOLO_GLOBAL_YEAR, '#main_chart_div') ;
    $('#Month_MainChart_TotalSale_Day').addClass('active') ;

    loadChart("Month_ItemStatChart_ColumnChart", YOLO_GLOBAL_MONTH, YOLO_GLOBAL_YEAR, '#itemstats_chart_div') ;
    $('#Month_ItemStatChart_ColumnChart').addClass('active') ;

    loadChart("Month_CategoryStatChart_ColumnChart", YOLO_GLOBAL_MONTH, YOLO_GLOBAL_YEAR, '#categorystats_chart_div') ;
    $('#Month_CategoryStatChart_ColumnChart').addClass('active') ;




}

$('document').ready(function () {

    $('.dropdown-toggle').dropdown() ;

    loadDefaultState() ;



    $('.chart-item-main').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_MONTH, YOLO_GLOBAL_YEAR, '#main_chart_div') ;

        $('.chart-item-main').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR) ;
        return false ;
    }) ;


    $('.chart-item-detail').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_MONTH, YOLO_GLOBAL_YEAR, '#detail_chart_div') ;

        $('.chart-item-detail').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR) ;
        return false ;
    }) ;

    $('.chart-item-itemstats').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_MONTH, YOLO_GLOBAL_YEAR, '#itemstats_chart_div') ;

        $('.chart-item-itemstats').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR) ;
        return false ;
    }) ;

    $('.chart-item-categorystats').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_MONTH, YOLO_GLOBAL_YEAR, '#categorystats_chart_div') ;

        $('.chart-item-categorystats').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR) ;
        return false ;
    }) ;


















}) ;
