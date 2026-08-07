<?php get_header(); ?>
<main class="content-wrap">
  <?php get_sidebar( 'primary' ); ?>
  <section class="content-area content-thin">
    <article class="article-full masonry-grid">
      <?php
        // TODO: Rewrite in OOP as a UserProfileBlock
        $classes = 'user-profile-block user-profile-general-info masonry-item ';
        $profile_user_id = get_the_author_meta( 'ID' ); 
        $user_obj = get_user_by( 'id', $profile_user_id );
        $user_meta = get_user_meta( $profile_user_id );
        $user_nicename = get_the_author_meta( 'nickname' );
        $user_bio = get_the_author_meta( 'description' );
        $user_position = get_the_author_meta( 'position' ) ?: __( 'Dude', 'coders-teaparty' );
        $user_cover_image_id = get_the_author_meta( 'cover' );
        $section_headers_color = get_the_author_meta( 'section_headers_color' ) ?: 'var(--secondary-color)';
        $user_cover_image_src = wp_get_attachment_image_src( $user_cover_image_id, 'large' );
        $user_cover_image_src_attr = ! empty( $user_cover_image_src ) ? $user_cover_image_src[0] : '';
        if( empty( $user_bio ) ) {
          $user_bio = __( 'This user have not shared anything about themselves yet.', 'coders-teaparty' );
        }
      ?>
      <!-- Bio Block -->
      <section class="<?= $classes; ?>">
        <div class="masonry-content">
          <?php 
          if( ! empty( $user_cover_image_src_attr ) ) {
            // block opening div with image
            echo "<div class='user-profile-block-header with-cover' style='background: top / cover url(\"$user_cover_image_src_attr\")'>";
          } else {
            // block opening div with solid color
            echo "<div class='user-profile-block-header' style='background: $section_headers_color;'>";
          }
          ?>
            <span>
              <h3 class='user-name'><?= $user_nicename ?></h3>
              <span class='user-position'><?= $user_position ?></span>
            </span>
          </div>
        
          <div class="user-profile-block-content">
            <h4><?= __( 'Bio:', 'coders-teaparty' ) ?></h4>
            <div><?= $user_bio ?></div>
          </div>
        </div>
      </section>

      <?php 
        $classes = 'user-profile-block user-profile-picture masonry-item ';
        $user_status = get_the_author_meta( 'motd' ); // status is a reserved keyword, so using 'motd'
      ?>
      <!-- Profile Picture and Motd Block -->
      <section class="<?= $classes ?>">
        <div class="masonry-content">
          <div class='user-profile-block-header' style='background: <?= $section_headers_color; ?>'></div>
            <div class="user-profile-block-content">
              <div>
                <?php
                  echo get_avatar( $profile_user_id, 512 );
                  echo ! empty( $user_status ) ? "<span class='user-status'>\"$user_status\"</span>" : '';
                ?>
              </div>
            </div>
          </div>
      </section>

      <?php
        $classes = 'user-profile-block user-profile-survey masonry-item ';
        // retrieve LABEL of the field, cause default get_the_author_meta will only get name like "infj", not "Mediator"
        if( function_exists( 'get_field' /* ACF support */) ) {
          $infp = get_field( 'infp', 'user_' . $profile_user_id );
        } else {
          $infp = get_the_author_meta( 'infp' );
        }
        $writing_preferences = get_the_author_meta( 'writing_preferences' );
        $social_links = get_the_author_meta( 'social_links' );
      ?>
      <!-- Survey Block -->
      <section class="<?= $classes ?>">
        <div class="masonry-content">
          <div class='user-profile-block-header' style='background: <?= $section_headers_color; ?>'>
            <span><?= __( "Survey", 'coders-teaparty' ) ?></span>
          </div>
          <div class="user-profile-block-content">
            <?php if( !empty( $infp ) ) { ?>
              <span class="survey-row">
                <span class="survey-row-title"><?= __( 'INFP-type:', 'coders-teaparty' ) ?></span>
                <span class='survey-row-value'><?= $infp ?></span>
              </span>
            <?php } ?>
            <?php if( !empty( $writing_preferences ) ) { ?>
              <span class="survey-row">
                <span class="survey-row-title"><?= __( 'Writing Preferences:', 'coders-teaparty' ) ?></span>
                <span class='survey-row-value'><?= $writing_preferences ?></span>
              </span>
            <?php } ?>
            <?php if( !empty( $social_links ) ) { ?>
              <span class="survey-row">
                <span class="survey-row-title"><?= __( 'Social Links:', 'coders-teaparty' ) ?></span>
                <span class='survey-row-value'><?= $social_links ?></span>
              </span>
            <?php } ?>
            <?php
              if ( 
                  empty( $infp ) 
                  AND empty( $writing_preferences )
                  AND empty( $social_links )
              ) {
                echo __( 'This user have not shared anything about themselves yet.', 'coders-teaparty' );
              }
            ?>
          </div>
        </div>
      </section>

      <?php
        $output = '';
        $classes = 'user-profile-block user-profile-latest-articles masonry-item ';
      ?>
      <!-- Latest Posts block -->
      <section class="<?= $classes ?>">
        <div class="masonry-content">
          <div class='user-profile-block-header' style='background: <?= $section_headers_color; ?>'>
            <span><?= __( "Latest posts", 'coders-teaparty' ) ?></span>
          </div>
          <div class="user-profile-block-content">
            <?php 
              if ( have_posts() ) {
                echo '<ul>';
                $post_counter = 0;
                while ( have_posts() AND $post_counter < 3 ) {
                  the_post();
                  echo '<li class="user-latest-post">';
                      echo '<span class="post-date">';
                      the_date();
                      echo '</span> '; // important space in the end, words will stick to each other otherwise
                      echo '<a href="' . get_the_permalink() . '" class="no-hover-effects">';
                          echo '<span class="post-title">';
                          the_title();
                          echo '</span>';
                      echo '</a>';
                  echo '</li>';
                  $post_counter++;
                }
                echo '</ul>';
              } else {
                  echo __( "This user did not write any posts yet.", 'coders-teaparty' );
              }
            ?>
          </div>
        </div>
      </section>

      <?php
        $output = '';
        $classes = 'user-profile-block user-profile-latest-comments masonry-item ';
      ?>
      <!-- Latest Comments Block -->
      <section class="<?= $classes ?>">
        <div class="masonry-content">
          <div class='user-profile-block-header' style='background: <?= $section_headers_color; ?>'>
            <span><?= __( "Latest Comments", 'coders-teaparty' ) ?></span>
          </div>
          <div class="user-profile-block-content">
            <?php 
              $recent_comments = get_comments( array( 
                  'user_id'     => $profile_user_id,
                  'number'      => 3,
                  'status'      => 'approve',
                  'post_status' => is_user_logged_in() ? 'publish,private' : 'publish'
              ) );
              if ( $recent_comments ) {
                echo '<ul>';
                foreach ( (array) $recent_comments as $comment ) {
                  echo '<li class="user-latest-comments">';
                    echo '<span class="comments-date">';
                      echo get_comment_date('', $comment);
                    echo '</span>';
                    echo '<span class="date-separator"> ' . __( "in reply to", 'coders-teaparty' ) .' </span>';
                    echo '<a href="' . esc_url( get_comment_link( $comment ) ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a>';
                  echo '</li>';
                }
                echo '</ul>';
              } else {
                  echo __( "This user did not write any comments yet.", 'coders-teaparty' );
              }
            ?>
          </div>
        </div>
      </section>
    </article>
  </section>
</main>
<?php get_footer(); ?>