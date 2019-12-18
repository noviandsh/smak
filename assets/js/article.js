$(window).scroll(function () {
    if ($(this).scrollTop()  <= 0 ){
        $("#navbar").removeClass('not-top');
        // $("#article-content").css('margin-top', '210px');
    }else{
        $("#navbar").addClass('not-top');
        // $("#article-content").css('margin-top', '70px');
        // $("#school-info").slideUp();
    }
});
$("#burgerbar").click(function(){
    $("#navbar").toggleClass('open');
});
$('#footer').css('height', '40px');