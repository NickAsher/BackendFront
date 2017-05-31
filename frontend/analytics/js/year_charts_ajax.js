function loadChart(ChartId, ChartYear, ChartDiv){
    $.ajax({
        method: "POST",
        url:'/BackendFront/frontend/analytics/controller/controller_ajax_year.php',
        data : {'chart_id':ChartId, 'chart_year' : ChartYear, 'chart_div':ChartDiv},

        success : function (dataa) {
           $(ChartDiv).html(dataa) ;
        },

        error : function(jqXHR, textStatus, errorThrown){

            alert("Failed to load the data"  + errorThrown ) ;

        }


    }) ;
}


function loadDefaultState(){
    loadChart("Year_MainChart_TotalSale_Month", YOLO_GLOBAL_YEAR, '#main_chart_div') ;
    $('#Year_MainChart_TotalSale_Month').addClass('active') ;

    loadChart("Year_ItemStatChart_ColumnChart", YOLO_GLOBAL_YEAR, '#itemstats_chart_div') ;
    $('#Year_ItemStatChart_ColumnChart').addClass('active') ;

    loadChart("Year_CategoryStatChart_ColumnChart", YOLO_GLOBAL_YEAR, '#categorystats_chart_div') ;
    $('#Year_CategoryStatChart_ColumnChart').addClass('active') ;




}












$('document').ready(function () {

    $('.dropdown-toggle').dropdown() ;

    loadDefaultState() ;







    $('.chart-item').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_YEAR, '#main_chart_div') ;

        $('.chart-item').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR) ;
        return false ;
    }) ;


    $('.chart-item-detail').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_YEAR, '#detail_chart_div') ;

        $('.chart-item-detail').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR) ;
        return false ;
    }) ;


    $('.chart-item-itemstats').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_YEAR, '#itemstats_chart_div') ;

        $('.chart-item-itemstats').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR) ;
        return false ;
    }) ;

    $('.chart-item-categorystats').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_YEAR, '#categorystats_chart_div') ;

        $('.chart-item-categorystats').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR) ;
        return false ;
    }) ;



















}) ;
