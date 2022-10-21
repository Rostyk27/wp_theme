<?php
get_header();

$i_query = array(
	'paged' => 1,
	's'     => $s,
);
?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'default', array( 'title' => 'Search Results' ) ); ?>

<section class="search__page">
    <div class="container">
        <div class="search__results">
            <?php if ( function_exists( 'load_search_ajax' ) ) :
                load_search_ajax( $i_query );
            else :
	            if (have_posts()) : while (have_posts()) : the_post();
		            get_template_part( 'tpl-parts/post-items/post', 'item' );
	            endwhile; endif;
            endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>