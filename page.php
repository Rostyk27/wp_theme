<?php get_header(); ?>

<section class="top_panel default_panel" style="<?php echo (has_post_thumbnail() ? image_src( get_post_thumbnail_id( $post->ID ), 'top_default', true ) : 'background-image: url('. theme('images/top_default.jpg') .')'); ?>">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<?php if (have_posts()) : while (have_posts()) : the_post(); if ( get_the_content() ) : ?>
    <section class="content container">
        <?php the_content(); ?>
    </section>
<?php endif; endwhile; endif; ?>

<?php get_footer(); ?>
