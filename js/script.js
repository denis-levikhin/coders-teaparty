jQuery(window).on("load resize", function() {
    var headerHeight = jQuery(".website-header").height();
    jQuery(document.documentElement).css('--header-height', headerHeight + 'px')
});