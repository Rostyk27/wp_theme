<?php get_header();
global $post; ?>
<section class="content">
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
        <hr/>
    </div>
</section>
<?php get_footer(); ?>

