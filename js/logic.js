$ = jQuery;
$(document).ready(function () {
    "use strict";
//  contact form 7
    $(this).on('click', '.wpcf7-not-valid-tip', function(){
        $(this).prev().trigger('focus');
        $(this).fadeOut(500,function(){
            $(this).remove();
        });
    });

    $(function() {
        FastClick.attach(document.body);
    });

    var swiper = new Swiper('#parent > .swiper-container', {
        pagination: '#parent .swiper-pagination',
        paginationClickable: true,
        nextButton: '#parent .swiper-button-next',
        prevButton: '#parent .swiper-button-prev'
    });

    $("#menuopen").click(function () {
        $(this).toggleClass('active').next().stop().slideToggle(400);
    });
});