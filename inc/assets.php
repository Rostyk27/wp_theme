<?php

// custom js/stylesheet
function tt_add_jscss() {
	if (!is_admin()) {
		wp_deregister_script( 'jquery' );
	}

	if(defined('WPCF7_VERSION')) {
		wp_deregister_style( 'contact-form-7' );
	}

	if(defined('QTX_VERSION')) {
		wp_deregister_style('qtranslate-style');
	}

	if(defined('GOOGLEMAPS')) {
		wp_enqueue_script('googlemaps', '//maps.googleapis.com/maps/api/js?v=3.exp&language=en&key=AIzaSyAO77hGcvxmsvOn1RSjDFQMI4YUnW89MDo', false, null, false);
	}

	wp_enqueue_script('jquery', get_stylesheet_directory_uri(). '/js/_jquery.js', false, null, false);
	wp_enqueue_script('libs', get_stylesheet_directory_uri(). '/js/libs.js', array('jquery'), null, true);
	wp_enqueue_script('scripts', get_stylesheet_directory_uri(). '/js/scripts.js', array('libs'), null, true);

	wp_enqueue_style('libs', get_stylesheet_directory_uri(). '/style/libs.css' );
	wp_enqueue_style('style', get_stylesheet_directory_uri(). '/style/style.css' );
}
add_action('wp_enqueue_scripts', 'tt_add_jscss');

// load styles in footer -> enable once loader added
//function prefix_add_footer_styles() {
//	wp_enqueue_style('libs', get_stylesheet_directory_uri(). '/style/libs.css' );
//	wp_enqueue_style('style', get_stylesheet_directory_uri(). '/style/style.css' );
//};
//add_action( 'get_footer', 'prefix_add_footer_styles' );

//Disable gutenberg style in Front
function wps_deregister_styles() {
	wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
