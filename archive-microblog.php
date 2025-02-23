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
        <article class="single-microblog-post" data-ajax-id="<?php echo get_the_id();?>">
          <p class="single-microblog-message">
            <?php 
              $post_content = get_the_content(); 
              $characters_before_readmore = get_option( 'codersteaparty_microblog_caracters_limit', 250 );
              $is_large_post = ( strlen($post_content) - $characters_before_readmore ) > $characters_before_readmore * 0.25;

              /* insert readmore automatically
               * no need to "readmore" a single word or two, only if a message is significantly bigger than it should be
               * also just output full post content if there is no "show/hide" plugin https://wordpress.org/plugins/showhide-shortcode/
               * ofc plugin dependance is bad, but I dont want to implement "readmore" functionality myself
               * 
               * TODO: FIX THIS, probably with AJAX instead of this shit
               * i wanna load the whole post instead of using that showhide plugin
               */
              //if( ! $is_large_post || ! shortcode_exists( 'showhide' ) ) {
              if(true){
                the_content();
              } else {
                $visible_part = substr( $post_content, 0, $characters_before_readmore );
                $last_space_in_visible = strrpos($visible_part, '.') + 1;

                $visible_part = substr( $post_content, 0, $last_space_in_visible );
                $hidden_part = substr( $post_content, $last_space_in_visible );

                $hidden_part_wrapped = trim( do_shortcode('[showhide]' . $hidden_part . '[/showhide]') );
                
                echo $visible_part . $hidden_part_wrapped;
              }
            ?>
          </p>
          <p class="single-microblog-post-meta">
            <?php 
              printf("By <span class='microblog-post-author'>%s</span> on <span class='microblog-post-date'>%s %s</span>", get_the_author(), get_the_date("jS M Y"), get_post_time("H:i"));
            ?>
          </p>
        </article>
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