<?php
get_header();

$file_name = basename(__FILE__, '.php');
tpl_style( $file_name );
?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'secondary' ); ?>

<?php get_template_part( 'tpl-parts/default', 'content', array( 'class' => 'default_page' ) ); ?>

<?php get_footer(); ?>
