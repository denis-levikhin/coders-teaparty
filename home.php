<?php get_header(); ?>
<main class="content-wrap">
  <?php get_sidebar( 'primary' ); ?>
  <section class="content-area content-thin">
    <div class="posts-list">
      <?php echo ct_get_breadcrumbs(); ?>
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article class="article-loop">
              <header>
                <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                By: <?php the_author(); ?>
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