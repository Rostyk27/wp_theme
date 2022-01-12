<article class="post_item">
	<figure class="post_item__thumb">
		<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php $img_id = get_post_thumbnail_id( get_the_ID() ); ?>
            <?php echo wp_get_attachment_image( $img_id, 'custom_gallery', false, array( 'alt' => get_alt( $img_id ) ) ); ?>
		</a>
	</figure>
	<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p><?php echo has_excerpt() ? wp_kses_post( get_the_excerpt() ) : wp_kses_post( wp_trim_words( get_the_content(), 30 ) ); ?></p>
</article>