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

    //  WP Gallery extension
    $('.wpa_slideshow .wpa__slides').bxSlider({
        adaptiveHeight: true,
        prevText: '',
        nextText: '',
        auto: true,
        pause: 7e3
    });

    $("#menuopen").click(function () {
        $(this).toggleClass('active').next().stop().slideToggle(400);
    });
});

$(window).load(function(){
    "use strict";

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