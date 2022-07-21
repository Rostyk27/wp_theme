<?php
get_header();

tpl_style( 'page' );
?>

<?php get_template_part( 'tpl-parts/top-panels/top-panel', 'default', array( 'title' => 'Error 404' ) ); ?>

<div class="page_404 default_page container">
    <div class="content">
        <p>Sorry, this page doesn't exist or has been removed.</p>
        <a href="<?php echo esc_url( site_url() ); ?>" class="button">Go back home</a>
    </div>
</div>

<?php get_footer(); ?>
