/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/

$(document).ready(function () {
    'use strict';

//  contact form 7
    $(this).on('click', '.wpcf7-not-valid-tip', function(){
        $(this).prev().trigger('focus');
        $(this).fadeOut(500,function(){
            $(this).remove();
        });
    });

    $(".nav_icon").click(function () {
        $(this).toggleClass('is_active').next().stop().toggleClass('is_open');
        return false;
    });

    $('#menu .menu-item-has-children > a').after('<span />');
    $('#menu').on('click', '.menu-item-has-children > a + span', function(){
        $(this).toggleClass('open').next().stop().slideToggle(350).parent().toggleClass('active');
    });

    $(this).on('focus', '.wpcf7-form-control:not([type="submit"])', function () {
        $(this).parent().addClass('active');
    });

    $(this).on('blur', '.wpcf7-form-control:not([type="submit"])', function(){
        if($(this).val() !== "") {
            $(this).parent().addClass('active');
        } else {
            $(this).parent().removeClass('active');
        }
    });
});

$(document).on('opening', '.remodal', function(e) {
    var t = $(e.currentTarget).find('iframe');
    if(t!==null){
        t.attr('src',t.attr('src')+'&autoplay=1');
    }
});

$(document).on('closing', '.remodal', function(e) {
    var t=$(e.currentTarget).find('iframe');
    if(t.length>0) {
        t.attr('src',t.attr('src').replace('&autoplay=1',''));
    }
});

$(window).on('load', function(){
    'use strict';

    var home_slider = new Swiper('.home_slider', {
        pagination: '.home_slider .swiper-pagination',
        paginationClickable: true,
        prevButton: '.home_slider .custom_prev',
        nextButton: '.home_slider .custom_next'
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
.bind('orientationchange resize', function(){
    'use strict';
    }).resizeEnd(function(){
    'use strict';
});