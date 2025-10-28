<?php get_header(); ?>
<main class="content-wrap">
  <?php get_sidebar( 'primary' ); ?>
  <section class="content-area content-thin">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article class="article-full">
            <?php echo ct_get_breadcrumbs(); ?>
            <header>
            <h2><?php the_title(); ?></h2>
            <?php
                // Post author
                $author_id = get_post_field ( 'post_author', get_the_ID() );
                $author_profile_page_url = ct_get_user_profile_page_url( $author_id );
            ?>
            <?php
                $author_string = $author_profile_page_url
                                ?  sprintf( "<a href='%s'>%s</a>", $author_profile_page_url, get_the_author() )
                                : get_the_author();
                echo sprintf( __( 'by %s' ), $author_string );

                // Post Tags
                $tag_args = array(
                    'taxonomy' => 'post_tag',
                    'hide_empty' => FALSE,
                    'object_ids' => get_the_ID(),
                    'orderby' => 'count',
                    'order' => 'DESC',
                );
                $tags = get_tags( $tag_args );
                if ( $tags ) {
                    echo '<div class="post-tags">';
                    echo __( 'Tags' ) . ':&nbsp;';
                    foreach ( $tags as $tag ) {
                        echo "<a href='" . get_term_link( $tag ) . "'>";
                        echo '<span class="post-tag">';
                        echo "<span class='tag-name'>$tag->name</span>";
                        echo "<span class='tag-post-count'>$tag->count</span>";
                        //echo "<span class='tag-description'>$tag->description</span>";
                        echo '</span>';
                        echo '</a>';
                    }
                    echo '</div>';
                }
            ?>
          </header>
        <?php the_content(); ?>
        </article>
        <?php // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif; 
        ?>
    <?php endwhile; else : ?>
          <article>
            <p>No such posts!</p>
          </article>
    <?php endif; ?>
  </section>
</main>
<?php get_footer(); ?>