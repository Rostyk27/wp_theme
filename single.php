<?php
get_header();

$file_name = basename(__FILE__, '.php');
tpl_style( $file_name );
?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'default', array( 'container_class' => 'is_8' ) ); ?>

<?php get_template_part( 'tpl-parts/single/single', 'meta' ); ?>

<?php get_template_part( 'tpl-parts/single/single', 'thumb' ); ?>

<?php get_template_part( 'tpl-parts/default', 'content', array( 'class' => 'single_post__content is_8' ) ); ?>

<?php get_footer(); ?>
