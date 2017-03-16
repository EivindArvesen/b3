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


// Process
var iframes = document.getElementsByTagName("iframe");
for (var i = 0; i < iframes.length; i++) {

    var host = /[^\/]*/.exec(iframes[i].getAttribute('src').replace(/(^\w+:|^)\/\//, '').replace('www.', ''))[0];

    if (host == 'youtube.com') {
        var replacement = document.createElement("div");
        replacement.setAttribute('class', 'embed');
        replacement.setAttribute('data-embed', iframes[i].getAttribute('src').substr(iframes[i].getAttribute('src').lastIndexOf('/') + 1));
        replacement.setAttribute('data-host', /[^\/]*/.exec(iframes[i].getAttribute('src').replace(/(^\w+:|^)\/\//, '').replace('www.', ''))[0]);
    } else {

    }

    var replacement = document.createElement("div");
    replacement.setAttribute('class', 'embed');
    replacement.setAttribute('data-embed', iframes[i].getAttribute('src').substr(iframes[i].getAttribute('src').lastIndexOf('/') + 1));
    replacement.setAttribute('data-host', /[^\/]*/.exec(iframes[i].getAttribute('src').replace(/(^\w+:|^)\/\//, '').replace('www.', ''))[0]);

    var btn = document.createElement('div');
    btn.setAttribute('class', 'play-button');
    replacement.appendChild(btn);

    iframes[i].parentNode.replaceChild(replacement, iframes[i]);
}

// Lazy load embeds
var embeds = document.querySelectorAll(".embed");

for (var i = 0; i < embeds.length; i++) {

    if (embeds[i].dataset.host == 'youtube.com') {
        // thumbnail image source
        var source = "https://img.youtube.com/vi/"+ embeds[i].dataset.embed+"/sddefault.jpg";

        // Load the image asynchronously
        var image = new Image();
        image.src = source;
        image.addEventListener( "load", function() {
            embeds[ i ].appendChild( image );
        }( i ) );

        embeds[i].addEventListener( "click", function() {

            var iframe = document.createElement( "iframe" );

                iframe.setAttribute( "frameborder", "0" );
                iframe.setAttribute( "allowfullscreen", "" );
                iframe.setAttribute( "src", "https://www.youtube.com/embed/"+ this.dataset.embed +"?rel=0&showinfo=0&autoplay=1" );

                this.innerHTML = "";
                this.appendChild( iframe );
        } );
    }
}
