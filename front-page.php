<?php get_header(); ?>
<section class="top_panel primary_panel" style="<?php echo (has_post_thumbnail() ? image_src( get_post_thumbnail_id( $post->ID ), 'full', true ) : 'background-image: url('. theme('images/top_primary.jpg') .')'); ?>">
    <?php if (have_posts()) : while (have_posts()) : the_post(); if ( get_the_content() ) : ?>
        <div class="container">
            <?php the_content(); ?>
        </div>
    <?php endif; endwhile; endif; ?>
</section>
<?php get_footer(); ?>
