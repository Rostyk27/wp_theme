<?php
$thumb_id = get_post_thumbnail_id( get_the_ID() );
?>

<section class="top_panel top_panel__secondary">
	<?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
		<figure>
			<?php echo wp_get_attachment_image( $thumb_id, 'full', false, array( 'alt' => get_alt( $thumb_id ), 'class' => 'object_fit' ) ); ?>
		</figure>
	<?php endif; ?>

	<div class="container">
		<h1><?php the_title(); ?></h1>
	</div>
</section>
