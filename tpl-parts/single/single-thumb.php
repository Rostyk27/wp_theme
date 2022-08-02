<?php if ( has_post_thumbnail() ) :
	$thumb_id = get_post_thumbnail_id( get_the_ID() ); ?>
	<div class="single_post__thumb container is_8">
		<figure>
			<picture>
				<source media="(max-width: 480px)" srcset="<?php echo wp_get_attachment_image_url( $thumb_id, 'mob_size' ); ?>">
				<?php echo wp_get_attachment_image( $thumb_id, 'top_default', false, array( 'alt' => get_alt( $thumb_id ), 'class' => 'object_fit' ) ); ?>
			</picture>

			<?php if ( get_the_post_thumbnail_caption() ) : ?>
				<figcaption>
					<?php the_post_thumbnail_caption(); ?>
				</figcaption>
			<?php endif; ?>
		</figure>
	</div>
<?php endif; ?>