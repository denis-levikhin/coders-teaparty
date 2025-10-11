<?php 

// >>> Remove user profile fields not fitting the website theme or bloat
if( ! function_exists( 'ct_remove_fields_from_userprofile' ) ) {
    function ct_remove_fields_from_userprofile(){
        echo "<style>
                .user-first-name-wrap,
                .user-admin-color-wrap,
                .user-display-name-wrap,
                .user-url-wrap,
                .user-profile-picture,
                .user-last-name-wrap,
				#simple-local-avatar-section .ratings-row { 
                    display: none; 
                }
            </style>";
    }

    add_action( 'admin_head-user-edit.php', 'ct_remove_fields_from_userprofile' );
    add_action( 'admin_head-profile.php',   'ct_remove_fields_from_userprofile' );
}

// >>> Remove the color picker from the user profile admin page to declutter it
if( ! function_exists( 'ct_remove_admin_color_scheme_picker' ) ){
    function ct_remove_admin_color_scheme_picker() {
        remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
    }

    add_action( 'admin_head-profile.php', 'ct_remove_admin_color_scheme_picker' );
}

// >>> Register user profiles as custom post type to allow editing it from admin
if( ! function_exists( 'ct_register_user_profiles_post_type' ) ) {
	function ct_register_user_profiles_post_type(){
		register_post_type( 
			'ct-user-profile', 
			array(
				'label' => 'User Profiles',
				'description' => 'Auto-generated user profile pages, contains only meta to pull the data from WordPress user profile pages',
				'public' => TRUE,
				'has_archive' => 'dudes',
				'supports' => array(
					'title', 
					'editor',
					'thumbnail'					
				),
				'rewrite' => array(
					'slug' => 'dudes',
					'with_front' => FALSE,
				),        
				'menu_icon' => 'dashicons-id',
			) 
		);
	}

    add_action( 'init', 'ct_register_user_profiles_post_type' );
}


// >>> Create new front-end profile page when new user is created
if( ! function_exists( 'ct_create_user_profile_with_user' ) ){
	function ct_create_user_profile_with_user( $user_id, $userdata ) {
		$postarr = array(
			'post_title' => $userdata['first_name'] ?: $userdata['user_login'],
			'post_content' => '[user_profile_general][user_profile_picture][user_profile_latest_articles][user_profile_survey]',
			'post_status' => 'publish',
			'post_type' => 'ct-user-profile',
			'meta_input' => array(
				'profile_user_id' => $user_id
			),
		);
		wp_insert_post( $postarr );
	}

    add_action( 'user_register', 'ct_create_user_profile_with_user', 10, 2 );
} 

// >>> Delete user profile page if a user with the same username deleted
if( ! function_exists( 'ct_remove_user_profile_with_user' ) ){
	function ct_delete_user_profile_with_user( $user_id ) {
		$query_args = array(
			'post_type' => 'ct-user-profile',
			'meta_key' => 'profile_user_id',
			'meta_value' => $user_id,
			'no_found_rows' => TRUE, /* skip counting rows for performance */
		);
		$query = new WP_Query( $query_args );
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				wp_delete_post( get_the_ID() );
			}
		} 
		wp_reset_postdata();
	}

    add_action( 'delete_user', 'ct_delete_user_profile_with_user', 10, 2 );
}

// >>> Prevent article markup for user profiles 
if( ! function_exists( 'ct_disable_article_markup_for_profiles' ) ){ 
	function ct_disable_article_markup_for_profiles(){
		if( is_singular( 'ct-user-profile' ) ) {
			remove_filter( 'the_content', 'wpautop' );
		}
	}

	add_action( 'template_redirect', 'ct_disable_article_markup_for_profiles' );
}

/**
 * >>> Get user profile front end url
 * @return string user profile url or FALSE
*/
if( ! function_exists( 'ct_get_user_profile_page_url' ) ){ 
	function ct_get_user_profile_page_url( $user_id ){
		if ( empty( $user_id ) OR $user_id < 0 ) {
			return -1;
		}
		$args = array(
			'post_type' => 'ct-user-profile',
			'post_status' => 'publish',
			'meta_key' => 'profile_user_id',
			'meta_value' => $user_id,
		);
		$query = new WP_Query( $args );
		if ( ! empty( $query->posts )  ) {
        	return get_permalink( $query->posts[0] ); // only count for the first post
        } else {
			return FALSE;
		}
	}
}
