<article class="post_item">
	<figure class="post_item__thumb">
		<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php $img_id = get_post_thumbnail_id( $post->ID ); ?>
            <img src="<?php echo esc_url( image_src( $img_id, 'custom_gallery' ) ); ?>" alt="<?php echo esc_attr( get_alt( $img_id ) ); ?>">
		</a>
	</figure>
	<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p><?php echo has_excerpt() ? wp_kses_post( get_the_excerpt() ) : wp_kses_post( wp_trim_words( get_the_content(), 30 ) ); ?></p>
</article>