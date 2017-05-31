function loadChart(ChartId, ChartMonth1, ChartYear1, ChartMonth2, ChartYear2, ChartDiv){
    $.ajax({
        method: "POST",
        url:'/BackendFront/frontend/analytics/controller/controller_ajax_compare_month.php',
        data : {'chart_id':ChartId, 'chart_month1':ChartMonth1, 'chart_year1' : ChartYear1,
            'chart_month2':ChartMonth2, 'chart_year2' : ChartYear2,'chart_div':ChartDiv},

        success : function (dataa) {
            $(ChartDiv).html(dataa) ;
        },

        error : function(jqXHR, textStatus, errorThrown){

            alert("Failed to load the data"  + errorThrown ) ;

        }


    }) ;
}

function loadDefaultState(){
    loadChart("CompareMonth_MainChart_TotalSale_Day", YOLO_GLOBAL_MONTH1, YOLO_GLOBAL_YEAR1, YOLO_GLOBAL_MONTH2, YOLO_GLOBAL_YEAR2, '#main_chart_div') ;
    $('#Month_MainChart_TotalSale_Day').addClass('active') ;


    loadChart("CompareMonth_DetailChart_AverageOrderPrice_Day", YOLO_GLOBAL_MONTH1, YOLO_GLOBAL_YEAR1, YOLO_GLOBAL_MONTH2, YOLO_GLOBAL_YEAR2, '#detail_chart_div') ;
    $('#CompareMonth_DetailChart_AverageOrderPrice_Day').addClass('active') ;






}

$('document').ready(function () {

    $('.dropdown-toggle').dropdown() ;

    loadDefaultState() ;



    $('.chart-item-main').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_MONTH1, YOLO_GLOBAL_YEAR1, YOLO_GLOBAL_MONTH2, YOLO_GLOBAL_YEAR2, '#main_chart_div') ;

        $('.chart-item-main').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR1) ;
        return false ;
    }) ;


    $('.chart-item-detail').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_MONTH1, YOLO_GLOBAL_YEAR1, YOLO_GLOBAL_MONTH2, YOLO_GLOBAL_YEAR2, '#detail_chart_div') ;

        $('.chart-item-detail').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR1) ;
        return false ;
    }) ;























}) ;
