<?php
/*
* DEV NOTICE: Do not edit these functions, use filters from child theme to edit
* specific user profiles, leave these functions "framework-type"
*/

if( ! function_exists( 'ct_user_profile_general_info' ) ) {
    add_shortcode( 'user_profile_general', 'ct_user_profile_general_info' );
    function ct_user_profile_general_info( $atts, $content, $shortcode_tag ) {
        $output = '';
        $classes = 'user-profile-block user-profile-general-info';

        if( get_post_type( get_the_id() ) !== 'ct-user-profile' ) {
            return '<p class="error-message">Invalid use of shortcode - this post is not a User Profile.</p>';
        }

        $profile_user_id = get_post_meta( get_the_id(), 'profile_user_id', TRUE ); 
        $user_obj = get_user_by( 'id', $profile_user_id );

        if ( $user_obj ) {
            $user_meta = get_user_meta( $user_obj->data->ID );
            $user_nicename = $user_meta['nickname'][0];
            $user_bio = $user_meta['description'][0];
            //$output .= var_export($user_meta, true);
            $user_position = $user_meta['position'][0];
            $user_cover_image_id = $user_meta['cover'][0];
            $user_cover_image_src = wp_get_attachment_image_src( $user_cover_image_id, 'large' );
            $user_cover_image_src_attr = !empty( $user_cover_image_src ) ? $user_cover_image_src[0] : '';

            if( empty( $user_bio ) ) {
                $user_bio = __( 'This user have not shared anything about themselves yet.', 'coders-teaparty' );
            }

            // Filter $classes via the child theme to customize specific users' profiles without commiting changes
            $output .= "<section class='" . apply_filters( 'ct_user_profile_block_classes', $classes, $shortcode_tag ) . "'>";
            if( !empty( $user_cover_image_src_attr ) ) {
                $output .= "<div class='user-profile-block-header with-cover' style='background: top / cover url(\"$user_cover_image_src_attr\")'>";
            } else {
                $output .= "<div class='user-profile-block-header'>";
            }
                    $output .= "<span>";
                        $output .= "<h3 class='user-name'>$user_nicename</h3>";
                        $output .= "<span class='user-position'>$user_position</span>";
                    $output .= '</span>';
                $output .= '</div>';

                $output .= '<div class="user-profile-block-content">';
                    $output .= '<h4>' . __( 'Bio:', 'coders-teaparty' ) . '</h4>';
                    $output .= "<div>$user_bio</div>";
                $output .= '</div>';
            $output .= '</section>';
        }

        return $output;
    }
}

if( ! function_exists( 'ct_user_profile_picture' ) ) {
    add_shortcode( 'user_profile_picture', 'ct_user_profile_picture' );
    function ct_user_profile_picture( $atts, $content, $shortcode_tag ) {
        
    }
}

if( ! function_exists( 'ct_user_profile_about_me' ) ){
    add_shortcode( 'user_profile_about_me', 'ct_user_profile_about_me' );
    function ct_user_profile_about_me( $atts, $content, $shortcode_tag ) {
        
    }
}

if( ! function_exists( 'ct_user_profile_latest_articles' ) ){
add_shortcode( 'user_profile_latest_articles', 'ct_user_profile_latest_articles' );
    function ct_user_profile_latest_articles( $atts, $content, $shortcode_tag ) {
        
    }
}