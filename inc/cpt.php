<?php
// example for Custom Post Type with Taxonomies

// you can use dash-icons https://developer.wordpress.org/resource/dashicons/


/**
 * custom taxonomy args
 *
 * @param $tax_name
 *
 * @return array
 */
function tax_args_arr($tax_name) {
	$tax_labels = array(
		'name'                       => $tax_name,
		'singular_name'              => $tax_name,
		'search_items'               => 'Search ' . $tax_name,
		'popular_items'              => 'Popular ' . $tax_name,
		'all_items'                  => 'All ' . $tax_name . 's',
		'parent_item'                => 'Parent ' . $tax_name,
		'edit_item'                  => 'Edit ' . $tax_name,
		'update_item'                => 'Update ' . $tax_name,
		'add_new_item'               => 'Add New ' . $tax_name,
		'new_item_name'              => 'New ' . $tax_name,
		'separate_items_with_commas' => 'Separate ' . $tax_name . 's with commas',
		'add_or_remove_items'        => 'Add or remove ' . $tax_name . 's',
		'choose_from_most_used'      => 'Choose from most used ' . $tax_name . 's'
	);

	return array(
		'label'             => $tax_name,
		'labels'            => $tax_labels,
		'public'            => true,
		'hierarchical'      => true,
		'show_in_nav_menus' => true,
		'args'              => array( 'orderby' => 'term_order' ),
		'query_var'         => true,
		'show_ui'           => true,
		'rewrite'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
	);
}


/**
 * custom taxonomy args - when plural is custom
 *
 * @param $tax_name
 * @param $tax_name_plural
 *
 * @return array
 */
function tax_args_arr_plural($tax_name, $tax_name_plural) {
	$tax_labels = array(
		'name'                       => $tax_name,
		'singular_name'              => $tax_name,
		'search_items'               => 'Search ' . $tax_name,
		'popular_items'              => 'Popular ' . $tax_name,
		'all_items'                  => 'All ' . $tax_name_plural,
		'parent_item'                => 'Parent ' . $tax_name,
		'edit_item'                  => 'Edit ' . $tax_name,
		'update_item'                => 'Update ' . $tax_name,
		'add_new_item'               => 'Add New ' . $tax_name,
		'new_item_name'              => 'New ' . $tax_name,
		'separate_items_with_commas' => 'Separate ' . $tax_name_plural . ' with commas',
		'add_or_remove_items'        => 'Add or remove ' . $tax_name_plural,
		'choose_from_most_used'      => 'Choose from most used ' . $tax_name_plural
	);

	return array(
		'label'             => $tax_name,
		'labels'            => $tax_labels,
		'public'            => true,
		'hierarchical'      => true,
		'show_in_nav_menus' => true,
		'args'              => array( 'orderby' => 'term_order' ),
		'query_var'         => true,
		'show_ui'           => true,
		'rewrite'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
	);
}


add_action( 'init', 'register_cpts' );

function register_cpts() {

	// args for taxonomy "custom_taxonomy_name"
	$tax_arr  = tax_args_arr( 'Taxonomy Name' );
	// taxonomy "custom_taxonomy_name" attached to cpt "custom_post_type"
	register_taxonomy( 'custom_taxonomy_name', 'custom_post_type', $tax_arr );

	// cpt "custom_post_type"
	register_post_type( 'custom_post_type',
		array(
			'labels'            => array(
				'name'          => 'Custom Post Type',
				'singular_name' => 'Custom Post Type',
				'menu_name'     => 'Custom Post Type'
			),
			'public'            => true,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'rewrite'           => array( 'slug' => 'permalink' ),
			'has_archive'       => true,
			'hierarchical'      => true,
			'show_in_nav_menus' => true,
			'capability_type'   => 'page',
			'query_var'         => true,
			'show_in_rest'      => true,
			'menu_icon'         => 'dashicons-admin-page',
		) );

    if( defined('WP_DEBUG') && true !== WP_DEBUG) {
        flush_rewrite_rules();
    }
}
