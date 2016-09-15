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

	wp_enqueue_script('jquery', get_stylesheet_directory_uri(). '/js/libs/_jquery.js', false, null, false);

	if($js_lib = directoryToArray( get_stylesheet_directory(),'/js/libs/', array('js') )) {
		foreach($js_lib as $name => $js){
			wp_enqueue_script($name, $js, array('jquery'), null, true);
		}
	}

	wp_enqueue_script('libs', get_stylesheet_directory_uri(). '/js/lib.js', array('jquery'), null, true);
	wp_enqueue_script('logic', get_stylesheet_directory_uri(). '/js/logic.js', array('libs'), null, true);

	wp_enqueue_style('libs', get_stylesheet_directory_uri(). '/style/elements/libs.css' );
	wp_enqueue_style('scss', get_stylesheet_directory_uri(). '/style/style.css' );

	if(class_exists('Woocommerce')) {
		wp_enqueue_style('custom-woo', get_stylesheet_directory_uri(). '/style/woo.css' );
	}

	wp_enqueue_style('responsive', get_stylesheet_directory_uri(). '/style/rwd.css' );
}
add_action('wp_enqueue_scripts', 'tt_add_jscss');

function getFileExt($path) {
	$pos = strrpos($path, ".");
	if($pos === FALSE){
		return "";
	}else{
		return substr($path, $pos + 1);
	}
}
function fileIgnore($name) {
	if( substr( $name, 0, 1 ) !== "_" ) {
		return $name;
	}
}
function directoryToArray( $abs, $directory, $filterMap = NULL ) {
	$assets = array();
	$dir = $abs . $directory;
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dir. "/" . $file)) {
					if( $filterMap ) {
						if ( in_array(getFileExt($file), $filterMap) ){
							if(fileIgnore($file)) {
								$assets[basename($file)] = get_stylesheet_directory_uri() . $directory . $file;
							}
						}
					} else {
						if(fileIgnore($file)) {
							$assets[basename($file)] = get_stylesheet_directory_uri() . $directory . $file;
						}
					}
				}
			}
		}
		closedir($handle);
	}
	return $assets;
}
