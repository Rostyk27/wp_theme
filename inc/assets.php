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
		wp_enqueue_script('googlemaps', '//maps.googleapis.com/maps/api/js?v=3.exp', array(), '', false);
	}

	wp_enqueue_script('jquery', get_stylesheet_directory_uri(). '/js/libs/jquery.js', array(), '', false);
	wp_enqueue_script('fastClick', get_stylesheet_directory_uri(). '/js/libs/fastclick.js', array('jquery'), '', true);
	wp_enqueue_script('swiper', get_stylesheet_directory_uri(). '/js/libs/swiper.js', array('jquery'), '', true);
	wp_enqueue_script('libs', get_stylesheet_directory_uri(). '/js/lib.js', array('jquery'), '', true);
	wp_enqueue_script('logic', get_stylesheet_directory_uri(). '/js/logic.js', array('libs'), '', true);
	wp_enqueue_script('css3animateIt', get_stylesheet_directory_uri(). '/js/libs/css3animate-it.js', array('jquery'), '', true);
//	wp_enqueue_script('webfont', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js#defer', false, null, true);

	wp_enqueue_style('libs', get_stylesheet_directory_uri(). '/style/libs.css' );
	wp_enqueue_style('scss', get_stylesheet_directory_uri(). '/style/style.scss' );

	if(class_exists('Woocommerce')) {
		wp_enqueue_style('custom-woo', get_stylesheet_directory_uri(). '/style/woo.scss' );
	}
}
add_action('wp_enqueue_scripts', 'tt_add_jscss');