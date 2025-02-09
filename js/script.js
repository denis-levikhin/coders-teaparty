function toggleCommentFormVisible(){
    jQuery(".comment-form-switch .status").text("(hide comment form)");
    jQuery("#commentform").removeClass( "comment-form-hidden" ).addClass( "comment-form-visible" );
}

function toggleCommentFormHidden(){
    jQuery(".comment-form-switch .status").text("(show comment form)");
    jQuery("#commentform").removeClass( "comment-form-visible" ).addClass( "comment-form-hidden" );
}

jQuery(".comment-form-switch").on("click", function(e){
	e.preventDefault();
    var commentform = jQuery("#commentform");
    if(commentform.hasClass("comment-form-visible")) {
        toggleCommentFormHidden();
    } else if(commentform.hasClass("comment-form-hidden")) {
        toggleCommentFormVisible();
    }
});

jQuery(".comment-reply-link").on("click", function(e){
	e.preventDefault();
    var commentform = jQuery("#commentform");
    if(commentform.hasClass("comment-form-hidden")) {
        toggleCommentFormVisible();
    }
    var offset = jQuery(".comments-area").offset();
    jQuery('html, body').animate({
        scrollTop: offset.top - 40, // 40 is height of WPAdmin bar when logged in
    }, 1000);
});

