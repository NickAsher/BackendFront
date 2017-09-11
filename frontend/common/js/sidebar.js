
function handleNavigation(listClass){
    // this function adds the active class to the currently selected list item

    var CorrectAnchorElementId = '' ;

    $(listClass + " > li > a").each(function() {
        var anchorElement = this ;

        var currentUrl = location.protocol + '//' + location.host + location.pathname ;

        if (anchorElement.href == currentUrl) {
            //console.log("this.href = " + anchorElement.href + " & window location href = " + window.location.href) ;
            $(this).addClass("active");
            CorrectAnchorElementId = this.id ;
            console.log(CorrectAnchorElementId) ;
        }
    });
    return CorrectAnchorElementId ;

}

function handleNestedListNavigation(listClass, nestLevel){
    switch (nestLevel){
        case 0:
            break ;
        case 1:
            var anchorElementId = handleNavigation(listClass) ;
            var ParentDiv = $("#" + anchorElementId).parent().parent().parent() ;
            ParentDiv.collapse("show") ;
            var ParentListAnchorId = "link_sublist_" + ParentDiv.attr('id') ;
            //console.log(ParentListAnchorId) ;
            $('#' + ParentListAnchorId).addClass("active-sub") ;
            break ;
    }








}


handleNavigation(".list-yolo") ;
var anchord = handleNestedListNavigation(".list-yolo-sub", 1) ;
