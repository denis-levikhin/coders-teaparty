<?php
// helper functions to be reused across website

function wpbeginner_numeric_posts_nav() {
  
    if( is_singular() )
        return;
  
    global $wp_query;
  
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
  
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
  
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
  
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
  
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
  
    echo '<div class="pagination"><ul>' . "\n";
  
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link() );
  
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
  
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
  
        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }
  
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
  
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";
  
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
  
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link() );
  
    echo '</ul></div>' . "\n";
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
