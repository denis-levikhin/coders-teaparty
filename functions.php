<?php

// === organize nav menus === //
function add_theme_menu_support() {
    register_nav_menus(
      array(
        'main-header-menu' => __( 'Main Website Menu (Header)' )
      )
    );
  }
add_action( 'init', 'add_theme_menu_support' );

function adjust_menu_widget_args($nav_menu_args, $nav_menu, $args){
    if( $args['id'] === 'primary' ) { // < This is where we check if it's the right widget
		return array_merge( $nav_menu_args, array(
			'menu_class' => 'website-main-navigation ignore-visited',
	   ) );
	}
}
add_filter("widget_nav_menu_args", "adjust_menu_widget_args", 10, 3);

// === end organize menus === //

function codersteaparty_enqueue_scripts_and_styles() {
  wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ), false, array('strategy' => 'defer'));
  
	wp_enqueue_style( 'sidebar', get_template_directory_uri() . "/css/sidebar.css" );
}
add_action( 'wp_enqueue_scripts', 'codersteaparty_enqueue_scripts_and_styles' );

function codersteaparty_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'codersteaparty' ),
		'id'            => 'primary',
		'before_widget' => '<div class="sidebar_widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'codersteaparty_widgets_init' );

// === customize comments === //

function codersteaparty_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	  	<div id="comment-<?php comment_ID(); ?>">
	  		<div class="avatar-wrapper">
				<?php echo get_avatar( $comment, 64 ); ?>
			</div>
		   
			<div class="comment-text-wrapper">
				<div class="comment-meta-wrapper">	
					<?php 
						$comment_date = get_comment_date('M. jS, o');
						printf(__('By <span class="comment-meta comment-author">%s</span>'), get_comment_author());
						echo (__(" on <span class='comment-meta comment-date'>$comment_date</span>"));
					?>
				</div>
				<div class="comment-moderation">
					<?php if ($comment->comment_approved == '0') : ?>
						<p><?php _e('Your comment is awaiting moderation.') ?></p>
					<?php endif; ?>
				</div>
				<div class="user-comment">
					<?php comment_text() ?>
				</div>
				<div class="comment-action-links">
					<span class="reply-link">
						<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					</span>
					<span class="edit-link">
						<?php edit_comment_link(__('Edit comment'),'  ','') ?>
					</span>
				</div>
		   </div>
	  </div>
 <?php } 

 // === === === === === === === //
