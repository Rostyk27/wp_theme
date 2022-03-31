<?php

// run pre-installed plugins
require_once('inc/themer.php');

// uncomment if need CPT
//require_once('inc/cpt.php');

// register menus
register_nav_menus(array(
    'main_menu' => 'Main menu'
));

// custom images sizes
add_image_size('full', '1920', '', true);
add_image_size('mob_size', '480', '', true);
add_image_size('mob_slider', '480', '320', true);
add_image_size('top_default', '1095', '616', true);
add_image_size('custom_gallery', '525', '395', true);

// get post taxonomy
function custom_tax($pid, $tax) {
	if ( get_the_terms( $pid, $tax ) ) {
		$post_tax = get_the_terms( $pid, $tax );
		$taxs = '';
		$co = count( $post_tax );
		$i = 1;
		foreach ( $post_tax as $t ) {
			$tax = get_term( $t );
			$taxs .= '<span class="tax_term">' . $tax->name . '</span>' . ( $i ++ != $co ? '<span>,</span> ' : '' );
		}

		return $taxs;
	}
}

// custom templates slugs to use with custom_tax_linked() function
const CUSTOM_TEMPLATE_SLUG = '/custom-post-type/';

// get post taxonomy as hash with related template slug
function custom_tax_linked($pid, $tax, $template_slug) {
	if ( get_the_terms($pid, $tax) ) {
		$post_tax = get_the_terms( $pid, $tax );
		$taxs = '';
		$co = count( $post_tax );
		$i = 1;
		foreach ( $post_tax as $t ) {
			$tax = get_term( $t );
			$taxs .= '<a href="' . $template_slug . '#' . $tax->slug . '" class="tax_term">' . $tax->name . '</a>' . ( $i ++ != $co ? '<span>,</span> ' : '' );
		}

		return $taxs;
	}
}