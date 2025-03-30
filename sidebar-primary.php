<div id="sidebar-primary" class="sidebar mobile-view-hidden">

<div class="sidebar-wrapper">
	<div class="mobile-menu-close-button">
		<img src="<?php echo get_stylesheet_directory_uri() . '/media/icons/close-svgrepo-com.svg'; ?>" alt="menu-close-button" tabindex="0">
	</div>
	<div class="sidebar-level-1 text-centered">
		<?php
			$website_url = get_site_url();
			echo "<a id='le-fox' class='no-hover-effects' href='$website_url'></a>";
		?>
		<?php 
			echo "<h2 class='website-title'>";
			echo "<a href='$website_url'>";
			bloginfo('name');
			echo "</a></h2>";
		?>
		
	</div>
	<div class="sidebar-level-2">
		<?php dynamic_sidebar('primary'); ?>
	</div>
	<div class="sidebar-level-3">
		<p class="login-message">
			<?php if( ! is_user_logged_in() ) {
				$url = esc_url( wp_login_url( get_permalink() ) );
				$linktext = __( 'Log in', 'textdomain' );
				echo "<a href='$url' class='no-hover-effects'>$linktext</a>";
			} else {
				$url = esc_url( get_admin_url() );
				$linktext = __( 'To Admin', 'textdomain' );
				echo "<a href='$url' class='no-hover-effects'>$linktext</a>";
			}
			?>
		</p>
	</div>
</div>

</div>