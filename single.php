<?php get_header(); ?>
<section class="content">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="singlepost">
                <h2><?php the_title(); ?></h2>
                <?php the_post_thumbnail('single'); ?>
                <time datetime="<?php echo get_the_date('F j, Y'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                <div class="author_name">Author:
                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
                </div>
                <div class="cats">Category: <?php echo cats($post->ID); ?></div>
                <?php the_content(); ?>
                <div class="tags_list">Tags: <?php the_tags(''); ?></div>
                <div class="shrs">
                    <a class="i-twttr" href="http://twitter.com/home/?status=<?php the_title(); ?> - <?php the_permalink(); ?>" title="Tweet It" target="_blank"></a>
                    <a class="i-fcbk" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" title="Share at Facebook" target="_blank"></a>
                    <a class="i-lnkdn" href="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>" title="Share at LinkedIn" target="_blank"></a>
                    <a class="i-ggl" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" title="Share at Google+" target="_blank"></a>
                    <a class="i-pntrst" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" target="_blank" title="Pin It"></a>
                </div>
                <?php if(function_exists('comments_template')) {
                    //comments_template();
                } ?>
                <div class="post_navigation">
                    <?php if (get_previous_post_link()) { ?>
                        <div class="prev_post"><?php previous_post_link('<span><i class="i-arr_left"></i>Previous</span> %link'); ?></div>
                    <?php } ?>
                    <?php if (get_next_post_link()) { ?>
                        <div class="next_post"><?php next_post_link('<span>Next<i class="i-arr_right"></i></span> %link'); ?></div>
                    <?php } ?>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
</section>
<?php get_footer(); ?>
