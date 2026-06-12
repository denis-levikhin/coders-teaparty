<?php
/**
 * Single article in an article list
*/
?>
<article class="article-loop">
    <?php
        //-- Featured image and post link --//
        printf( '<a href="%s" title="%s"> %s </a>',
            get_the_permalink(),
            the_title_attribute( array( 'echo' => FALSE ) ),
            get_the_post_thumbnail( null, 'medium_large' )
        );
    ?>
    <div>
        <?php
            //-- Post Title --//
            $post_title = ! empty( get_the_title() ) ? get_the_title() : __( 'No Title' , 'coders-teaparty' ) ;
            $post_title_attribute = esc_attr( $post_title );
            printf( '<h3><a href="%s" title="%s">%s</a></h3>', get_the_permalink(), $post_title_attribute, $post_title );

            //-- Post Desсription --//
            the_excerpt();
            
            //-- Post Tags --//
            $tag_args = array(
                'taxonomy' => 'post_tag',
                'hide_empty' => FALSE,
                'object_ids' => get_the_ID(),
                'orderby' => 'count',
                'order' => 'DESC',
            );
            $tags = get_tags( $tag_args );
            echo '<div class="post-tags">';
            echo __( 'Tags', 'coders-teaparty' ) . ':&nbsp;';
            if ( $tags ) {
                for ( $i = 0; $i < count( $tags ); $i++ ) {
                    $tag = $tags[ $i ];
                    echo "<a href='" . get_term_link( $tag ) . "'>";
                        echo "<span class='post-tag as-button'>";
                            echo "<span class='tag-name'>$tag->name</span>";
                        echo '</span>';
                    echo '</a>';
                    echo '<span class="tag-separator">' . ( $i != ( count( $tags ) - 1 ) ? ', ' : '') . '</span>';
                }
            } else {
                echo '<span class="no-tags">' . __( 'No tags', 'coders-teaparty' ) . '</span>';
            }
            echo '</div>';
        ?>
    </div>
</article>