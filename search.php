<?php
get_header();

$i_query = array(
	'paged' => 1,
	's'     => $s,
);
?>

<section class="top_panel top_panel__default">
    <div class="container">
        <h1><span>Search Results</span></h1>
    </div>
</section>

<section class="search__page">
    <div class="container">
        <div class="search__results">
            <?php if ( function_exists( 'load_search_ajax' ) ) :
                load_search_ajax( $i_query );
            else :
	            if (have_posts()) : while (have_posts()) : the_post();
		            get_template_part( 'tpl-parts/post-item' );
	            endwhile; endif;
            endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>