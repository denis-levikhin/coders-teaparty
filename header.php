<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <!-- Devnote: do not load separate page stylesheets here, do it in functions.php via enqueue_style() -->
</head>

<body <?php body_class(); ?> id="sky">
    <div class="mobile-header">
        <div class="mobile-menu-switch">
            <img src="<?php echo get_stylesheet_directory_uri() . '/media/icons/menu-vertical-svgrepo-com.svg'; ?>" alt="open-menu-button" tabindex="0">
        </div>
    </div>