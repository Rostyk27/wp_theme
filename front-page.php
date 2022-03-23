<?php
get_header();

$thumb_id = get_post_thumbnail_id( get_the_ID() );
?>

<section class="top_panel top_panel__primary">
	<?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
        <picture>
            <source media="(max-width: 480px)" srcset="<?php echo wp_get_attachment_image_url( $thumb_id, 'mob_size' ); ?>">
			<?php echo wp_get_attachment_image( $thumb_id, 'full', false, array( 'alt' => get_alt( get_the_ID() ), 'class' => 'object_fit' ) ); ?>
        </picture>
	<?php endif; ?>

    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); if ( get_the_content() ) : ?>
    <section class="content container">
        <?php the_content(); ?>
    </section>
<?php endif; endwhile; endif; ?>

<?php get_footer(); ?>
