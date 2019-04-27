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


// Process embeds
var iframes = $("iframe");
for (var i = 0; i < iframes.length; i++) {

    var id, host, url, height, width, style, size = undefined;
    host = /[^\/]*/.exec(iframes[i].getAttribute('src').replace(/(^\w+:|^)\/\//, '').replace('www.', ''))[0];
    url = iframes[i].getAttribute('src')
    height = iframes[i].getAttribute('height');
    width = iframes[i].getAttribute('width');
    style = iframes[i].getAttribute('style');

    if (iframes[i].getAttribute('width') && iframes[i].getAttribute('height')) {
        size = "width: " + iframes[i].getAttribute('width') + "px; height: " + iframes[i].getAttribute('height') + "px;";
    } else {
        size = style;
    }

    if (host == 'youtube.com' || host == 'youtube-nocookie.com') {
        id = iframes[i].getAttribute('src').substr(iframes[i].getAttribute('src').lastIndexOf('/') + 1);
    }

    var replacement = document.createElement("div");
    replacement.setAttribute('class', 'embed');
    replacement.setAttribute('data-id', id);
    replacement.setAttribute('data-host', host);
    replacement.setAttribute('data-url', url);
    replacement.setAttribute('data-height', height);
    replacement.setAttribute('data-width', width);
    replacement.setAttribute('data-style', style);
    replacement.setAttribute('style', size);
    replacement.setAttribute('allow', 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture');

    if (host == 'youtube.com' || host == 'youtube-nocookie.com') {
        var btn = document.createElement('div');
        btn.setAttribute('class', 'play-button');
        replacement.appendChild(btn);
    }

    iframes[i].parentNode.replaceChild(replacement, iframes[i]);
}

// Lazy load embeds
var embeds = document.querySelectorAll(".embed");

for (var i = 0; i < embeds.length; i++) {

    var host = embeds[i].dataset.host;

    var source = undefined;

    if (host == 'youtube.com' || host == 'youtube-nocookie.com') {
        // Load the image asynchronously
        var image = new Image();
        image.src = "https://img.youtube.com/vi/"+ embeds[i].dataset.id+"/sddefault.jpg";
        image.addEventListener( "load", function() {
            embeds[ i ].appendChild( image );
        }( i ) );
        //image.setAttribute('style', " padding-top: 56.25%;");
    } else {
        var message = document.createElement( "div" );
        message.setAttribute('class', 'message');
        message.innerHTML = "<p>Click to load content from <strong>" + embeds[i].dataset.host + "</strong></p><span class='glyphicon glyphicon-repeat'></span>";
        embeds[i].appendChild(message);
    }

    embeds[i].addEventListener( "click", function() {

        var src = undefined;
        var host = this.dataset.host;

        if (host == 'youtube.com') {
            src = "https://www.youtube.com/embed/"+ this.dataset.id +"?rel=0&showinfo=0&autoplay=1";
        } else {
            src = this.dataset.url;
        }

        var iframe = document.createElement( "iframe" );

        iframe.setAttribute( "frameborder", "0" );
        iframe.setAttribute( "allowfullscreen", "" );
        iframe.setAttribute( "allowtransparency", "true");
        iframe.setAttribute( "src", src );
        iframe.setAttribute( "height", this.dataset.height);
        iframe.setAttribute( "width", this.dataset.width);
        iframe.setAttribute( "style", this.dataset.style);

        this.parentNode.replaceChild(iframe, this);
    } );
}
