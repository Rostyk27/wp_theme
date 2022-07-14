<?php
if ( !empty( $args ) ) $part_args = $args;
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
	if ( get_the_content() ) : ?>
        <div class="container<?php echo $part_args['class'] ? ' ' . $part_args['class'] : ''; ?>">
            <div class="content">
				<?php the_content(); ?>
            </div>
        </div>
	<?php endif;
endwhile; endif; ?>