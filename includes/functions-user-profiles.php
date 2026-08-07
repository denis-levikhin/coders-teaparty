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
