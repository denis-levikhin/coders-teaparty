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
  wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ));
  
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
