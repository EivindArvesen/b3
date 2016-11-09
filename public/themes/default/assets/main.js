// Custom JS here

// Capture scroll any percentage
$(window).scroll(function(){
var wintop = $(window).scrollTop(), docheight =

    $(document).height(), winheight = $(window).height();
            var scrolled = (wintop/(docheight-winheight))*100;

        $('.scroll-line').css('width', (scrolled + '%'));
});

// Make img captions from alt text
var src = [];
var imgs = document.images;
for (var i=0, iLen=imgs.length; i<iLen; i++) {
    if (imgs[i].alt != '') {
        imgs[i].outerHTML+= '<span class="img-caption">' + imgs[i].alt + '</span';
    };
}
