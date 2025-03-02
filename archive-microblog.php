<?php get_header(); ?>
<?php include "includes/functions.php"; ?>
<main class="content-wrap">
  <?php get_sidebar( 'primary' ); ?>
  <section class="content-area content-thin">
    <h2></h2>
    <div class="archive-description">
      <?php
        $blog_url = get_site_url(null,"blog");
        _e( "Funny random thoughts, music and inspiration strikes are posted here. "
          . "You might as well check out <a href='$blog_url'>articles</a> for tutorials and useful tips." );
      ?> 
    </div>
    <div class="posts-list">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="single-microblog-post" data-ajax-id="<?php echo get_the_id();?>">
          <article class="single-microblog-message">
            <?php the_content(); ?>
          </article>
          <p class="single-microblog-post-meta">
            <?php 
              printf("By <span class='microblog-post-author'>%s</span> on <span class='microblog-post-date'>%s %s</span>", get_the_author(), get_the_date("jS M Y"), get_post_time("H:i"));
            ?>
          </p>
        </div>
      <?php endwhile; else : ?>
          <article>
            <p>Woops, nothing here yet!</p>
          </article>
      <?php endif; ?>
    </div>
    <?php wpbeginner_numeric_posts_nav() ?>
  </section>
</main>
<?php get_footer(); ?>