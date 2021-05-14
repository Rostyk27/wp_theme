<article class="post_item">
	<figure class="post_item__thumb">
		<a href="<?php the_permalink(); ?>">
			<img src="<?php echo esc_url(image_src( get_post_thumbnail_id( $post->ID ), 'custom_gallery' )); ?>" alt="<?php the_title(); ?>">
		</a>
	</figure>
	<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p><?php echo has_excerpt() ? wp_kses_post( get_the_excerpt() ) : wp_kses_post( wp_trim_words( get_the_content(), 30 ) ); ?></p>
</article>