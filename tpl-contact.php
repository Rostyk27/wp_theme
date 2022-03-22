<?php get_header();
/*Template Name: Contact*/
wp_enqueue_script( 'selectric', get_stylesheet_directory_uri() . '/js/libs/selectric.js', array( 'jquery' ), null, true );
?>

<section class="top_panel top_panel__secondary">
    <picture>
        <source media="(max-width: 480px)"
                srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'mob_size' ); ?>">
		<?php echo wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'full', false, array(
			'alt'   => get_alt( get_the_ID() ),
			'class' => 'object_fit'
		) ); ?>
    </picture>
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>


<section class="default_page container">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		if ( get_the_content() ) : ?>
			<div class="content">
                <?php the_content(); ?></div>
		<?php endif; endwhile; endif; ?>
    <?php echo do_shortcode('[contact-form-7 id="5" title="Contact form 1"]'); ?>
</section>


<?php get_footer(); ?>
