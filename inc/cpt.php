<?php
// example for Custom Post Type with Taxonomies

// you can use dash-icons https://developer.wordpress.org/resource/dashicons/

// use this arg if post-type shouldn't have single pages
// 'publicly_queryable' => false


/**
 * custom taxonomy args
 *
 * @param      $tax_name
 * @param      $tax_plural
 * @param null $new_slug    // if not set - $taxonomy slug will be used as default
 * @param bool $is_in_menu  // set to 'false' if there's a need to hide terms from nav_menu
 *
 * @return array
 */
function tax_args_arr( $tax_name, $tax_plural, $new_slug = null, $is_in_menu = true ) {
	$tax_labels = array(
		'name'                       => $tax_name,
		'singular_name'              => $tax_name,
		'search_items'               => 'Search ' . $tax_name,
		'popular_items'              => 'Popular ' . $tax_name,
		'all_items'                  => 'All ' . $tax_plural,
		'parent_item'                => 'Parent ' . $tax_name,
		'edit_item'                  => 'Edit ' . $tax_name,
		'update_item'                => 'Update ' . $tax_name,
		'add_new_item'               => 'Add New ' . $tax_name,
		'new_item_name'              => 'New ' . $tax_name,
		'separate_items_with_commas' => 'Separate ' . $tax_plural . ' with commas',
		'add_or_remove_items'        => 'Add or remove ' . $tax_plural,
		'choose_from_most_used'      => 'Choose from most used ' . $tax_plural
	);

	return array(
		'label'             => $tax_name,
		'labels'            => $tax_labels,
		'public'            => true,
		'show_in_rest'      => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => $is_in_menu,
		'args'              => array( 'orderby' => 'term_order' ),
		'rewrite'           => array( 'slug' => $new_slug, 'hierarchical' => true ),
	);
}


add_action( 'init', 'register_cpts' );

function register_cpts() {

	// args & register - taxonomy "custom_taxonomy"
	$custom_tax_args = tax_args_arr( 'Taxonomy', 'Taxonomies' );

	register_taxonomy( 'custom_taxonomy', 'custom_post_type', $custom_tax_args );


	// cpt "custom_post_type"
	register_post_type( 'custom_post_type',
		array(
			'labels'            => array(
				'name'          => 'Custom post type',
				'singular_name' => 'Custom post type Singular',
			),
			'public'            => true,
			'show_in_rest'      => true,
			'show_in_nav_menus' => false,
			'menu_icon'         => 'dashicons-portfolio',
			'rewrite'           => array( 'slug' => 'permalink' ),
			'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt' ), // 'author'
		)
	);

    if( defined('WP_DEBUG') && true !== WP_DEBUG) { flush_rewrite_rules(); }
}
