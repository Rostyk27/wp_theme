<?php
get_header();

$file_name = basename(__FILE__, '.php');
wp_enqueue_style( $file_name, get_stylesheet_directory_uri(). '/style/templates/' . $file_name . '.css', null, null );
?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'primary' ); ?>

<?php get_template_part( 'tpl-parts/default-content' ); ?>

<?php get_footer(); ?>
