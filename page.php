<?php get_header(); ?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'secondary' ); ?>

<div class="default_page">
	<?php get_template_part( 'tpl-parts/gutenberg' ); ?>
</div>

<?php
$file_name = basename(__FILE__, '.php');
tpl_style( $file_name );

get_footer();
?>
