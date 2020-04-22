/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/

$(document).ready(function() {
    'use strict';

    // hamburger + menu
    $('.nav_icon').on('click', function() {
        $(this).toggleClass('is_active').next().stop().toggleClass('is_open');
        $('body').toggleClass('is_overflow');
        return false;
    });
    $('#menu .menu-item-has-children > a').after('<span />');
    $('#menu').on('click', '.menu-item-has-children > a + span', function() {
        $(this).toggleClass('is_open').next().stop().toggle().parent().toggleClass('is_active');
    });


    // contact form 7
    $(this).on('click', '.wpcf7-not-valid-tip', function() {
        $(this).prev().trigger('focus');
        $(this).fadeOut(250,function(){
            $(this).remove();
        });
    });
    $(this).on('focus', '.wpcf7-form-control:not([type="submit"])', function() {
        $(this).parent().addClass('is_active');
    });
    $(this).on('blur', '.wpcf7-form-control:not([type="submit"])', function() {
        if($(this).val() !== "") {
            $(this).parent().addClass('is_active');
        } else {
            $(this).parent().removeClass('is_active');
        }
    });


    // scroll to
    // $('html, body').animate({
    //     scrollTop: $(elem).offset().top - $('header').outerHeight()
    // }, 700);


    // custom select
    // $('select').selectric({
    //     disableOnMobile: false,
    //     nativeOnMobile: false,
    //     arrowButtonMarkup: '<span class="select_arrow"></span>'
    // });
    // $('select.wpcf7-form-control').each(function () {
    //     $(this).find('option').first().val('');
    // });


    // fancybox
    // $.fancybox.defaults.touch = false;
    // $.fancybox.defaults.smallBtn = false;
    // $.fancybox.defaults.autoFocus = false;

    // $('[data-fancybox]').fancybox({
    //     afterLoad: function( instance, slide ) {
    //         // fix if header is sticky
    //         $('header').addClass('compensate-for-scrollbar');
    //     },
    //     afterClose: function( instance, slide ) {
    //         // fix if header is sticky
    //         $('header').removeClass('compensate-for-scrollbar');
    //     }
    // });


    // animations
    // AOS.init({
        // disable: true,
        // disable: 'mobile',
        // once: true,
        // offset: 150,
        // duration: 600,
        // easing: 'ease-in-out'
    // });


    // custom code
    
});



$(window).on('load', function() {
    'use strict';

    // swiper
    // setTimeout(function() {
    //     var home_slider = new Swiper('.home_slider', {
    //         navigation: {
    //             nextEl: '.home_slider .sw_next',
    //             prevEl: '.home_slider .sw_prev'
    //         },
    //         pagination: {
    //             el: '.home_slider .sw_pagination',
    //             type: 'bullets',
    //             clickable: true
    //         },
    //         autoplay: {
    //             delay: 4000
    //         },
    //         speed: 1000,
    //         threshold: 30,
    //         touchEventsTarget : 'wrapper'
    //     });
    // }, 250);


    // fluid video (iframe)
    $('.content iframe').each(function(i) {
        var t = $(this),
            p = t.parent();
        if (p.is('p') && !p.hasClass('full_frame')) {
            p.addClass('full_frame');
        }
    });
    $('.wp-video').each(function() {
        $('.mejs-video .mejs-inner', this).addClass('full_frame');
    });

});



$(window).resizeEnd(function() {
    'use strict';
    
});