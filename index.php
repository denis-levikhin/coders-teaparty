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
                <?php
                  // Post author
                  $author_id = get_post_field ( 'post_author', get_the_ID() );
                  $author_profile_page_url = ct_get_user_profile_page_url( $author_id );
                  $author_string = $author_profile_page_url
                                  ?  sprintf( "<a href='%s'>%s</a>", $author_profile_page_url, get_the_author() )
                                  : get_the_author();
                  echo sprintf( __( 'by %s' ), $author_string );
                ?>
              </header>
              <?php the_excerpt(); ?>
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