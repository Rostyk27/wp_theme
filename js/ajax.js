/*jslint browser: true, white: true, plusplus: true, regexp: true, indent: 4, maxerr: 50, es5: true */
/*jshint multistr: true, latedef: nofunc */
/*global jQuery, $, Swiper*/


// ajax posts - loading + filtering
function load_posts_ajax(paged, category) {
    if(!paged) {
        paged = 1;
    }

    var ajax_content = $('.posts_container');

    $.ajax({
        type: 'POST',
        url: $('body').data('a'),
        data: {
            action: 'load_posts_ajax',
            paged: paged,
            category: category
        },
        success: function (html) {
            if (paged !== 1) {
                $('.loader_holder').remove();
                ajax_content.append(html);
                $('.show_box').removeClass('is_loading');
            } else {
                $('.loader_holder').remove();
                ajax_content.html(html);
                $('.show_box').removeClass('is_loading');
            }
        }

    });

    return false;
}


$(document).ready(function () {
    'use strict';

    // ajax posts - filtering
    var posts_filters = $('.posts_filters a'),
        posts_dropdown = $('.posts_dropdown');

    // desktop
    posts_filters.on('click', function () {
        $(this).parents('.posts_filtering').find('.show_box').addClass('is_loading');

        var cat = $(this).attr('href');

        load_posts_ajax(1, cat);

        $('.posts_filters a').removeClass('is_filtered');
        $(this).addClass('is_filtered');

        window.location.hash = cat;

        return false;
    });
    // desktop - hash catch
    posts_filters.each(function() {
        var hash = $(this).attr('href');
        if (hash === window.location.hash) {
            $(this).click();
        }
    });

    // mobile
    posts_dropdown.on('change', function () {
        $(this).parents('.posts_filtering').find('.show_box').addClass('is_loading');

        var cat = $(this).val();

        load_posts_ajax(1, cat);

        window.location.hash = cat;
    });
    // mobile - hash catch
    posts_dropdown.find('option').each(function() {
        var hash = $(this).val();
        if (hash === window.location.hash) {
            var ti = $(this).index();
            posts_dropdown.prop('selectedIndex', ti).selectric('refresh');
        }
    });

    // ajax posts - page loading
    $(this).on('click', '.load_more_posts', function () {
        $(this).parent().next().find('.show_box').addClass('is_loading');

        var pg = $(this).attr('data-href'),
            cat = $(this).attr('data-cat');

        load_posts_ajax(pg === 1 ? 2 : pg, cat);

        $(this).parent().remove();

        return false;
    });

});