<?php
get_header();
/* Template Name: Contact */

wp_enqueue_script( 'selectric', get_stylesheet_directory_uri() . '/js/libs/selectric.js', array( 'jquery' ), null, true );

$file_name = basename(__FILE__, '.php');
tpl_style( $file_name );
?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'secondary' ); ?>

<section class="default_page">
	<?php get_template_part( 'tpl-parts/default', 'content' ); ?>

    <div class="container">
        <?php echo do_shortcode('[contact-form-7 id="5" title="Contact form 1"]'); ?>
    </div>
</section>

<?php get_footer(); ?>
