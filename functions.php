<?php

require_once get_stylesheet_directory() . '/includes/functions.php';
require_once get_stylesheet_directory() . '/includes/functions-user-profiles.php';
require_once get_stylesheet_directory() . '/shortcodes/user-profiles.php';

/**
 * General theme functions, admin menus and configuration.
 * Add your reusable functions not related to theme configuration to /includes/functions.php
 * 
 * Also, I wish all mom's sofa-based hackers to suck a humongous russian dick
*/

// >> Indicate supported features
add_theme_support( 'post-thumbnails' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

// === organize nav menus === //
function add_theme_menu_support() {
    register_nav_menus(
      array(
        'main-header-menu' => __( 'Main Website Menu (Header)' , 'coders-teaparty' )
      )
    );
  }
add_action( 'init', 'add_theme_menu_support' );

function adjust_menu_widget_args($nav_menu_args, $nav_menu, $args){
    if( $args['id'] === 'primary' ) { // < This is where we check if it's the right widget
		return array_merge( $nav_menu_args, array(
			'menu_class' => 'website-main-navigation ignore-visited',
			'theme_location' => 'main-header-menu',
	   ) );
	}
}
add_filter("widget_nav_menu_args", "adjust_menu_widget_args", 10, 3);

// === end organize menus === //

// >>> Register and Enqueue theme styles and scripts

add_action('init', 'register_custom_scripts_nstyles');
function register_custom_scripts_nstyles() {
    wp_register_style( 'comments', get_stylesheet_directory_uri() . "/css/comments.css" );
    wp_register_style( 'microblog_styles', get_stylesheet_directory_uri() . "/css/microblog.css" );
    wp_register_style( 'user_profile_styles', get_stylesheet_directory_uri() . "/css/user-profiles.css" );
}

// TODO: minify CSS
function codersteaparty_enqueue_scripts_and_styles() {
	// Enqueue these on EVERY page of the website
	wp_enqueue_style(  'style',   get_stylesheet_directory_uri() . '/style.css' );
  	wp_enqueue_script( 'script',  get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ), FALSE, array('strategy' => 'defer'));

  	wp_enqueue_script( 'tweenmax', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js', array(), FALSE, array('strategy' => 'async'));
  	wp_enqueue_script( 'starry-sky',  get_stylesheet_directory_uri() . '/js/starry-sky.js', array( 'tweenmax' ), FALSE, array('strategy' => 'defer', 'in_footer' => TRUE ));

	wp_enqueue_style(  'sidebar', get_stylesheet_directory_uri() . '/css/sidebar.css' );

	// Masonry Grid
	wp_enqueue_style(  'masonry-css', get_stylesheet_directory_uri() . '/css/masonry.css' );
  	wp_enqueue_script( 'imagesloaded-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.1/imagesloaded.pkgd.min.js', array(), FALSE, array('strategy' => 'async'));
  	wp_enqueue_script( 'masonry-js',  get_stylesheet_directory_uri() . '/js/masonry.js', array( 'imagesloaded-js' ), FALSE, array('strategy' => 'defer', 'in_footer' => TRUE ));

    if ( is_singular( 'post' ) ) {
		wp_enqueue_style( 'comments' );
	}

  	if ( is_archive( 'microblog' ) ) {
		wp_enqueue_style( 'microblog_styles' );
  	}
	
	if ( is_singular( 'ct-user-profile' ) ) {
		wp_enqueue_style( 'user_profile_styles' );
  	}
	
	if ( is_admin() AND ! wp_doing_ajax() ) {
		wp_enqueue_media();
	}
}
add_action( 'wp_enqueue_scripts', 'codersteaparty_enqueue_scripts_and_styles' );


// >>> Widgets setup

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

// >>> Custom comments function to generate markup
// TOOD: move this to a separate functions file (?)

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

// >>> Disable Microblog single pages but leave archives 
add_filter( 'is_post_type_viewable', function( $is_viewable, $post_type ) {
    if ( 'microblog' === $post_type->name ) {
        return false;
    }
    return $is_viewable;
}, 10, 2 );

remove_rewrite_tag( '%microblog%' );
add_action( 'after_switch_theme', 'flush_rewrite_rules' );

if( ! function_exists( 'ct_hilight_active_menu_item' ) ) {
	function ct_hilight_active_menu_item( $classes, $item, $args ) {
		$server_url = urldecode( $_SERVER['REQUEST_URI'] );
		$server_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$server_url}";

		if ( 'main-header-menu' === $args->theme_location AND str_contains( $server_url,$item->url ) ) {
			$classes[] = "selected";
		}

		return $classes;
	}
	add_filter( 'nav_menu_css_class' , 'ct_hilight_active_menu_item' , 10, 4 );
}

// >>> Add menu descriptions
add_filter( 'nav_menu_item_title', 'ct_add_nav_menu_description', 10, 4 );

if ( ! function_exists( 'ct_add_nav_menu_description' ) ) {
	function ct_add_nav_menu_description( $item_output, $menu_item_obj, $depth, $args ){
		if ( ! empty( $menu_item_obj->description ) ) {
			$item_output .= '<br /><span class="menu-item-description">' . $menu_item_obj->description . '</span>';
		}
		return $item_output;
	}
}

// >>> Set default featured image
function set_default_featured_image( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    if ( empty( $post_thumbnail_id ) ) {
        $default_image_url = get_stylesheet_directory_uri() . '/media/no-image3.png';
        $html = '<img src="' . esc_url( $default_image_url ) . '" class="wp-post-image" alt="Default Image"/>';
    }
    return $html;
}
add_filter( 'post_thumbnail_html', 'set_default_featured_image', 10, 5 );
 
function set_default_featured_image_url( $url, $post_id ) {
    if ( empty( get_post_thumbnail_id( $post_id ) ) ) {
        $url = get_stylesheet_directory_uri() . '/media/no-image3.png';
    }
    return $url;
}
add_filter( 'default_post_thumbnail_url', 'set_default_featured_image_url', 10, 2 );

// >>> Filter the default except length to 20 words
function set_default_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'set_default_excerpt_length', 999 );
