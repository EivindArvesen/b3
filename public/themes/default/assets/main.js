// Custom JS here

// Make img captions from alt text
var src = [];
var imgs = document.images;
for (var i=0, iLen=imgs.length; i<iLen; i++) {
    if (imgs[i].alt != '') {
        imgs[i].outerHTML+= '<span class="img-caption">' + imgs[i].alt + '</span';
    };
}
