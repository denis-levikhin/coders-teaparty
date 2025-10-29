(function($){
    function toggleCommentFormVisible(){
        $(".comment-form-switch .status").text("(hide comment form)");
        $("#commentform").removeClass( "comment-form-hidden" ).addClass( "comment-form-visible" );
    }

    function toggleCommentFormHidden(){
        $(".comment-form-switch .status").text("(show comment form)");
        $("#commentform").removeClass( "comment-form-visible" ).addClass( "comment-form-hidden" );
    }

    $(".comment-form-switch").on("click", function(e){
        e.preventDefault();
        var commentform = $("#commentform");
        if(commentform.hasClass("comment-form-visible")) {
            toggleCommentFormHidden();
        } else if(commentform.hasClass("comment-form-hidden")) {
            toggleCommentFormVisible();
        }
    });

    $(".comment-reply-link").on("click", function(e){
        e.preventDefault();
        var commentform = $("#commentform");
        if(commentform.hasClass("comment-form-hidden")) {
            toggleCommentFormVisible();
        }
        var offset = $(".comments-area").offset();
        $('html, body').animate({
            scrollTop: offset.top - 40, // 40 is height of WPAdmin bar when logged in
        }, 1000);
    });

    $(".mobile-menu-close-button, .mobile-menu-switch").on("click", function(){
        $(".sidebar").toggleClass("mobile-view-hidden");
    });

    function tooltipFollowsCoursor( event ) {
        const $tooltip = event.data.tooltipObject;
        const $postTagObject = event.data.postTagObject;
        if ( $tooltip != 'undefined' && $postTagObject != 'undefined' ) {
            $( $tooltip ).css({ left: event.pageX + 10, top:event.pageY + 15 });
        }
    }
    
    $( '.post-tags' ).on( 'mouseenter', '.post-tag', ( event ) => {
        const $postTag = $( event.target );
        const $tooltip = $( '#tag-' + $postTag.data('id') + '-description' );
        $tooltip.css( 'display', 'block' );
        $( document ).on( 'mousemove', { tooltipObject: $tooltip, postTagObject: $postTag }, tooltipFollowsCoursor );
    } );

    $( '.post-tags' ).on( 'mouseleave', '.post-tag', ( event ) => {
        const $postTag = $( event.target );
        const $tooltip = $( '#tag-' + $postTag.data('id') + '-description' );
        $tooltip.css( 'display', '' );
        $( document ).off( 'mousemove', tooltipFollowsCoursor );
    } );
})(jQuery);