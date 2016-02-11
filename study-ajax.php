<?php

//http://pp.dev.belugalab.com/news/
//http://blog.autolightpros.com/

'
ajax_url = "http://pp.dev.belugalab.com/wp-admin/admin-ajax.php";
$ = jQuery;

$.ajax({
    type: "post",
    url: ajax_url,
    data: $(this).serialize() + "&action=tg_send_form",
    success: function(html) {
	alert(html);
}
});
';

function tg_load_posts() {

	$post_type = $_POST['post_type'] ? $_POST['post_type'] : 'post';
	$paged = $_POST['page'] ? $_POST['page'] : 1;

	$sticky = get_option( 'sticky_posts' );

	$args = array(
		'post_type' => $post_type,
		'paged' => $paged,
		'post_status' => 'publish',
		'post__not_in' => $sticky,
	);
	$the_query = new WP_Query( $args );
	$max_pages = $the_query->max_num_pages;
	global $post;
	if ( $the_query->have_posts() ) :
		echo '<div class="new_items">';
		while ( $the_query->have_posts() ) : $the_query->the_post();
			get_template_part( 'loop', 'posts' );
		endwhile;
		echo '</div>';
	endif;

	if( $max_pages == $paged ) {echo "<style>#lm{opacity:0;visibility:hidden;height:0;margin:0;padding:0;overflow:hidden}</style>";}

	wp_reset_postdata();
	exit();
}

add_action( 'wp_ajax_tg_load_posts', 'tg_load_posts' );
add_action( 'wp_ajax_nopriv_tg_load_posts', 'tg_load_posts' );
