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
              $author_id = get_post_field ( 'post_author', get_the_ID() );
              $author_profile_page_url = ct_get_user_profile_page_url( $author_id );
            ?>
            <?php
              echo 'By: ';
              if ( $author_profile_page_url ) {
                echo sprintf( "<a href='%s'>%s</a>", $author_profile_page_url, get_the_author() );
              } else {
                the_author();
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