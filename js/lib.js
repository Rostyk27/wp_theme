/*jslint browser: true, white: true, vars: true, plusplus: true, regexp: true, indent: 4, maxerr: 50 */
/*global $, jQuery*/

function aload(nodes) {
    'use strict';
    nodes = nodes || window.document.querySelectorAll('[data-aload]');
    if (nodes.length === undefined) {
        nodes = [nodes];
    }
    var i = 0,
        len = nodes.length,
        node;
    for (i; i < len; i += 1) {
        node = nodes[i];
        node[ node.tagName !== 'LINK' ? 'src' : 'href' ] = node.getAttribute('data-aload');
        node.removeAttribute('data-aload');
    }
    return nodes;
}
window.onload = function () {
    'use strict';
    aload();
};

var hash = window.location.hash,
    supportsTouch = window.hasOwnProperty('ontouchstart') || window.navigator.msPointerEnabled ? true : false,
    TouchClickEvent = supportsTouch ? 'touchstart' : 'click';

/*
 equalHeight
 usage: equalHeight('selector');
 */
function equalHeight(group) {
    'use strict';
    var tallest = 0;
    $(group).height('').each(function() {
        var thisHeight = $(this).outerHeight();
        if(thisHeight > tallest) {
            tallest = thisHeight;
        }
    });
    $(group).height(tallest);
}

//return document
function screen(method){
    'use strict';
    if(method === 'height') {
        method = window.innerHeight || document.documentElement.clientHeight;
    } else if(method === 'width') {
        method = document.body.offsetWidth;
    } else {
        method = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    }
    return method;
}

//selbel
(function($) {
    'use strict';
    var select = {};
    var defaults = {
        onChange: function () {}
    };
    $.fn.selbel = function(options) {

        if (this.length > 1) {
            this.each(function () {
                $(this).selbel(options);
            });
            return this;
        }
        var el = this;
        var init = function(){

            select.settings = $.extend({}, defaults, options);

            var sel_label = el.attr("data-label") !== undefined ? '<label>' + el.attr("data-label") + '</label>' : '';
            if (!el.hasClass('selbel')) { el.addClass('selbel'); }
            if(el.parent().is('.selbel_w')) { return false; }
            el.each(function() {
                $(this).wrap("<span class='selbel_w' />")
                    .before(select.label )
                    .after('<span>' + $('*:selected', this).text() + '</span>');
            });
            el.change(function() {
                $(this).next().text($('*:selected', this).text());
                select.settings.onChange( el );
            });
        };

        init();

        // returns the current jQuery object
        return this;
    };
}(jQuery));


//copyProtection
function doc_clipboard(event) {
    'use strict';
    var rows = window.getSelection().toString().split(/\n/), r, i, j;
    for (r = 0; r < rows.length; r+=1) {
        var words = rows[r].split(/\s/);
        for (i = 0; i < words.length; i++) {
            if (words[i].length > 6) {
                words[i] = words[i].split("");
                for (j = 2; j < words[i].length - 2; j += 2) {
                    var tmp = words[i][j];
                    words[i][j] = words[i][j + 1];
                    words[i][j + 1] = tmp;
                }
                words[i] = words[i].join("");
            }
        }
        rows[r] = words.join(" ");
    }
    event.preventDefault();
    event.clipboardData.setData("text", rows.join("\n"));
}

(function($) {
    'use strict';
//protect buffer copy
    $.fn.nocopy = function() {
        return this.each(function () {
            var el = $(this);
            el.attr('oncopy', 'doc_clipboard(event)');
        });
    };

//cssClassChanged trigger
    var originalAddClassMethod = jQuery.fn.addClass;
    jQuery.fn.addClass = function(){
        var result = originalAddClassMethod.apply( this, arguments );
        jQuery(this).trigger('cssClassChanged');
        return result;
    };

//EventSelector
    jQuery.fn.addEvent = function(type, handler) {
        this.bind(type, {'selector': this.selector}, handler);
    };

//find empty paragraphs
    $('p').each(function() {
        var t = $(this);
        if(t.html().replace(/\s|&nbsp;/g, '').length === 0) { t.addClass('jEmpty'); }
    });
}(jQuery));

function load_defer_img(source) {
    'use strict';
    return $.Deferred (function (task) {
        var image = new Image();
        image.onload = function () {task.resolve(image);};
        image.onerror = function () {task.reject();};
        image.src=source;
    }).promise();
}

var loadlater = (function () {
    'use strict';
    $('[data-defer]').each(function(){
        var t = $(this),
            pre = t.data('pre'),
            img = t.data('defer');
        $.when(load_defer_img(img)).done(function (image) {
            t.removeAttr('data-defer');
            if(t.is('img')) {
                t.prop('src', img);
            } else {
                if(typeof pre !== 'undefined') {
                    t.prepend(image);
                } else {
                    t.append(image);
                }
            }
        });
    });
}());