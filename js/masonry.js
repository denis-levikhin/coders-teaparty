/* See https://medium.com/@andybarefoot/a-masonry-style-layout-using-css-grid-8c663d355ebb */

jQuery( window ).on( 'load', function() {
    function resizeGridItem( item ) {
        grid = document.getElementsByClassName( "masonry-grid" )[0];
        rowHeight = parseInt( window.getComputedStyle( grid ).getPropertyValue( 'grid-auto-rows' ) );
        rowGap = parseInt( window.getComputedStyle( grid ).getPropertyValue( 'grid-row-gap' ) );
        rowSpan = Math.ceil( ( item.querySelector( '.masonry-content' ).getBoundingClientRect().height + rowGap ) / ( rowHeight + rowGap ) );
        item.style.gridRowEnd = "span " + rowSpan;
        var test = jQuery( item ).find('.user-profile-block-header > span');
        if ( test.length ) {
            console.log( 'node:'+test.text() );
        }
    }

    function resizeAllGridItems() {
        allItems = document.getElementsByClassName( "masonry-item" );
        for ( x = 0; x < allItems.length; x++ ) {
            resizeGridItem( allItems[ x ] );
        }
    }

    function resizeInstance( instance ) {
        item = instance.elements[0];
        resizeGridItem( item );
    }

    resizeAllGridItems();
    window.addEventListener( "resize", resizeAllGridItems );

    allItems = document.getElementsByClassName( "masonry-item" );
    for ( x = 0; x < allItems.length; x++ ) {
        imagesLoaded( allItems[ x ], resizeInstance );
    }
});