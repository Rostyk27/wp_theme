<?php

/*function remove_footer_admin () {
    echo 'Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Theme Developer <a href="http://frontend.im" target="_blank">Tusko Trush</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');*/

// Login area branding styles
function wp_login_candy() {
    wp_enqueue_style( 'wpcandy', theme('inc/admin-assets/admin-area.css'), false );
}
add_action( 'login_enqueue_scripts', 'wp_login_candy', 10 );

add_action( 'admin_enqueue_scripts', 'wpa_media_add_js' );

function wpa_media_add_js($hook) {
    // Check if we are on upload.php and enqueue script
    if ( $hook != 'upload.php' )
        return;
    wp_enqueue_script( 'wpa_media_js', theme('inc/admin-assets/admin-area.js'), array('jquery'), 1.0, true );

    // Make enabled languages visible for javascript
//    global $q_config;
//    wp_localize_script('jquery', 'qtranxsList', array(
//        'enabled_languages' => $q_config['enabled_languages'])
//    );
}

function wpa_media_field_input( $column ) {
    // Set inputs to display in column
    if ( $column == 'wpa_media-column' ) {
        global $post; ?>
    <div id="wrapper-<?php echo $post->ID; ?>" class="tt-m-alt">
        <input type="text" class="large-text" id="alt-<?php echo $post->ID; ?>" value="<?php echo wp_strip_all_tags( __( get_post_meta( $post->ID, '_wp_attachment_image_alt', true ) ) ); ?>" />
        <img class="waiting" src="<?php echo esc_url( admin_url( "images/loading.gif" ) ); ?>" style="display: none" />
    </div>
<?php }
}

add_action( 'manage_media_custom_column', 'wpa_media_field_input' );
add_filter( 'manage_media_columns', 'wpa_media_display_column' );

function wpa_media_display_column( $columns ) {
    // Register the column to display
    $columns['wpa_media-column'] = 'Alternative Text';
    return $columns;
}

function wpa_media_update() {
    // Update
    $wpa_media_post_id = absint ( $_POST['post_id'] );
    $wpa_media_alt_text = wp_strip_all_tags( $_POST['alt_text'] );

    if ( !empty( $_POST['alt_text'] ) ) {
        update_post_meta( $wpa_media_post_id, '_wp_attachment_image_alt', $wpa_media_alt_text );
    }
}
add_action( 'wp_ajax_wpa_media_alt_update' , 'wpa_media_update' );

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


//Allow SVG through WordPress Media Uploader
function wpa_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'wpa_mime_types');

function wpa_fix_svg_thumb() {
    echo '<style>td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {width: 100% !important;height: auto !important}</style>';
}
add_action('admin_head', 'wpa_fix_svg_thumb');

function wpa_svgs_display_thumbs() {
    ob_start();
    add_action( 'shutdown', 'wpa_svgs_thumbs_filter', 0 );
    function wpa_svgs_thumbs_filter() {
        $final = '';
        $ob_levels = count( ob_get_level() );
        for ( $i = 0; $i < $ob_levels; $i++ ) {
            $final .= ob_get_clean();
        }
        echo apply_filters( 'final_output', $final );
    }

    add_filter( 'final_output', 'wpa_svgs_final_output' );
    function wpa_svgs_final_output( $content ) {
        $content = str_replace(
            '<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
            '<# } else if ( \'svg+xml\' === data.subtype ) { #>
                <img class="details-image" src="{{ data.url }}" draggable="false" />
                <# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>', $content );
        $content = str_replace(
            '<# } else if ( \'image\' === data.type && data.sizes ) { #>',
            '<# } else if ( \'svg+xml\' === data.subtype ) { #>
                <div class="centered">
                    <img src="{{ data.url }}" class="thumbnail" draggable="false" />
                </div>
            <# } else if ( \'image\' === data.type && data.sizes ) { #>', $content);
        return $content;
    }
}
add_action('admin_init', 'wpa_svgs_display_thumbs');


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
if (!current_user_can('update_plugins')) { // checks to see if current user can update plugins
    add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
    add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
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
