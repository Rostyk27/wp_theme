<?php

/* Theme config params */

// defines
define( 'WPE_POPUP_DISABLED', true );
//define ('GOOGLEMAPS', TRUE);
define ('HOME_PAGE_ID', get_option('page_on_front'));
define ('BLOG_ID', get_option('page_for_posts'));
define ('POSTS_PER_PAGE', get_option('posts_per_page'));
//define('WP_SCSS_ALWAYS_RECOMPILE', true);
// Prevent File Modifications
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

// Recommended plugins installer
require_once 'plugins/installer.php';

// Include custom assets
require_once('assets.php');

// Custom admin area functions
require_once('wpadmin/admin-addons.php');

// Custom shortcodes
require_once('shortcodes.php');

// Custom ajax functions
//require_once('ajax.php');

// Custom Posts Duplicator
require_once('plugins/duplicator.php');

function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyAO77hGcvxmsvOn1RSjDFQMI4YUnW89MDo');

	// check function exists
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

function load_custom_wp_admin_style() {
	wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/tpl-parts/blocks/block-custom-styles.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

// Custom theme url
function theme($filepath = NULL){
	return preg_replace( '(https?://)', '//', get_stylesheet_directory_uri() . ($filepath?'/' . $filepath:'') );
}

// Run this code on 'after_theme_setup', when plugins have already been loaded.
add_action('after_setup_theme', 'wpa_activate_theme');
// This function loads the plugins && update some wordpress options
function wpa_activate_theme() {
	update_option('image_default_link_type','none');
	update_option('uploads_use_yearmonth_folders', 0);
	update_option('permalink_structure', '/%category%/%postname%/');
}

//Remove embeds rewrites
function disable_embeds_rewrites( $rules ) {
	foreach ( $rules as $rule => $rewrite ) {
		if ( false !== strpos( $rewrite, 'embed=true' ) ) {
			unset( $rules[ $rule ] );
		}
	}
	return $rules;
}

// Remove recent_comments_style in wp_head
function my_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action('widgets_init', 'my_remove_recent_comments_style');

// Compress HTML
function ob_html_compress($buf){
	$preResult = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/', ' ', $buf);
	$out       = preg_replace(
		array('/<!--(?>(?!\[).)(.*)(?>(?!\]).)-->/Uis', '/[[:blank:]]+/'),
		array('', ' '),
		str_replace(array("\n", "\r", "\t"), '', $preResult)
	);

	return nl2br($out);
}

//custom wp_nav_menu classes
function wpa_discard_menu_classes($classes, $item) {
	$classes = array_filter(
		$classes, function($class) {return in_array( $class, array( "current-menu-item", "current-menu-parent", "current_page_parent", "menu-item-has-children" )); }
	);
	return array_merge(
		$classes,
		(array)get_post_meta( $item->ID, '_menu_item_classes', true )
	);
}

// New Body Classes
function wpa_body_classes( $classes ){
	if( is_page() ){
		global $post;
		$temp = get_page_template();
		if ( $temp != null ) {
			$path = pathinfo($temp);
			$tmp = $path['filename'] . "." . $path['extension'];
			$tn= str_replace(".php", "", $tmp);
			$classes[] = $tn;
		}
//		if (is_active_sidebar('sidebar')) {
//			$classes[] = 'with_sidebar';
//		}
		foreach($classes as $k => $v) {
			if(
				$v == 'page-template' ||
				$v == 'page-id-'.$post->ID ||
				$v == 'page-template-default' ||
				$v == 'woocommerce-page' ||
				($temp != null?($v == 'page-template-'.$tn.'-php' || $v == 'page-template-'.$tn):'')) unset($classes[$k]);
		}
	}
	if( is_single() ){
		global $post;
		$f = get_post_format( $post->ID );
		foreach($classes as $k => $v) {
			if($v == 'postid-'.$post->ID || $v == 'single-format-'.(!$f?'standard':$f)) unset($classes[$k]);
		}
	}

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	$browser = $_SERVER[ 'HTTP_USER_AGENT' ];

	// Mac, PC ...or Linux
	if ( preg_match( "/Mac/", $browser ) ){
		$classes[] = 'macos';
	} elseif ( preg_match( "/Windows/", $browser ) ){
		$classes[] = 'windows';
	} elseif ( preg_match( "/Linux/", $browser ) ) {
		$classes[] = 'linux';
	} else {
		$classes[] = 'unknown-os';
	}
	// Checks browsers in this order: Chrome, Safari, Opera, MSIE, FF
	if ( preg_match( "/Edge/", $browser ) ) {
		$classes[] = 'edge';
	} elseif ( preg_match( "/Chrome/", $browser ) ) {
		$classes[] = 'chrome';
		preg_match( "/Chrome\/(\d.\d)/si", $browser, $matches);
		@$classesh_version = 'ch' . str_replace( '.', '-', $matches[1] );
		$classes[] = $classesh_version;
	} elseif ( preg_match( "/Safari/", $browser ) ) {
		$classes[] = 'safari';
		preg_match( "/Version\/(\d.\d)/si", $browser, $matches);
		$sf_version = 'sf' . str_replace( '.', '-', $matches[1] );
		$classes[] = $sf_version;
	} elseif ( preg_match( "/Opera/", $browser ) ) {
		$classes[] = 'opera';
		preg_match( "/Opera\/(\d.\d)/si", $browser, $matches);
		$op_version = 'op' . str_replace( '.', '-', $matches[1] );
		$classes[] = $op_version;
	} elseif ( preg_match( "/MSIE/", $browser ) ) {
		$classes[] = 'msie';
		if( preg_match( "/MSIE 6.0/", $browser ) ) {
			$classes[] = 'ie6';
		} elseif ( preg_match( "/MSIE 7.0/", $browser ) ){
			$classes[] = 'ie7';
		} elseif ( preg_match( "/MSIE 8.0/", $browser ) ){
			$classes[] = 'ie8';
		} elseif ( preg_match( "/MSIE 9.0/", $browser ) ){
			$classes[] = 'ie9';
		}
	} elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
		$classes[] = 'firefox';
		preg_match( "/Firefox\/(\d)/si", $browser, $matches);
		$ff_version = 'ff' . str_replace( '.', '-', $matches[1] );
		$classes[] = $ff_version;
	} else {
		$classes[] = 'unknown-browser';
	}

	return $classes;
}

