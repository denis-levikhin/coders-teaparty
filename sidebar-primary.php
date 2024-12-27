<div id="sidebar-primary" class="sidebar">

	<div class="sidebar-level-1">
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