<?php get_header(); ?>
<section class="content page404">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <p>Sorry, this page doesn't exist or has been removed.</p>
        <a href="<?php echo site_url(); ?>" class="button">Go back home</a>
    </div>
</section>
<?php get_footer(); ?>
