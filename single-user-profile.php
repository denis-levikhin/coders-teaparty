<?php get_header(); ?>
<main class="content-wrap">
  <?php get_sidebar( 'primary' ); ?>
  <section class="content-area content-thin">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php 
            $profile_user_id = get_post_meta( get_the_id(), 'profile_user_id', TRUE ); 
            $user_obj = get_user_by( 'id', $profile_user_id );
            if ( $user_obj ) {
                $user_data = get_user_meta( $user_obj->data->ID );    
                $user_nicename = $user_data['nickname'][0];
                $user_bio =  $user_data['description'][0];
            } else die( 'No such user registred' );
        ?>
        <article class="article-full">
          <header>
            <h2><?php echo $user_nicename; ?></h2>
          </header>
        <?php echo $user_bio; ?>
        </article>
    <?php endwhile; else : ?>
          <article>
            <p>No such posts!</p>
          </article>
    <?php endif; ?>
  </section>
</main>
<?php get_footer(); ?>