<?php get_header(); ?>

<?php
$title = is_home() ? get_the_title( BLOG_ID ) : get_the_archive_title();
get_template_part( 'tpl-parts/top-panels/top-panel', 'default', array( 'title' => $title ) );
?>

<section class="posts__holder">
    <div class="container">
        <div class="posts__container">
            <?php if ( function_exists( 'load_posts_ajax') ) :
	            load_posts_ajax();
            else :
	            if (have_posts()) : while (have_posts()) : the_post();
		            get_template_part( 'tpl-parts/post-item' );
                endwhile; endif;
            endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
