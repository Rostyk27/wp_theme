$ = jQuery;

FastClick.attach(document.body);

$(document).ready(function () {
    "use strict";
//  contact form 7
    $(this).on('click', '.wpcf7-not-valid-tip', function(){
        $(this).prev().trigger('focus');
        $(this).fadeOut(500,function(){
            $(this).remove();
        });
    });

    $("#menuopen").click(function () {
        $(this).toggleClass('active').next().stop().toggleClass('active');
    });
});

$(window).load(function(){
    "use strict";

    $('.main_swiper').each(function(){
        var t = this,
        main_swiper = new Swiper( t, {
            nextButton          : $('.custom_next', t),
            prevButton          : $('.custom_prev', t),
            pagination          : $('.custom_pager', t),
            paginationClickable : true
        });
    });

    //  fluid video (iframe)
    $('.content article iframe').each(function(i) {
        var t = $(this),
            p = t.parent();
        if (p.is('p') && !p.hasClass('fullframe')) {
            p.addClass('fullframe');
        }
    });
    $('.wp-video').each(function(){
        $('.mejs-video .mejs-inner', this).addClass('fullframe');
    });

});