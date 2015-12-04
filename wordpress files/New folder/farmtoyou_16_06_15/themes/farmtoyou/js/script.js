jQuery(window).load(function ($) {
    jQuery('.header-slider').flexslider({
        animation: "slide",
        directionNav: false,
        smoothHeight: true
    });
    jQuery('.membership-slider').flexslider({
        animation: "slide",
        directionNav: false
    });
});


jQuery(document).ready(function ($) {
    $('a.menulinks').click(function () {
        $(this).next('ul').slideToggle(200);
    });
});