<?php

// Theme globals
require_once('include/defines.php');

// Recommended plugins installer
require_once 'include/plugins/installer.php';

// Run pre-installed plugins
require_once('include/themer.php');

// Include custom assets
require_once('include/assets.php');

// Custom admin area functions
require_once('include/admin-assets/admin-addons.php');

// Custom shortcodes
require_once('include/shortcodes.php');

// Custom Posts Duplicator
require_once('include/duplicator.php');

// uncomment if need CPT
//require_once('inc/custom-cpt.php');

// Custom breadcrumbs
//require_once('inc/breadcrumbs.php');

//register menus
register_nav_menus(array(
    'main_menu' => 'Main menu'
));

//images sizes
//add_image_size( 'image_name', 'x', 'y', true );

//register sidebar
$reg_sidebars = array (
	'page_sidebar'     => 'Page Sidebar',
	'blog_sidebar'     => 'Blog Sidebar'
);
foreach ( $reg_sidebars as $id => $name ) {
	register_sidebar(
		array (
			'name'          => __( $name ),
			'id'            => $id,
			'before_widget' => '<div class="widget cfx %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<mark class="widget-title">',
			'after_title'   => '</mark>',
		)
	);
}

if(function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title'    => 'Theme General Settings',
		'menu_title'    => 'Theme Settings',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	));
}

function get_alt($id){
	$c_alt = get_post_meta($id, '_wp_attachment_image_alt', true);
	$c_tit = get_the_title($id);
	return $c_alt?$c_alt:$c_tit;
}

function cats($pid){
	$post_categories = wp_get_post_categories($pid);
	$cats = '';
	$co = count($post_categories); $i = 1;
	foreach($post_categories as $c){
		$cat = get_category($c);
		$cats .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a>' .($i++ != $co?'<span>,</span> ':'');
	}
	return $cats;
}

function transliterate($textcyr = null, $textlat = null) {
	$cyr = array(
		'û', ' ', 'º', '¿', 'æ',  '÷',  'ù',   'ø',  'þ',  'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', '³', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ú', 'ü', 'ÿ',
		'Û','ª', '¯', 'Æ',  '×',  'Ù',   'Ø',  'Þ',  'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', '²', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ú', 'Ü', 'ß');
	$lat = array(
		'y', '_', 'ye', 'yi', 'zh', 'ch', 'sht', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', 'x', 'ya',
		'Y','Ye', 'Yi', 'Zh', 'Ch', 'Sht', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', 'Y', 'X', 'Ya');
	if($textcyr) return str_replace($cyr, $lat, $textcyr);
	else if($textlat) return str_replace($lat, $cyr, $textlat);
	else return null;
}

function get_current_url() {
	$pageURL = 'http';
	if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return str_replace('www.', '', $pageURL);
}

/*function example_ajax(){
	extract($_POST);

	var_dump($action);

	exit;
}
add_action('wp_ajax_example_ajax', 'example_ajax');
add_action('wp_ajax_nopriv_example_ajax', 'example_ajax');*/