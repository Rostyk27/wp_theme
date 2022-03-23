/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/


// control :focus when using mouse/keyboard
document.body.addEventListener('mousedown', function() {
    document.body.classList.add('is_using_mouse');
});
document.body.addEventListener('keydown', function() {
    document.body.classList.remove('is_using_mouse');
});


$(document).ready(function() {
    'use strict';

    // variables
    const body = $('body');
    const header = $('header');
    const menu__toggle = $('.menu__toggle');
    const menu__primary = $('.menu__primary');
    const menu__a_parent = menu__primary.find('.menu-item-has-children > a');


    // hamburger + menu
    menu__toggle.on('click', function() {
        $(this).toggleClass('is_active');
        menu__primary.stop().toggleClass('is_open');
        body.toggleClass('is_overflow');
    });
    // close menu with Esc key
    body.on('keyup', function (e) {
        if (e.keyCode === 27 && menu__toggle.hasClass('is_active')) {
            $('.menu__toggle.is_active').click();
            $('a[href="#skip_to_content"]').focus();
        }
    });
    // open/close sub-menu with Tab key
    menu__a_parent.on('focus', function () {
        $(this).parent().addClass('is_focused');
    });
    menu__primary.find('.sub-menu').each(function () {
        let sub_menu_links = $(this).find('> li > a');
        let last_sub_menu_link = sub_menu_links.last();
        last_sub_menu_link.on('blur', function () {
            $(this).parents('.menu-item-has-children').removeClass('is_focused');
        });
    });
    // option to make parent element hidden from screen readers
    // menu__a_parent.attr({
    //     'aria-hidden': 'true',
    //     'tabindex': -1
    // });
    // append "plus" element in sub-menu parent item
    menu__a_parent.after('<span class="rwd_show" tabindex="0" role="button" aria-label="Sub-menu toggle" aria-expanded="false" />');
    function sub_menu_action(elem) {
        let exp = elem.attr('aria-expanded');
        (exp === 'false') ? elem.attr('aria-expanded', 'true') : elem.attr('aria-expanded', 'false');
        elem.toggleClass('is_open').next().stop().toggle();
    }
    menu__primary.on('click', '[aria-label="Sub-menu toggle"]', function() {
        sub_menu_action($(this));
    }).on('keyup', '[aria-label="Sub-menu toggle"]', function (e) {
        if (e.keyCode === 13) {
            sub_menu_action($(this));
        }
    });


    // header
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 5) {
            header.addClass('is_sticky');
        } else {
            header.removeClass('is_sticky');
        }
    });
    if ($(this).scrollTop() > 4) header.addClass('is_sticky');


    // contact form 7
    $(this).on('click', '.wpcf7-not-valid-tip', function() {
        $(this).prev().trigger('focus');
        $(this).fadeOut(250,function(){
            $(this).remove();
        });
        $(this).parents('.wpcf7-form').find('.wpcf7-response-output').addClass('is_temp_hidden');
    });
    $(this).on('focus', '.wpcf7-form-control.wpcf7-not-valid', function() {
        $(this).next('.wpcf7-not-valid-tip').fadeOut(250,function(){
            $(this).remove();
        });
        $(this).parents('.wpcf7-form').find('.wpcf7-response-output').addClass('is_temp_hidden');
    });
    document.addEventListener( 'wpcf7submit', function( event ) {
        $('.wpcf7-response-output').removeClass('is_temp_hidden');
    }, false );


    // custom select
    if($('select').length > 0) {
        $('select').selectric({
            disableOnMobile: false,
            nativeOnMobile: false,
            arrowButtonMarkup: '<span class="select_arrow"></span>'
        });
        // $('select.wpcf7-form-control').each(function () {
        //     $(this).find('option').first().val('');
        // });
    }


    // fancybox
    $('[data-fancybox]').fancybox({
        touch: {
            vertical: false,
            momentum: true
        },
        smallBtn: false,
        beforeLoad: function( instance, slide ) {
            // fix if header is sticky
            header.addClass('compensate-for-scrollbar');
        },
        afterClose: function( instance, slide ) {
            // fix if header is sticky
            header.removeClass('compensate-for-scrollbar');
            // remove body class after event
            if (body.hasClass('is_searching')) {
                body.removeClass('is_searching');
            }
        }
    });


    // add body class on event
    $('.search_toggle').on('click', function () {
        body.addClass('is_searching');
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
    $('a[data-scrollto]').on('click', function () {
        let anchor = $(this).data('scrollto');

        if ($(anchor).length > 0) {
            $('html, body').animate({
                scrollTop: $(anchor).offset().top - header.outerHeight()
            }, 700);
        }
    });


    // block - accordion
    function acc_action(elem) {
        let exp = elem.attr('aria-expanded');
        let hid = elem.next().attr('aria-hidden');
        (exp === 'false') ? elem.attr('aria-expanded', 'true') : elem.attr('aria-expanded', 'false');
        (hid === 'true') ? elem.next().attr('aria-hidden', 'false') : elem.next().attr('aria-hidden', 'true');
        elem.toggleClass('is_open').next().toggle();
        elem.find('.circle_arrow').toggleClass('is_up').toggleClass('is_down');
    }
    $('.acc_title').on('click', function () {
        acc_action($(this));
    }).on('keyup', function (e) {
        if (e.keyCode === 13) {
            acc_action($(this));
        }
    });


    // wrap tables for responsive design
    if($('.content table').length > 0) {
        $('.content table').wrap('<div class="table_wrapper"></div>');
    }
    
});



$(window).on('load', function() {
    'use strict';

    // swiper - block__custom_slider
    $('.block__custom_slider').each(function () {
        let slider_holder = $(this),
            swiper_instance = slider_holder.find('.swiper'),
            next = slider_holder.find('.sw_next'),
            prev = slider_holder.find('.sw_prev'),
            pagination = slider_holder.find('.sw_pagination');

        let block_slider = new Swiper(swiper_instance[0], {
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
            speed: 600,
            grabCursor: true,
            effect: "creative",
            creativeEffect: {
                prev: {
                    translate: ["-20%", 0, -1],
                },
                next: {
                    translate: ["100%", 0, 0],
                },
            },
        });
    });


    // custom class for video in content (iframe)
    $('.content iframe').each(function(i) {
        let t = $(this),
            p = t.parent();
        if ( (p.is('p') || p.is('span') ) && !p.hasClass('full_frame')) {
            p.addClass('full_frame');
        }
    });

});



// close on click outside
// $(document).on('mouseup', function(e) {
//     let menu = $('.menu__primary');
//
//     if (!menu.is(e.target) && !$('.menu__toggle.is_active').is(e.target) && menu.has(e.target).length === 0 && menu.hasClass('is_open')) {
//         $('.menu__toggle.is_active').click();
//     }
// });



// proper resize event
// $(window).resizeEnd(function() {
//     'use strict';
//
// });