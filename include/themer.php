<?php
// Custom theme url
function theme($filepath = NULL){
	return preg_replace( '(https?://)', '//', get_stylesheet_directory_uri() . ($filepath?'/' . $filepath:'') );
}

// Run this code on 'after_theme_setup', when plugins have already been loaded.
add_action('after_setup_theme', 'tt_activate_theme');

// This function loads the plugins && update some wordpress options
function tt_activate_theme() {

	// Check to see if your plugin has already been loaded. This can be done in several ways - here are a few examples:
	//
	// Check for a class:
	//	if (!class_exists('MyPluginClass')) {
	//
	// Check for a function:
	//	if (!function_exists('my_plugin_function_name')) {
	//
	// Check for a constant:
	//	if (!defined('MY_PLUGIN_CONSTANT')) {

	if (!class_exists('AssetsMinifyInit')) {
		include_once('plugins/assetsminify/plugin.php');
		update_option('am_async_flag', 0);
	}

	if (!function_exists('ctl_schedule_conversion')) {
		include_once('plugins/cyr-to-lat.php');
	}

	if (!function_exists('jr_uploadresize_options')) {
		include_once('plugins/resize-image-after-upload.php');
	}

	update_option('image_default_link_type','none');
	update_option('uploads_use_yearmonth_folders', 0);
	update_option('permalink_structure', '/%category%/%postname%/');

	add_action('admin_head', 'tinymce_custom_settings');
	function tinymce_custom_settings() {
		global $current_screen;
		if ( $current_screen->id == 'settings_page_tinymce-advanced' ) {
			$json_string = file_get_contents('tinymce-advanced-preconfig.json',TRUE); ?>
			<script type="text/javascript">jQuery(function($) { var tcs_json = '<?php echo trim($json_string); ?>'; $('textarea#tadv-import').val(tcs_json); });</script>
		<?php   }
	}
}

//Remove ACF menu item from
add_filter('acf/settings/show_admin', 'my_acf_show_admin');

function my_acf_show_admin( $show ) {
	return current_user_can('manage_options');
}

//remove wp-logo
function tt_clear_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'tt_clear_admin_bar' );

if (!class_exists('AssetsMinifyInit')) {
	//button for cleaning cache -> AssetsMinify
	function am_remove_cache_btn($wp_admin_bar){
		$args = array(
			'id' => 'am-clear-cache',
			'title' => '&#10006; Clear Assets Cache',
			'href' => get_admin_url() . '?empty_cache=true'
		);
		$wp_admin_bar->add_node($args);
	}
	add_action('admin_bar_menu', 'am_remove_cache_btn', 80);
}

/* ===== Theme Clean/Settings ===== */

// Clean wp_head
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head' );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head' );
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rel_canonical');

// Remove Emoji js/styles
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Remove wp version param from any enqueued scripts
function vc_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

// Clean dashboard
function remove_dashboard_widgets () {
	remove_meta_box('dashboard_quick_press','dashboard','side'); //Quick Press widget
	remove_meta_box('dashboard_recent_drafts','dashboard','side'); //Recent Drafts
	remove_meta_box('dashboard_primary','dashboard','side'); //WordPress.com Blog
	remove_meta_box('dashboard_secondary','dashboard','side'); //Other WordPress News
	remove_meta_box('dashboard_incoming_links','dashboard','normal'); //Incoming Links
	remove_meta_box('dashboard_plugins','dashboard','normal'); //Plugins
	remove_meta_box('rg_forms_dashboard','dashboard','normal'); //Gravity Forms
	remove_meta_box('icl_dashboard_widget','dashboard','normal'); //Multi Language Plugin
	remove_action('welcome_panel','wp_welcome_panel');
	//remove_meta_box('dashboard_activity','dashboard', 'normal'); //Activity
	//remove_meta_box('dashboard_right_now','dashboard', 'normal'); //Right Now
	//remove_meta_box('dashboard_recent_comments','dashboard','normal'); //Recent Comments
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

// Compress HTML
function ob_html_compress($buf){
	return preg_replace(array('/<!--(?>(?!\[).)(.*)(?>(?!\]).)-->/Uis','/[[:blank:]]+/'),array('',' '),str_replace(array("\n","\r","\t"),'',$buf));
}

// HTML5 support for IE
function wp_IEhtml5_js () {
	global $is_IE;
	if ($is_IE)
		echo '<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]--><!--[if lte IE 9]><link href="'.theme().'/style/animations-ie-fix.css" rel="stylesheet" /><![endif]-->';
}
add_action('wp_head', 'wp_IEhtml5_js');

// Disable Responsive Images
add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );

// Filters for WP-API version 1.x
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');

// Filters for WP-API version 2.x
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');

remove_action( 'wp_head', 'rest_output_link_wp_head' );

// Remove recent_comments_style in wp_head
add_action('widgets_init', 'my_remove_recent_comments_style');
function my_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

// Remove ID in menu list
add_filter('nav_menu_item_id', 'clear_nav_menu_item_id', 10, 3);
function clear_nav_menu_item_id($id, $item, $args) {
	return "";
}

add_theme_support( 'post-thumbnails' ); // posts/pages support featured image
add_filter( 'show_admin_bar', '__return_false' ); // remove Admin Bar

// Remove the wordpress update notifications for all users except Super Administrator
if (!current_user_can('update_plugins')) { // checks to see if current user can update plugins
	add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
	add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}

// Disables Kses only for textarea saves
foreach (array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description') as $filter) {
	remove_filter($filter, 'wp_filter_kses');
}

