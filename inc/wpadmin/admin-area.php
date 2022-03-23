<?php

/*function remove_footer_admin () {
	echo '<i>Powered by</i> <a href="http://www.wordpress.org" target="_blank" rel="noopener">WordPress</a> | <i>Theme Development</i> <a href="#dev-url" target="_blank" rel="noopener">dev-name</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');*/


// Login area branding styles
function wp_login_candy() {
    wp_enqueue_style( 'wpcandy', theme('inc/wpadmin/admin-area.css'), false );
}
add_action( 'login_enqueue_scripts', 'wp_login_candy', 10 );


// Custom rules for editor
function wpa_clear_theme_subpages(){
    global $submenu;
    unset($submenu['themes.php'][5]); // remove customize link
    unset($submenu['themes.php'][6]); // remove themes link
}

if ( !current_user_can( 'activate_plugins' )) {
    $roleObject = get_role( 'editor' );
    $roleObject->add_cap( 'edit_theme_options' );
    add_action('admin_menu', 'wpa_clear_theme_subpages');
}


// Custom Image Sizes to Media Editor
function wpa_custom_image_choose( $sizes ) {
    global $_wp_additional_image_sizes;
    $custom = array();
    if(isset($_wp_additional_image_sizes)) {
        foreach( $_wp_additional_image_sizes as $key => $value ) {
            $custom[ $key ] = ucwords( str_replace( array('-', '_'), ' ', $key ) );
        }
    }
    return array_merge( $sizes, $custom );
}
add_filter( 'image_size_names_choose', 'wpa_custom_image_choose', 999 );


//Remove ACF menu item from
add_filter('acf/settings/show_admin', 'my_acf_show_admin');

function my_acf_show_admin( $show ) {
    return current_user_can('manage_options');
}


//remove wp-logo
function wpa_clear_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'wpa_clear_admin_bar' );


// Clean dashboard
function wpa_remove_dashboard_widgets () {
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
add_action('wp_dashboard_setup', 'wpa_remove_dashboard_widgets');


//remore admin bar
add_filter( 'show_admin_bar', '__return_false' ); // remove Admin Bar


// Remove the wordpress update notifications for all users except Super Administator
if( ! current_user_can('update_plugins')) { // checks to see if current user can update plugins
	add_action('init', function() {
		remove_action('init', 'wp_version_check');
	}, 2);
	add_filter('pre_option_update_core', function($a) {
		return null;
	});
}


// Changing the logo link from wordpress.org to root domain
function wpa_login_url() {  return home_url(); }
add_filter( 'login_headerurl', 'wpa_login_url' );


// Changing the alt text on the logo to show your site name
function wpa_login_title() { return get_option( 'blogname' ); }
add_filter( 'login_headertitle', 'wpa_login_title' );


// Return header 403 for wrong login
function my_login_failed_403() {
    status_header( 403 );
}
add_action( 'wp_login_failed', 'my_login_failed_403' );


// disable fullscreen when editing page/post
if (is_admin())
{
	function jba_disable_editor_fullscreen_by_default()
	{
		$script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
		wp_add_inline_script( 'wp-blocks', $script );
	}

	add_action( 'enqueue_block_editor_assets', 'jba_disable_editor_fullscreen_by_default' );
}
