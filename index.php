<?php get_header(); ?>
<main class="content-wrap">
  <?php get_sidebar( 'primary' ); ?>
  <section class="content-area content-thin">
    <div class="posts-list">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article class="article-loop">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail( 'medium_large' ); ?>
              </a>
              <header>
                <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                <?php the_excerpt(); ?>
                <?php
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
                    for ( $i = 0; $i < count( $tags ); $i++ ) {
                        $tag = $tags[ $i ];
                        echo "<a href='" . get_term_link( $tag ) . "'>";
                          echo "<span class='post-tag as-button'>";
                            echo "<span class='tag-name'>$tag->name</span>";
                          echo '</span>';
                        echo '</a>';
                        echo '<span class="tag-separator">' . ( $i != ( count( $tags ) - 1 ) ? ', ' : '') . '</span>';
                    }
                    echo '</div>';
                }
                ?>
              </header>
        </article>
      <?php endwhile; else : ?>
            <article>
              <p>Sorry, no posts were found!</p>
            </article>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php get_footer(); ?>