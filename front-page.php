<?php get_header(); ?>

<section class="top_panel top_panel__primary">
    <picture>
        <source media="(max-width: 480px)"
                srcset="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'mob_size' ); ?>">
		<?php echo wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'full', false, array( 'alt'   => get_alt( get_the_ID() ),
		                                                                                                 'class' => 'object_fit'
		) ); ?>
    </picture>
</section>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
	if ( get_the_content() ) : ?>
        <section class="content container">
            <h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
        </section>
	<?php endif; endwhile; endif; ?>

<?php get_footer(); ?>
