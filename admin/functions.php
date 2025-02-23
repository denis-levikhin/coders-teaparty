<?php 
// >>> Add theme options admin menu
// DEAD CODE, but the icon is pretty, so the code just left here as is unless we really
// need a separate menu for theme options

function codersteaparty_register_admin_menu() {
    $icon_SVG = file_get_contents( get_template_directory() . '/media/icons/admin/reshot-icon-coffee-6DPVBC3U9M.svg' );
    $icon_SVG_Base64 = base64_encode( $icon_SVG );

	add_menu_page(
		__( 'Coders Teaparty', 'codersteaparty' ),
		'Theme Options',
		'manage_options',
		'codersteaparty/themeoptions.php',
		'',
		'data:image/svg+xml;base64,' . $icon_SVG_Base64,
		59
	);
}
