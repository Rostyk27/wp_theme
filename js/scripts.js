/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/

$(document).ready(function() {
    'use strict';

    // hamburger + menu
    $('.nav_icon').on('click', function() {
        $(this).toggleClass('is_active').next().stop().toggleClass('is_open');
        $('body').toggleClass('is_overflow');
    });
    // append "plus" element in sub-menu parent item
    // $('#menu .menu-item-has-children > a').after('<span />');
    // $('#menu').on('click', '.menu-item-has-children > a + span', function() {
    //     $(this).toggleClass('is_open').next().stop().toggle().parent().toggleClass('is_active');
    // });


    // contact form 7
    $(this).on('click', '.wpcf7-not-valid-tip', function() {
        $(this).prev().trigger('focus');
        $(this).fadeOut(250,function(){
            $(this).remove();
        });
        $(this).parents('.wpcf7-form').find('.wpcf7-response-output').hide();
    });
    // active class for input parent
    // $(this).on('focus', '.wpcf7-form-control:not([type="submit"])', function() {
    //     $(this).parent().addClass('is_active');
    // });
    // $(this).on('blur', '.wpcf7-form-control:not([type="submit"])', function() {
    //     if($(this).val() !== "") {
    //         $(this).parent().addClass('is_active');
    //     } else {
    //         $(this).parent().removeClass('is_active');
    //     }
    // });


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
    $.fancybox.defaults.smallBtn = false;
    $.fancybox.defaults.backFocus = false;
    // $.fancybox.defaults.autoFocus = false;

    $('[data-fancybox]').fancybox({
        afterLoad: function( instance, slide ) {
            // fix if header is sticky
            $('header').addClass('compensate-for-scrollbar');
        },
        afterClose: function( instance, slide ) {
            // fix if header is sticky
            $('header').removeClass('compensate-for-scrollbar');
        }
    });

    // add body class on event
    $('.search_toggle').on('click', function () {
        $('body').addClass('is_searching');
    });


    // animations
    // AOS.init({
        // disable: true,
        // disable: 'mobile',
        // once: true,
        // offset: 150,
        // duration: 600,
        // easing: 'ease-in-out'
    // });


    // scroll to
    // $('html, body').animate({
    //     scrollTop: $(elem).offset().top - $('header').outerHeight()
    // }, 700);


    // block - accordion
    $('.acc_title').on('click', function () {
        $(this).toggleClass('is_open').next().toggle();
        $(this).find('.circle_arrow').toggleClass('is_up').toggleClass('is_down');
    });


    // wrap tables for responsive design
    if($('table').length > 0) {
        $('table').wrap('<div class="table_wrapper"></div>');
    }
    
});



$(window).on('load', function() {
    'use strict';

    // swiper - block__custom_slider
    $('.block__custom_slider').each(function () {
        var block__custom_slider = $(this),
            swiper_container = block__custom_slider.find('.swiper-container'),
            next = block__custom_slider.find('.sw_next'),
            prev = block__custom_slider.find('.sw_prev'),
            pagination = block__custom_slider.find('.sw_pagination');

        var slider = new Swiper(swiper_container[0], {
            navigation: {
                nextEl: next[0],
                prevEl: prev[0]
            },
            pagination: {
                el: pagination[0],
                type: 'bullets',
                clickable: true
            },
            loop: true,
            speed: 700,
            initialSlide: 1,
            spaceBetween: 10,
            centeredSlides: true,
            slidesPerView: 'auto',
            breakpoints: {
                768: {
                    spaceBetween: 20
                },
                1025: {
                    spaceBetween: 30
                }
            }
        });
    });


    // custom class for video in content (iframe)
    $('.content iframe').each(function(i) {
        var t = $(this),
            p = t.parent();
        if ( (p.is('p') || p.is('span') ) && !p.hasClass('full_frame')) {
            p.addClass('full_frame');
        }
    });

});



// close on click outside
// $(document).on('mouseup', function(e) {
//     var menu = $('#menu');
//
//     if (!menu.is(e.target) && !$('.nav_icon.is_active').is(e.target) && menu.has(e.target).length === 0 && menu.hasClass('is_open')) {
//         $('.nav_icon.is_active').click();
//     }
// });



// proper resize event
// $(window).resizeEnd(function() {
//     'use strict';
//
// });