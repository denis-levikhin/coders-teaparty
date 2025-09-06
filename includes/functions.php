<?php
// helper functions to be reused across website

if ( ! function_exists( 'ct_the_posts_pagination' ) ) {
    function ct_the_posts_pagination() {
        echo '<div class="no-hover-effects">';
        the_posts_pagination(
            array(
            'mid_size' => 4,
            )
        );
        echo '<div>';
    }
}

// === === === === === === === //
// TODO: probably, move to template parts as well as comments
// >>> Breadcrumbs
if ( !function_exists( 'ct_get_breadcrumbs' ) ) {
	function ct_get_breadcrumbs( $separator = ' / ' ){
        if( is_front_page() ) {
            return '';
        }

		$output = '<nav aria-label="Breadcrumbs" class="ct-breadcrumbs">';

		$output .= sprintf( '<a href="%s" rel="nofollow">%s</a>', home_url(), __( 'Home', 'coders-teaparty' ) );
        if( is_home() AND ! is_front_page() ){ /* posts page */
			$output .= $separator;
			$output .= sprintf('<span class="ct-breadcrumbs-item">%s</span>', __( 'Articles', 'coders-teaparty' ) );
        } elseif ( is_single() ) {
            $post_type_name = get_post_type();
            $post_type_object = get_post_type_object( $post_type_name );
            if( ! empty( $post_type_object ) ){
                $output .= $separator;
                $archive_link = get_post_type_archive_link( $post_type_name );
                $output .= "<span class='ct-breadcrumbs-item'><a href='$archive_link'>";
                $output .= $post_type_object->labels->name;
                $output .= "</span></a>";
            }
			$output .= $separator;
			$output .= get_the_title();
		} elseif ( is_category() OR is_single() ) {
			$output .= $separator;
			$output .= '<span class="ct-breadcrumbs-item">' . get_the_category_list( $separator, "single" ) . '</span>';
		} 
        elseif ( is_page() ) {
			$output .= $separator;
			$output .= get_the_title();
		} elseif ( is_search() ) {
			$output .= $separator;
			$output .= __( 'Search for: ' );
			$output .= '"<em>';
			$output .= get_the_search_query();
			$output .= '</em>"';
		} elseif( is_archive() ){
            $archive_title = get_the_archive_title();
            $archive_title_trimmed = preg_replace(
            array('/^Archives:/i'),
            array(''),
            $archive_title
            ); 
			$output .= $separator;
            $output .= $archive_title_trimmed;
        }
        $output .= '</nav>';
        return $output;
	}
}
