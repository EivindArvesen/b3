// jQuery
window.$ = window.jQuery = require('jquery')
//var $ = require('jquery');
//window.$ = $;

// Bootstrap
require('bootstrap');

//IE10 viewport hack for Surface/desktop Windows 8 bug
require("./ie10-viewport-bug-workaround.js");

// Highlight.js
var hljs = require("highlight.js");
hljs.initHighlightingOnLoad();

/*
        Custom JS here
 */

// Make img captions from alt text
var src = [];
var imgs = document.images;
for (var i=0, iLen=imgs.length; i<iLen; i++) {
    if (imgs[i].alt != '') {
        imgs[i].outerHTML+= '<span class="img-caption">' + imgs[i].alt + '</span';
    };
}
