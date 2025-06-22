<aside id="sidebar-primary" class="sidebar mobile-view-hidden">

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
			echo "<h1 class='website-title'>";
			echo "<a href='$website_url'>";
			bloginfo('name');
			echo "</a></h1>";
		?>
		<span class="greeting">Addya</span>
		
	</div>
	<div class="sidebar-level-2">
		<?php dynamic_sidebar('primary'); ?>
		<ul class="lang-switcher no-hover-effects">
			<?php pll_the_languages( array( 'show_flags' => 1, 'hide_if_no_translation' => 1, 'dropdown' => 1 ) ); ?>
		</ul>
	</div>
</div>
</aside>