<?php

/*
 * @package    TGM-Plugin-Activation
 * @subpackage Recommended
 * @version    2.4.0
 * @author     Thomas Griffin <thomasgriffinmedia.com>
 * @author     Gary Jones <gamajo.com>
 * @copyright  Copyright (c) 2014, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
*/

require_once('class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

function my_theme_register_required_plugins() {
    $plugins = array(
//        array(
//            'name'               => 'TGM Example Plugin', // The plugin name.
//            'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
//            'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
//            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
//            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
//            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
//            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
//            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
//        ),
//        array(
//            'name'               => 'TGM New Media Plugin', // The plugin name.
//            'slug'               => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
//            'source'             => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
//            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
//            'external_url'       => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
//        ),

        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false,
        ),
        /*array(
            'name'      => 'Contact Form 7 Controls',
            'slug'      => 'contact-form-7-extras',
            'required'  => false,
        ),
        array(
            'name'      => 'Contact Form 7 Lead info with country',
            'slug'      => 'contact-form-7-lead-info-with-country',
            'required'  => false,
        ),*/
        array(
            'name'      => 'TinyMCE Advanced',
            'slug'      => 'tinymce-advanced',
            'required'  => false,
        ),
        array(
            'name'      => 'WP Migrate DB',
            'slug'      => 'wp-migrate-db',
            'required'  => false,
        ),
        array(
            'name'      => 'AJAX Thumbnail Rebuild',
            'slug'      => 'ajax-thumbnail-rebuild',
            'required'  => false,
        ),
        array(
            'name'      => 'Drag & Drop Featured Image',
            'slug'      => 'drag-drop-featured-image',
            'required'  => false,
        ),
        array(
            'name'      => 'Quick Featured Images',
            'slug'      => 'quick-featured-images',
            'required'  => false,
        ),
        array(
            'name'      => 'WP No Category Base',
            'slug'      => 'wp-no-category-base',
            'required'  => false,
        ),
	    /*array(
		    'name' => 'Post Thumbnail Editor',
		    'slug' => 'post-thumbnail-editor',
		    'required' => true,
	    ),*/
	    array(
		    'name' => 'Optimize Database after Deleting Revisions',
		    'slug' => 'rvg-optimize-database',
		    'required' => false,
	    ),
	    /*array(
		    'name' => 'Wp-scss',
		    'slug' => 'wp-scss',
		    'required' => true,
	    ),*/
        array(
            'name'               => 'Advanced Custom Fields: PRO',
            'slug'               => 'advanced-custom-fields-pro',
            'source'             => get_stylesheet_directory() . '/inc/plugins/advanced-custom-fields-pro.zip',
            'required'           => true,
            'version'            => '',
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => 'http://www.advancedcustomfields.com/pro/', // If set, overrides default API URL and points to an external URL.
        )
    );
    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tgmpa' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'tgmpa' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'tgmpa' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}
