<?php get_header(); ?>
<main class="content-wrap">
  <?php get_sidebar( 'primary' ); ?>
  <section class="content-area content-thin">
    <div class="posts-list">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php include "template-parts/article.php"; ?>
      <?php endwhile; else : ?>
            <article>
              <p>Sorry, no posts were found!</p>
            </article>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php get_footer(); ?>