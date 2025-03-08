<div id="sidebar-primary" class="sidebar mobile-view-hidden">

<div class="sidebar-wrapper">
	<div class="mobile-menu-close-button">
		<img src="<?php echo get_stylesheet_directory_uri() . '/media/icons/close-svgrepo-com.svg'; ?>" alt="menu-close-button" tabindex="0">
	</div>
	<div class="sidebar-level-1 text-centered">
		<?php
			$website_url = get_site_url();
			echo "<h2 class='website-title'>";
			echo "<a href='$website_url'>";
			bloginfo('name');
			echo "</a></h2>";
		?>
		
	</div>
	<div class="sidebar-level-2">
		<?php dynamic_sidebar('primary'); ?>
	</div>
</div>

</div>