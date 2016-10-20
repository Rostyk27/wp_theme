/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/

(function(window) {
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

    $('.ripple').on('click', function (event) {

        var $div = $('<div/>'),
            btnOffset = $(this).offset(),
            xPos = event.pageX - btnOffset.left,
            yPos = event.pageY - btnOffset.top;

        $div.addClass('ripple-effect');
        var $ripple = $(".ripple-effect");

        $ripple.css("height", $(this).height());
        $ripple.css("width", $(this).height());
        $div
            .css({
                top: yPos - ($ripple.height()/2),
                left: xPos - ($ripple.width()/2),
                background: $(this).data("ripple-color")
            })
            .appendTo($(this));

        window.setTimeout(function(){
            $div.remove();
        }, 1000);
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
.bind('orientationchange resize', function() {
    window.console.log('resize');
}).resizeEnd(function(){
    window.console.log('resizeEnd');
});
}(window, jQuery));