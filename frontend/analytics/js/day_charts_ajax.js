function loadChart(ChartId, ChartDate, ChartDiv){
    $.ajax({
        method: "POST",
        url:'/BackendFront/frontend/analytics/controller/controller_ajax_daily.php',
        data : {'chart_id':ChartId, 'chart_date':ChartDate, 'chart_div':ChartDiv},

        success : function (dataa) {
            $(ChartDiv).html(dataa) ;
        },

        error : function(jqXHR, textStatus, errorThrown){

            alert("Failed to load the data"  + errorThrown ) ;

        }


    }) ;
}

function loadDefaultState(){

    loadChart("Day_ItemStatChart_ColumnChart", YOLO_GLOBALZ_DATE, '#itemstats_chart_div') ;
    $('#Day_ItemStatChart_ColumnChart').addClass('active') ;

    loadChart("Day_CategoryStatChart_ColumnChart", YOLO_GLOBALZ_DATE, '#categorystats_chart_div') ;
    $('#Day_CategoryStatChart_ColumnChart').addClass('active') ;




}

$('document').ready(function () {

    $('.dropdown-toggle').dropdown() ;

    loadDefaultState() ;



    $('.chart-item-itemstats').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBALZ_DATE, '#itemstats_chart_div') ;

        $('.chart-item-itemstats').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR) ;
        return false ;
    }) ;

    $('.chart-item-categorystats').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBALZ_DATE, '#categorystats_chart_div') ;

        $('.chart-item-categorystats').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBALZ_DATE) ;
        return false ;
    }) ;


















}) ;
