/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/

(function() {
    'use strict';

$(document).ready(function () {

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

$(window).on('load', function(){

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

})
.bind('orientationchange resize', function() {
    window.console.log('resize');
}).resizeEnd(function(){
    window.console.log('resizeEnd');
});
}(jQuery));