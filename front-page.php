<?php get_header(); ?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'primary' ); ?>

<?php get_template_part( 'tpl-parts/gutenberg' ); ?>

<?php
$file_name = basename(__FILE__, '.php');
tpl_style( $file_name );

get_footer();
?>
