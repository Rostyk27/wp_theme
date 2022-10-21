<?php get_header(); ?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'default', array( 'container_class' => 'is_8' ) ); ?>

<?php get_template_part( 'tpl-parts/single/single', 'meta' ); ?>

<?php get_template_part( 'tpl-parts/single/single', 'thumb' ); ?>

<div class="single_post__content">
	<?php get_template_part( 'tpl-parts/gutenberg', null, array( 'class' => 'is_8' ) ); ?>
</div>

<?php
$file_name = basename(__FILE__, '.php');
tpl_style( $file_name );

get_footer();
?>
