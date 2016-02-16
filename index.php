<?php get_header(); ?>
<section class="content">
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
            <p>testing</p>
        <?php endwhile; endif; ?>
    </div>
</section>
<?php get_footer(); ?>
