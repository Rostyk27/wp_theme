<?php get_header(); ?>
<section class="content">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <h2><?php the_title(); ?></h2>
            <?php the_post_thumbnail('single'); ?>
            <time datetime="<?php echo get_the_date('F j, Y'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
            <div class="author_name">Author:
                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
            </div>
            <?php the_content(); ?>
            <div class="tags_list"><?php the_tags(''); ?></div>
            <?php if(function_exists('comments_template')) {
                comments_template();
            } ?>
            <!-- next & prev post? -->
        <?php endwhile; endif; ?>
    </div>
</section>
<?php get_footer(); ?>
