<?php
/* ACF settings */

// add custom tab (group) for common ACF fields
if(function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title'    => 'Theme General Settings',
		'menu_title'    => 'Theme Settings',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	));
}

function my_acf_init() {
	// g-map API key
	acf_update_setting('google_api_key', 'AIzaSyAO77hGcvxmsvOn1RSjDFQMI4YUnW89MDo');

	// check if function exists
	// Gutenberg blocks
	if( function_exists('acf_register_block_type') ) {

		// register a testimonial block
		acf_register_block_type(array(
			'name'            => 'accordion',
			'title'           => __( 'Accordion' ),
			'description'     => __( 'Use this block to have an accordion block.' ),
			'render_template' => get_template_directory() . '/tpl-parts/blocks/block-accordion.php',
			'category'        => 'formatting',
			'icon'            => 'editor-table',
			'keywords'        => array( 'accordion', 'group', 'text' ),
			'mode'            => 'edit',
			'example'         => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'__is_preview' => true
					)
				)
			)
		));

		// register custom video block
		acf_register_block_type(array(
			'name'            => 'custom-video',
			'title'           => __( 'Custom Video' ),
			'description'     => __( 'Use this block to have the custom video block.' ),
			'render_template' => get_template_directory() . '/tpl-parts/blocks/block-custom-video.php',
			'category'        => 'media',
			'icon'            => 'embed-video',
			'keywords'        => array( 'video', 'embed', 'custom' ),
			'mode'            => 'edit',
			'example'         => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'__is_preview' => true
					)
				)
			)
		));

		// register a custom gallery block
		acf_register_block_type(array(
			'name'            => 'custom-gallery',
			'title'           => __( 'Custom Gallery' ),
			'description'     => __( 'Use this block to have the custom gallery block.' ),
			'render_template' => get_template_directory() . '/tpl-parts/blocks/block-custom-gallery.php',
			'category'        => 'media',
			'icon'            => 'layout',
			'keywords'        => array( 'gallery', 'image', 'custom' ),
			'mode'            => 'edit',
			'example'         => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'__is_preview' => true
					)
				)
			)
		));

		// register a custom slider block
		acf_register_block_type(array(
			'name'            => 'custom-slider',
			'title'           => __( 'Custom Slider' ),
			'description'     => __( 'Use this block to have the custom slider block.' ),
			'render_template' => get_template_directory() . '/tpl-parts/blocks/block-custom-slider.php',
			'category'        => 'media',
			'icon'            => 'images-alt2',
			'keywords'        => array( 'slider', 'image', 'custom' ),
			'mode'            => 'edit',
			'example'         => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'__is_preview' => true
					)
				)
			)
		));
	}
}
add_action('acf/init', 'my_acf_init');

// add custom styles for custom Gutenberg blocks in WP dashboard
function load_custom_wp_admin_style() {
	wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/tpl-parts/blocks/block-custom-styles.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

// ACF repeater styles
function acf_repeater_even() {
	$scheme = get_user_option( 'admin_color' );
	$color = '';
	if($scheme == 'fresh') {
		$color = '#0073aa';
	} else if($scheme == 'light') {
		$color = '#d64e07';
	} else if($scheme == 'blue') {
		$color = '#52accc';
	} else if($scheme == 'coffee') {
		$color = '#59524c';
	} else if($scheme == 'ectoplasm') {
		$color = '#523f6d';
	} else if($scheme == 'midnight') {
		$color = '#e14d43';
	} else if($scheme == 'ocean') {
		$color = '#738e96';
	} else if($scheme == 'sunrise') {
		$color = '#dd823b';
	}
	echo '<style>.acf-repeater > table > tbody > tr:nth-child(even) > td.order {color: #fff !important;background-color: '.esc_html($color).' !important; text-shadow: none}</style>';
}
add_action('admin_footer', 'acf_repeater_even');

// remove ACF menu item from
add_filter('acf/settings/show_admin', 'my_acf_show_admin');
function my_acf_show_admin( $show ) {
	return current_user_can('manage_options');
}