<?php wp_enqueue_script( 'selectric', get_stylesheet_directory_uri() . '/js/libs/selectric.js', array( 'jquery' ), null, true ); ?>

<?php get_template_part( 'tpl-parts/filters/post-filters/filter', 'taxonomy', array( 'tax' => 'category', 'label' => 'Categories' ) ); ?>
