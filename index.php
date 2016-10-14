<?php get_header();  /*$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;*/
if(is_home()) {
    $queryname = 'Blog';
} else {
    $queryname = 'Archive of ' . get_the_archive_title();
}
?>
<h1><?php echo $queryname ?></h1>
<section class="content">
    <div class="container aparent">
        <article>
            <h2><?php echo get_the_title(BLOG_ID); ?></h2>
            <div class="posts">
                <?php if (have_posts()) : $p = 0; while (have_posts()) : the_post(); ?>
                    <?php if($p == 0 /*&& $paged == 1*/) { ?>
                        <div class="firstpost blogpost">
                            <a class="thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('single');?></a>
                            <time datetime="<?php echo get_the_date('F j, Y'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo wp_trim_words(get_the_content(), 65, ''); ?>
                                <span class="rm">
                                    <a href="<?php the_permalink(); ?>">Read More</a>
                                </span>
                            </p>
                        </div>
                    <?php } else { ?>
                        <div class="blogpost">
                            <a  class="thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog');?></a>
                            <time datetime="<?php echo get_the_date('F j, Y'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo wp_trim_words(get_the_content(), 40, ''); ?>
                                <span class="rm">
                                    <a href="<?php the_permalink(); ?>">Read More</a>
                                </span>
                            </p>
                        </div>
                    <?php } ?>
                    <?php $p++; endwhile; ?>
                <?php endif; ?>
            </div>
            <?php if(function_exists('wp_pagenavi')){
                wp_pagenavi();
            } ?>
        </article>
        <aside>
            <?php if(is_active_sidebar( 'blog_sidebar' )) dynamic_sidebar('blog_sidebar'); ?>
        </aside>
    </div>
</section>
<?php get_footer(); ?>
