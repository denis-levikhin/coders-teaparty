<?php get_header(); ?>
<main class="content-wrap">
  <?php get_sidebar( 'primary' ); ?>
  <section class="content-area content-thin <?php if ( is_front_page() ) echo 'text-centered'; ?>">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article class="article-full">
          <?php echo ct_get_breadcrumbs(); ?>
          <?php the_content(); ?>
        </article>
    <?php endwhile; else : ?>
          <article>
            <p>No such posts!</p>
          </article>
    <?php endif; ?>
  </section>
</main>
<?php get_footer(); ?>