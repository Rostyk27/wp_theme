<?php get_header();  /*$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;*/  ?>
<section class="content">
    <div class="container flex_start">
        <article>
            <h2><?php echo get_the_title(BLOG_ID); ?></h2>
            <div class="posts">
                <?php if (have_posts()) : $p = 0; while (have_posts()) : the_post(); ?>
                    <?php if($p == 0 /*&& $paged == 1*/) { ?>
                        <div class="firstpost blogpost">
                            <a class="thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('single');?></a>
                            <time datetime="<?php echo get_the_date('F j, Y'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo wp_trim_words(get_the_content(), 65, ''); ?><a href="<?php the_permalink(); ?>" class="lm">Learn More ></a></p>
                        </div>
                    <?php } else { ?>
                        <div class="blogpost">
                            <a  class="thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog');?></a>
                            <time datetime="<?php echo get_the_date('F j, Y'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo wp_trim_words(get_the_content(), 45, ''); ?><a href="<?php the_permalink(); ?>" class="lm">Learn More ></a></p>
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
