<?php

function add_theme_menu_support() {
    register_nav_menus(
      array(
        'header-menu-left' => __( 'Header Menu Left' ),
        'header-menu-right' => __( 'Header Menu Right' )
      )
    );
  }
add_action( 'init', 'add_theme_menu_support' );
