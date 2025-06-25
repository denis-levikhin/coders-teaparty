<?php
/*
* DEV NOTICE: Do not edit these functions, use filters from child theme to edit
* specific user profiles, leave these functions "framework-type"
*/

if( ! function_exists( 'ct_user_profile_general_info' ) ) {
    add_shortcode( 'user_profile_general', 'ct_user_profile_general_info' );
    function ct_user_profile_general_info( $atts, $content, $shortcode_tag ) {
        $output = '';
        $classes = 'user-profile-block user-profile-general-info masonry-item ';

        if( get_post_type( get_the_id() ) !== 'ct-user-profile' ) {
            return '<p class="error-message">Invalid use of shortcode - this post is not a User Profile.</p>';
        }

        $profile_user_id = get_post_meta( get_the_id(), 'profile_user_id', TRUE ); 
        $user_obj = get_user_by( 'id', $profile_user_id );

        if ( $user_obj ) {
            $user_meta = get_user_meta( $user_obj->data->ID );
            $user_nicename = $user_meta['nickname'][0];
            $user_bio = $user_meta['description'][0];
            $user_position = $user_meta['position'][0] ?: __( 'Dude', 'coders-teaparty' );
            $user_cover_image_id = $user_meta['cover'][0];
            $section_headers_color = $user_meta['section_headers_color'][0] ?: 'var(--secondary-color)';
            $user_cover_image_src = wp_get_attachment_image_src( $user_cover_image_id, 'large' );
            $user_cover_image_src_attr = !empty( $user_cover_image_src ) ? $user_cover_image_src[0] : '';

            if( empty( $user_bio ) ) {
                $user_bio = __( 'This user have not shared anything about themselves yet.', 'coders-teaparty' );
            }

            // Filter $classes via the child theme to customize specific users' profiles without commiting changes
            $output .= "<section class='" . apply_filters( 'ct_user_profile_block_classes', $classes, $shortcode_tag ) . "'>";
                $output .= '<div class="masonry-content">';
                if( !empty( $user_cover_image_src_attr ) ) {
                    $output .= "<div class='user-profile-block-header with-cover' style='background: top / cover url(\"$user_cover_image_src_attr\")'>";
                } else {
                    $header_style = " style='background: $section_headers_color;' ";
                    $output .= "<div class='user-profile-block-header' $header_style>";
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
                $output .= '</div>';
            $output .= '</section>';
        }

        return $output;
    }
}

if( ! function_exists( 'ct_user_profile_picture' ) ) {
    add_shortcode( 'user_profile_picture', 'ct_user_profile_picture' );
    function ct_user_profile_picture( $atts, $content, $shortcode_tag ) {
        $output = '';
        $classes = 'user-profile-block user-profile-picture masonry-item ';

        if( get_post_type( get_the_id() ) !== 'ct-user-profile' ) {
            return '<p class="error-message">Invalid use of shortcode - this post is not a User Profile.</p>';
        }

        $profile_user_id = get_post_meta( get_the_id(), 'profile_user_id', TRUE ); 
        $user_obj = get_user_by( 'id', $profile_user_id );

        if ( $user_obj ) {
            $user_meta = get_user_meta( $user_obj->data->ID );
            $user_status = $user_meta['status'][0];
            $no_picture_set = empty( get_avatar_data( $profile_user_id )['found_avatar'] );
            $section_headers_color = $user_meta['section_headers_color'][0] ?: 'var(--secondary-color)';

            if( $no_picture_set ) {
                $classes .= 'no-profile-picture ';
            }

            // Filter $classes via the child theme to customize specific users' profiles without commiting changes
            $output .= "<section class='" . apply_filters( 'ct_user_profile_block_classes', $classes, $shortcode_tag ) . "'>";
                $output .= '<div class="masonry-content">';
                    $header_style = " style='background: $section_headers_color;' ";
                    $output .= "<div class='user-profile-block-header' $header_style></div>";
                    $output .= '<div class="user-profile-block-content">';
                        $output .= '<div>';
                            $output .=  $no_picture_set ? '<div>' : '';
                                $output .= get_avatar( $profile_user_id, 512 );
                                $output .=  $no_picture_set ? '<span>This user did not set profile picture yet.</span>' : '';
                            $output .=  $no_picture_set ? '</div>' : '';
                            $output .=  ! empty( $user_status ) ? "<span class='user-status'>\"$user_status\"</span>" : '';
                        $output .= "</div>";
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</section>';
        }

        return $output;
    }
}

if( ! function_exists( 'ct_user_profile_survey' ) ){
    add_shortcode( 'user_profile_survey', 'ct_user_profile_survey' );
    function ct_user_profile_survey( $atts, $content, $shortcode_tag ) {
        $output = '';
        $classes = 'user-profile-block user-profile-survey masonry-item ';

        if( get_post_type( get_the_id() ) !== 'ct-user-profile' ) {
            return '<p class="error-message">Invalid use of shortcode - this post is not a User Profile.</p>';
        }

        $profile_user_id = get_post_meta( get_the_id(), 'profile_user_id', TRUE ); 
        $user_obj = get_user_by( 'id', $profile_user_id );

        if ( $user_obj ) {
            $user_meta = get_user_meta( $user_obj->data->ID );
            if( function_exists( 'get_field' /* ACF support */) ) {
                $infp = get_field( 'infp', 'user_' . $profile_user_id );
            } else {
                $infp = $user_meta['infp'][0];
            }
            $writing_preferences = $user_meta['writing_preferences'][0];
            $social_links = $user_meta['social_links'][0];
            $section_headers_color = $user_meta['section_headers_color'][0] ?: 'var(--secondary-color)';

            // Filter $classes via the child theme to customize specific users' profiles without commiting changes
            $output .= "<section class='" . apply_filters( 'ct_user_profile_block_classes', $classes, $shortcode_tag ) . "'>";
                $output .= '<div class="masonry-content">';
                    $header_style = " style='background: $section_headers_color;' ";
                    $output .= "<div class='user-profile-block-header' $header_style>";
                    $output .= '<span>' . __( "Survey", 'coders-teaparty' ) . '</span>';
                    $output .= "</div>";
                    $output .= '<div class="user-profile-block-content">';
                    if( !empty( $infp ) ) {
                        $output .= '<span class="survey-row">';
                            $output .= '<span class="survey-row-title">' . __( 'INFP-type:', 'coders-teaparty' ) . '</span>';
                            $output .= "<span class='survey-row-value'>$infp</span>";
                        $output .= '</span>';
                    }
                    if( !empty( $writing_preferences ) ) {
                        $output .= '<span class="survey-row">';
                            $output .= '<span class="survey-row-title">' . __( 'Writing Preferences:', 'coders-teaparty' ) . '</span>';
                            $output .= "<span class='survey-row-value'>$writing_preferences</span>";
                        $output .= '</span>';
                    }
                    if( !empty( $social_links ) ) {
                        $output .= '<span class="survey-row">';
                            $output .= '<span class="survey-row-title">' . __( 'Social Links:', 'coders-teaparty' ) . '</span>';
                            $output .= "<span class='survey-row-value'>$social_links</span>";
                        $output .= '</span>';
                    }

                    if( 
                        empty( $infp ) 
                        AND empty( $writing_preferences )
                        AND empty( $social_links )
                    ) {
                        $output .= __( 'This user have not shared anything about themselves yet.', 'coders-teaparty' );
                    }
                    
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</section>';
        }

        return $output;
    }
}

if( ! function_exists( 'ct_user_profile_latest_articles' ) ){
add_shortcode( 'user_profile_latest_articles', 'ct_user_profile_latest_articles' );
    function ct_user_profile_latest_articles( $atts, $content, $shortcode_tag ) {
        $output = '';
        $classes = 'user-profile-block user-profile-latest-articles masonry-item ';

        if( get_post_type( get_the_id() ) !== 'ct-user-profile' ) {
            return '<p class="error-message">Invalid use of shortcode - this post is not a User Profile.</p>';
        }

        $profile_user_id = get_post_meta( get_the_id(), 'profile_user_id', TRUE ); 
        $user_obj = get_user_by( 'id', $profile_user_id );
        if ( $user_obj ) {
            $user_meta = get_user_meta( $user_obj->data->ID );
            $section_headers_color = $user_meta['section_headers_color'][0] ?: 'var(--secondary-color)';
            $query_args = array(
                'author' => $profile_user_id,
                'ignore_sticky_posts' => TRUE,
                'no_found_rows' => TRUE,
                'orderby' => 'modified',
                'post_status' => 'published',
                'posts_per_page' => 3,
            );

            $the_query = new WP_Query( $query_args );
            $output .= "<section class='" . apply_filters( 'ct_user_profile_block_classes', $classes, $shortcode_tag ) . "'>";
                $output .= '<div class="masonry-content">';
                    $header_style = " style='background: $section_headers_color;' ";
                    $output .= "<div class='user-profile-block-header' $header_style>";
                    $output .= __( "Latest posts", 'coders-teaparty' );
                    $output .= "</div>";
                    $output .= '<div class="user-profile-block-content">';
                    if ( $the_query->have_posts() ) {
                        $output .= '<ul>';
                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            $output .= '<li class="user-latest-post">';
                                $output .= '<span class="post-date">';
                                $output .= get_the_date();
                                $output .= '</span>';
                                $output .= '<a href="' . get_the_permalink() . '" class="no-hover-effects">';
                                    $output .= '<h4 class="post-title">';
                                    $output .= esc_html( get_the_title() );
                                    $output .= '</h4>';
                                $output .= '</a>';
                            $output .= '</li>';
                        }
                        $output .= '</ul>';
                    } else {
                        $output .= __( "This user did not write any posts yet.", 'coders-teaparty' );
                    }
                    wp_reset_postdata();
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</section>';
        }

        return $output;
    }
}