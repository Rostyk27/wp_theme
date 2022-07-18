<?php
get_header();

$file_name = basename(__FILE__, '.php');
tpl_style( $file_name );
?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'primary' ); ?>

<?php get_template_part( 'tpl-parts/default', 'content' ); ?>

<?php get_footer(); ?>
