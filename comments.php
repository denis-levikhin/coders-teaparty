<?php

if ( post_password_required() ) {
	return;
}

?>

<div id="comments" class="comments-area">

	<?php comment_form( 
		array(
			"title_reply" => "What do you think?",
			"class_form" => "comment-form appearance-animation-fade comment-form-hidden"	
		) 
	); ?>

	<?php if (is_user_logged_in()): ?>
		<a class="comment-form-switch" href="#">Actually.. <span class="status">(show comment form)</span></a>
	<?php endif; ?>


	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				echo "Comments:";
			?>
		</h3>

		<ul class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ul',
				'short_ping'  => true,
				'avatar_size' => 64,
				'callback' => 'codersteaparty_comments'
			) );
			?>
		</ul><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="navigation comment-navigation" role="navigation">

				<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'codersteaparty' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'codersteaparty' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'codersteaparty' ) ); ?></div>
			</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'codersteaparty' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

</div><!-- #comments -->
