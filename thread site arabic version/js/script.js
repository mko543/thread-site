var imgee = new FormData();
function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
}
$(document).ready(function(){
    var pageNum = getUrlParameter('page');
    $(".page-"+pageNum).attr("id","activepage")
});
function viewImg(input){
    if(input.files && input.files[0]){
        var read = new FileReader();
        read.onload = function(e){
            $("#theimg").attr("src",e.target.result);
        }
        read.readAsDataURL(input.files[0]);
        imgee.append('img',input.files[0]);
    }
}
    
function loginfunc(caller){
    var user = $("#user").val();
    var pass = $("#pass").val();
    var kak = $(caller).html();
    $.ajax({
        type: "post",
        url: "Mko23login",
        data: {user,pass},
        beforeSend: function(){
            $(caller).html('<i class="fa fa-circle-o-notch fa-spin"> </i>   يرجى الأنتظار....');
        },
        success: function (response) {
            $(caller).html(kak);
            if($(response).filter("res").text() === '1'){
                location.reload();
            }else{
                alert($(response).filter("res").text());
            }
        }
    });
}

function noimg (caller){
    alert($(caller).attr("src"));
    if($(caller).attr("src") == "1"){
    $(caller).attr("src","style/noimg.png");
    }
}