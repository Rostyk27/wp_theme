<?php

// login area - branding styles
function wp_login_candy() {
    wp_enqueue_style( 'wpcandy', theme('inc/admin-area/admin-area.css'), false );
}
add_action( 'login_enqueue_scripts', 'wp_login_candy', 10 );

// login area - changing the logo link from WordPress.org to current website
function wpa_login_url() {  return home_url(); }
add_filter( 'login_headerurl', 'wpa_login_url' );

// login area - changing default text on the logo to show your site name
function wpa_login_title() { return get_option( 'blogname' ); }
add_filter( 'login_headertext', 'wpa_login_title' );


// dashboard - remove wp-logo inside the dashboard
function wpa_clear_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'wpa_clear_admin_bar' );

// dashboard - remove the WordPress update notifications for all users except Administrator
if( !current_user_can('update_plugins') ) { // checks to see if current user can update plugins
	add_action('init', function() {
		remove_action('init', 'wp_version_check');
	}, 2);
	add_filter('pre_option_update_core', function($a) {
		return null;
	});
}

// dashboard - limit capabilities for Editor user role
function wpa_clear_theme_subpages(){
    global $submenu;
    unset($submenu['themes.php'][5]); // remove Customize link
    unset($submenu['themes.php'][6]); // remove Themes link
}
if ( !current_user_can( 'activate_plugins' ) ) {
    $roleObject = get_role( 'editor' );
    $roleObject->add_cap( 'edit_theme_options' );
    add_action('admin_menu', 'wpa_clear_theme_subpages');
}

// dashboard - clean dashboard meta_boxes
function wpa_remove_dashboard_widgets () {
	remove_meta_box('dashboard_quick_press','dashboard','side'); // Quick Press widget
	remove_meta_box('dashboard_primary','dashboard','side');     // WordPress.com widget event and news
	//remove_meta_box('dashboard_activity','dashboard', 'normal'); //Activity
	//remove_action('welcome_panel','wp_welcome_panel');
	//remove_meta_box('dashboard_plugins','dashboard','normal'); //Plugins
	//remove_meta_box('dashboard_incoming_links','dashboard','normal'); //Incoming Links
	//remove_meta_box('dashboard_recent_drafts','dashboard','side'); //Recent Drafts
	//remove_meta_box('dashboard_secondary','dashboard','side'); //Other WordPress News
	//remove_meta_box('dashboard_right_now','dashboard', 'normal'); //Right Now
	//remove_meta_box('dashboard_recent_comments','dashboard','normal'); //Recent Comments
}
add_action('wp_dashboard_setup', 'wpa_remove_dashboard_widgets');

// dashboard - disable fullscreen mode when editing page/post
/*if ( is_admin() ) {
	function jba_disable_editor_fullscreen_by_default() {
		$script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
		wp_add_inline_script( 'wp-blocks', $script );
	}
	add_action( 'enqueue_block_editor_assets', 'jba_disable_editor_fullscreen_by_default' );
}*/


// general - disable comments for media
function filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	if( $post->post_type == 'attachment' ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );

// general - custom image sizes in media editor
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

// general - wp 6.0 - remove .wp-container# inline styles
remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
add_filter( 'render_block', function( $block_content, $block ) {
	if ( $block['blockName'] === 'core/columns' ) {
		return $block_content;
	}
	if ( $block['blockName'] === 'core/column' ) {
		return $block_content;
	}
	if ( $block['blockName'] === 'core/group' ) {
		return $block_content;
	}
	return wp_render_layout_support_flag( $block_content, $block );
}, 10, 2 );

// general - remove admin bar on front end
add_filter( 'show_admin_bar', '__return_false' );
