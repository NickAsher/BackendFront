function loadChart(ChartId, ChartYear1, ChartYear2, ChartDiv){
    $.ajax({
        method: "POST",
        url:'/BackendFront/frontend/analytics/controller/controller_ajax_compare_year.php',
        data : {'chart_id':ChartId, 'chart_year1' : ChartYear1, 'chart_year2' : ChartYear2,'chart_div':ChartDiv},

        success : function (dataa) {
            $(ChartDiv).html(dataa) ;
        },

        error : function(jqXHR, textStatus, errorThrown){

            alert("Failed to load the data"  + errorThrown ) ;

        }


    }) ;
}

function loadDefaultState(){
    loadChart("CompareYear_MainChart_TotalSale_Day", YOLO_GLOBAL_YEAR1, YOLO_GLOBAL_YEAR2, '#main_chart_div') ;
    $('#CompareYear_MainChart_TotalSale_Day').addClass('active') ;


    loadChart("CompareYear_DetailChart_AverageDailySale_Month", YOLO_GLOBAL_YEAR1, YOLO_GLOBAL_YEAR2, '#detail_chart_div') ;
    $('#CompareYear_DetailChart_AverageDailySale_Month').addClass('active') ;






}

$('document').ready(function () {

    $('.dropdown-toggle').dropdown() ;

    loadDefaultState() ;



    $('.chart-item-main').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_YEAR1, YOLO_GLOBAL_YEAR2, '#main_chart_div') ;

        $('.chart-item-main').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR1) ;
        return false ;
    }) ;


    $('.chart-item-detail').click(function () {
        loadChart($(this).attr('id'), YOLO_GLOBAL_YEAR1, YOLO_GLOBAL_YEAR2, '#detail_chart_div') ;

        $('.chart-item-detail').removeClass('active') ;
        $(this).addClass('active') ;

        //console.log($(this).attr('id') + "-" + YOLO_GLOBAL_YEAR1) ;
        return false ;
    }) ;























}) ;
