/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/

$(document).ready(function() {
    'use strict';

    //  hamburger + menu
    $(".nav_icon").click(function() {
        $(this).toggleClass('is_active').next().stop().toggleClass('is_open');
        return false;
    });
    $('#menu .menu-item-has-children > a').after('<span />');
    $('#menu').on('click', '.menu-item-has-children > a + span', function() {
        $(this).toggleClass('open').next().stop().toggle().parent().toggleClass('is_active');
    });


    //  contact form 7
    $(this).on('click', '.wpcf7-not-valid-tip', function() {
        $(this).prev().trigger('focus');
        $(this).fadeOut(500,function(){
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
    $(this).on( 'keyup', 'textarea', function() {
        $(this).height( 0 );
        $(this).height( this.scrollHeight );
    });


    //  apps
    // $('[data-fancybox]').fancybox({
    //     smallBtn : false
    // });
    
    // $('select').selectric({
    //     disableOnMobile: false,
    //     nativeOnMobile: false,
    //     arrowButtonMarkup: ""
    // });


    //  custom
});



$(window).on('load', function() {
    'use strict';

    //  apps
    // setTimeout(function() {
    //     var home_slider = new Swiper('.home_slider', {
    //         pagination: '.home_slider .swiper-pagination',
    //         paginationClickable: true,
    //         prevButton: '.home_slider .custom_prev',
    //         nextButton: '.home_slider .custom_next'
    //     });
    // }, 500);


    //  fluid video (iframe)
    $('.content iframe').each(function(i) {
        var t = $(this),
            p = t.parent();
        if (p.is('p') && !p.hasClass('fullframe')) {
            p.addClass('fullframe');
        }
    });
    $('.wp-video').each(function() {
        $('.mejs-video .mejs-inner', this).addClass('fullframe');
    });

});



$(window).resizeEnd(function() {
    'use strict';
    console.log("I'm resized!");
});