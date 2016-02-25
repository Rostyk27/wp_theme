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

add_action( 'admin_enqueue_scripts', 'tt_media_add_js' );

function tt_media_add_js($hook) {
    // Check if we are on upload.php and enqueue script
    if ( $hook != 'upload.php' )
        return;
    wp_enqueue_script( 'tt_media_js', theme('inc/admin-assets/admin-area.js'), array('jquery'), 1.0, true );

    // Make enabled languages visible for javascript
//    global $q_config;
//    wp_localize_script('jquery', 'qtranxsList', array(
//        'enabled_languages' => $q_config['enabled_languages'])
//    );
}

function tt_media_field_input( $column ) {
    // Set inputs to display in column
    if ( $column == 'tt_media-column' ) {
        global $post; ?>
    <div id="wrapper-<?php echo $post->ID; ?>" class="tt-m-alt">
        <input type="text" class="large-text" id="alt-<?php echo $post->ID; ?>" value="<?php echo wp_strip_all_tags( __( get_post_meta( $post->ID, '_wp_attachment_image_alt', true ) ) ); ?>" />
        <img class="waiting" src="<?php echo esc_url( admin_url( "images/loading.gif" ) ); ?>" style="display: none" />
    </div>
<?php }
}

add_action( 'manage_media_custom_column', 'tt_media_field_input' );
add_filter( 'manage_media_columns', 'tt_media_display_column' );

function tt_media_display_column( $columns ) {
    // Register the column to display
    $columns['tt_media-column'] = 'Alternative Text';
    return $columns;
}


function tt_media_update() {
    // Update
    $tt_media_post_id = absint ( $_POST['post_id'] );
    $tt_media_alt_text = wp_strip_all_tags( $_POST['alt_text'] );

    if ( !empty( $_POST['alt_text'] ) ) {
        update_post_meta( $tt_media_post_id, '_wp_attachment_image_alt', $tt_media_alt_text );
    }

}

add_action( 'wp_ajax_tt_media_alt_update' , 'tt_media_update' );
