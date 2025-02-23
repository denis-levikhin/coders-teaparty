! function( $ ) {
    $(".showmore-link").click(function () {
        var id_post = $(this).closest('.single-microblog-post').attr('data-ajax-id');
        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            data: {
                'post_id': id_post,
                'action': 'f711_get_post_content' //this is the name of the AJAX method called in WordPress
            }, success: function (result) {

            alert(result);
            },
            error: function () {
                alert("error");
            }
        });

    });
}( jQuery );
