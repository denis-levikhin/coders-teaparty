<?php 

// >>> Custom styles for admin user profile page
if( ! function_exists( 'ct_remove_fields_from_userprofile' ) ) {
    function ct_remove_fields_from_userprofile(){
        // Remove user profile fields not fitting the website theme or bloat
        echo "<style id='remove-bloat'>
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

        // Improve custom field visuals
        echo "<style id='custom-styling'>
                .wp-admin:not(.mobile) .acf-field.neat-linebreak { 
                    display: flex;
                    flex-direction: column;
                    & > td {
                        padding: 0 !important;
                        width: 40% !important;
                    }
                }
            </style>";

        // Hide fields in wrong language
        echo "<style id='language-specific-layout'>
                .wp-admin.pll-lang-en .acf-field[data-name$='-ru'],
                .wp-admin.pll-lang-ru .acf-field[data-name$='-en'],
                .wp-admin.pll-lang-en .user-description-wrap div[lang='ru-RU'],
                .wp-admin.pll-lang-ru .user-description-wrap div[lang='en-US'] { 
                    display: none;
                }
            </style>";
            
        // Hide editor-related fields for subscribers and members
        if ( ! current_user_can( 'edit_posts' ) ) {
            echo "<style id='language-specific-layout'>
                    .acf-field[data-name*='writing_preferences'],
                    .acf-field[data-name*='role'] { 
                        display: none !important;
                    }
                </style>";
        }
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

// >>> Add user profile link to profile editing screen to quickly view changes
if( ! function_exists( 'ct_profile_link' ) ){
    function ct_profile_link( $profile_user ) {
        $link = get_author_posts_url( $profile_user->ID, $profile_user->user_nicename );
        echo "<p><a href='$link' class='button' target='_blank'>" . __( 'View User Profile', 'coders-teaparty' ) . "</a></p>";
    }

    add_action( 'show_user_profile', 'ct_profile_link' );
    add_action( 'edit_user_profile', 'ct_profile_link' );
}


// >>> Change 'author' to 'user' in user profile URL
if( ! function_exists( 'ct_filter_author_link' ) ){

    function ct_filter_author_link( $link, $author_id, $author_nicename ) {
        $user_language = function_exists( 'pll_current_language') ? pll_current_language() : get_locale();
        $user_language = substr( $user_language, 0, 2 ) === "ru" ? '/ru': ''; // use user's preferred lang in link
        return home_url( "$user_language/user/" ) . $author_nicename;
    }

    add_filter( 'author_link', 'ct_filter_author_link', 10, 3 );
}

// >>> Change 'author' to 'user' in WP rewrite rules so it knows about new URLs
if( ! function_exists( 'ct_rewrite_filter_author_link' ) ){
    function ct_rewrite_filter_author_link() {
        global $wp_rewrite;
        $wp_rewrite->author_base = 'user';
    }
    add_action( 'init', 'ct_rewrite_filter_author_link' );
}