// Disables Kses only for textarea admin displays
foreach (array('term_description', 'link_description', 'link_notes', 'user_description') as $filter) {
	remove_filter($filter, 'wp_kses_data');
}

// Remove site description from RSS Feed
function remove_default_description($bloginfo) {
	$default_tagline = 'Just another WordPress site';
	return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}
add_filter('get_bloginfo_rss', 'remove_default_description');

/* ===== New Body Classes ===== */

function new_body_classes( $classes ){
	if( is_page() ){
		global $post;
		$temp = get_page_template();
		if ( $temp != null ) {
			$path = pathinfo($temp);
			$tmp = $path['filename'] . "." . $path['extension'];
			$tn= str_replace(".php", "", $tmp);
			$classes[] = $tn;
		}
		if (is_active_sidebar('sidebar')) {
			$classes[] = 'with_sidebar';
		}
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

	//qtranslate classes
	if(defined('QTX_VERSION')) {
		$classes[] = 'qtrans-' . qtranxf_getLanguage();
	}

	return $classes;
}
add_filter( 'body_class', 'new_body_classes' );

/* ===== Custom SEO Title ===== */

function seo_title(){
	global $post;
	if(!defined('WPSEO_VERSION')) {
		if(is_404()) {
			echo '404 Page not found - ';
		} elseif((is_single() || is_page()) && $post->post_parent) {
			$parent_title = get_the_title($post->post_parent);
			echo wp_title('-', true, 'right') . $parent_title.' - ';
		} elseif(class_exists('Woocommerce') && is_shop()) {
			echo get_the_title(SHOP_ID) . ' - ';
		} else {
			wp_title('-', true, 'right');
		}
		bloginfo('name');
	} else {
		wp_title();
	}
}

// Convert blogurl
function domain_name($url = '/') {
	return function_exists('qtranxf_convertURL') ? qtranxf_convertURL(site_url($url)) : site_url($url);
}

/* ===== qTranslate/qTranslate X  ===== */

if(defined('QTX_VERSION')) {
	remove_action('wp_head', 'qtranxf_wp_head_meta_generator');
	remove_action('wp_head', 'qtranxf_head', 10, 0);
	remove_action('wp_head', 'qtranxf_wp_head', 10, 0);
	remove_action('wp_head', 'qtrans_header', 10, 0);

	// Custom Links fix
	add_filter('walker_nav_menu_start_el', 'qtrans_in_nav_el', 10, 4);
	function qtrans_in_nav_el($item_output, $item, $depth, $args){
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		// Determine integration with qTranslate Plugin
		if (function_exists('qtranxf_convertURL')) {
			$attributes .= ! empty( $item->url ) ? ' href="' . qtranxf_convertURL(esc_attr( $item->url )) .'"' : '';
		} else {
			$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
		}
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		return $item_output;
	}

	//Add ACF Options page for custom Qtranslate strings
	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page(array(
			'page_title' => 'Translate',
			'menu_title' => 'Translate',
			'menu_slug' => 'acf-translate',
			'capability' => 'edit_posts',
			'post_id' => 'translate',
			'redirect' => false
		));
	}

	//Add JSON to the footer with ACF custom Qtranslate strings
	function acf_qtranslate_strings() {
		$translations = get_fields('translate');
		echo $translations?'<script>window.acftranslate = ' . json_encode($translations, true) . ';</script>':'';
	}
	add_action('wp_footer', 'acf_qtranslate_strings', 10);
}

/* ===== Wordpress Search  ===== */

// Wordpress ?s= redirect to /search/
function tt_search_redirect() {
	global $wp_rewrite;
	if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) { return; }
	$search_base = $wp_rewrite->search_base;
	if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
		wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
		exit();
	}
}
add_action('template_redirect', 'tt_search_redirect');

// Fix for empty search queries redirecting to home page
function tt_request_filter($query_vars) {
	if (isset($_GET['s']) && empty($_GET['s']) && !is_admin()) {
		$query_vars['s'] = ' ';
	}
	return $query_vars;
}
add_filter('request', 'tt_request_filter');

/* ===== WP Login  ===== */

// Changing the logo link from wordpress.org to root domain
function tt_login_url() {  return home_url(); }
add_filter( 'login_headerurl', 'tt_login_url' );

// Changing the alt text on the logo to show your site name
function tt_login_title() { return get_option( 'blogname' ); }
add_filter( 'login_headertitle', 'tt_login_title' );

// Return header 403 for wrong login
function my_login_failed_403() {
	status_header( 403 );
}
add_action( 'wp_login_failed', 'my_login_failed_403' );

//Show empty categories in category widget
function show_empty_widget_links($args) {
	$args['hide_empty'] = 0;
	return $args;
}
add_filter('widget_categories_args','show_empty_widget_links');
add_filter('widget_tag_cloud_args','show_empty_widget_links');

//remove empty title from widget
function foo_widget_title($title) {
	return $title == '&nbsp;' ? '' : $title;
}
add_filter('widget_title', 'foo_widget_title');

//light function fo wp_get_attachment_image_src()
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
	echo '<style>.acf-repeater > table > tbody > tr:nth-child(even) > td.order {color: #fff !important;background-color: '.$color.' !important; text-shadow: none}</style>';
}
add_action('admin_footer', 'acf_repeater_even');

/* Update wp-scss setings
   ========================================================================== */
if (class_exists('Wp_Scss_Settings')) {
	$wpscss = get_option('wpscss_options');
	if (empty($wpscss['css_dir']) && empty($wpscss['scss_dir'])) {
		update_option('wpscss_options', array('css_dir' => '/style/', 'scss_dir' => '/style/', 'compiling_options' => 'scss_formatter_compressed'));
	}
}