// Custom SEO Title
function wpa_title(){
	global $post;
	if(!defined('WPSEO_VERSION')) {
		if(is_404()) {
			echo '404 Page not found - ';
		} elseif((is_single() || is_page()) && $post->post_parent) {
			$parent_title = get_the_title($post->post_parent);
			echo wp_title('-', true, 'right') . esc_html($parent_title).' - ';
		} else {
			wp_title('-', true, 'right');
		}
		bloginfo('name');
	} else {
		wp_title();
	}
}

//Show empty categories in category widget
function show_empty_widget_links($args) {
	$args['hide_empty'] = 0;
	return $args;
}

//simple function for wp_get_attachment_image_src()
function image_src($id, $size = 'full', $background_image = false, $height = false) {
	if ($image = wp_get_attachment_image_src($id, $size, true)) {
		return $background_image ? 'background-image: url('.$image[0].');' . ($height?'height:'.$image[2].'px':'') : $image[0];
	}
}

// ACF Repeater Styles
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

function wpa_init() {
	/* @var WP $wp */
	global $wp;
	// Remove the embed query var.
	$wp->public_query_vars = array_diff( $wp->public_query_vars, array(
		'embed',
	) );
	// Filters for WP-API version 1.x
	add_filter('json_enabled', '__return_false');
	add_filter('json_jsonp_enabled', '__return_false');

	// Filters for WP-API version 2.x
//	add_filter('rest_enabled', '__return_false');
//	add_filter('rest_jsonp_enabled', '__return_false');
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	//Disable Thumbnails Embeds
	add_filter( 'embed_thumbnail_image_shape', '__return_false' );
	// Remove the REST API endpoint.
//	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	// Turn off oEmbed auto discovery.
	add_filter( 'embed_oembed_discover', '__return_false' );
	// Don't filter oEmbed results.
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	// Remove oEmbed discovery links.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	// Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	// Remove all embeds rewrite rules.
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'parent_post_rel_link', 10);
	remove_action('wp_head', 'start_post_rel_link', 10);
	remove_action('wp_head', 'wp_shortlink_wp_head' );
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head' );
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'rel_canonical');

	// Prevent Emoji from loading on the front-end
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	// Remove from admin area also
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	// Remove from RSS feeds also
	remove_filter( 'the_content_feed', 'wp_staticize_emoji');
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji');
	// Remove from Embeds
	remove_filter( 'embed_head', 'print_emoji_detection_script' );
	// Remove from emails
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	// Disable from TinyMCE editor. Currently disabled in block editor by default
	add_filter('tiny_mce_plugins', function($plugins) {
		if(is_array($plugins)) {
			return array_diff($plugins, array('wpemoji'));
		} else {
			return array();
		}
	});

	/** Finally, disable it from the database also,
	 *  to prevent characters from converting
	 *  Earlier, there was a setting under Writings to do this
	 *  It is not ideal to get & update it here - but it works for now
	 */
	if( (int) get_option('use_smilies') === 1 ) {
		update_option( 'use_smilies', 0 );
	}

	//Page/Post thumbnail support
	add_theme_support( 'post-thumbnails' );
	// Disable Responsive Images
	add_filter( 'max_srcset_image_width', function(){ return 1; } );

	// Remove Default Menu Classes
	add_filter('nav_menu_css_class', 'wpa_discard_menu_classes', 10, 2);
	//Remove IDs from menu
	add_filter('nav_menu_item_id', '__return_false', 10);

	add_filter( 'body_class', 'wpa_body_classes' );

	//Widgets extension
	add_filter('widget_categories_args','show_empty_widget_links');
	add_filter('widget_tag_cloud_args','show_empty_widget_links');

	// remove <p> & <br> from CF7
	add_filter('wpcf7_autop_or_not', '__return_false');
}
add_action( 'init', 'wpa_init', 9999 );

function wpa_dump($variable){
	$pretty = function($v='',$c="&nbsp;&nbsp;&nbsp;&nbsp;",$in=-1,$k=null)use(&$pretty){$r='';if(in_array(gettype($v),array('object','array'))){$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").'<br>';foreach($v as $sk=>$vl){$r.=$pretty($vl,$c,$in+1,$sk).'<br>';}}else{$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").(is_null($v)?'&lt;NULL&gt;':"<strong>$v</strong>");}return$r;};
	echo '<pre style="padding-left: 150px; font-family: Courier New"><code class="json">' . wp_kses_post($pretty($variable)) . '</code></pre>';
}
