<?php get_header(); ?>

<section class="single_post">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="container content">
            <h1><?php the_title(); ?></h1>
            <img src="<?php echo esc_url(image_src( get_post_thumbnail_id( $post->ID ), 'single' )); ?>" alt="<?php the_title(); ?>">
            <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
            <div class="author_name">Author:
                <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>"><?php the_author(); ?></a>
            </div>
            <div class="cats">Category: <?php echo wp_kses_post(cats($post->ID)); ?></div>
            <?php the_content(); ?>
            <div class="tags_list">Tags: <?php the_tags(''); ?></div>
            <div class="shrs">
                <a class="i_twtr" href="https://twitter.com/intent/tweet?text=<?php the_title(); ?> - <?php the_permalink(); ?>" title="Tweet It" target="_blank" rel="noopener"></a>
                <a class="i_fcbk" href="https://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" title="Share at Facebook" target="_blank" rel="noopener"></a>
                <a class="i_lnkdn" href="https://www.linkedin.com/shareArticle?mini=true&amp;title=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>" title="Share at LinkedIn" target="_blank" rel="noopener"></a>
                <a class="i_whtsp" href="https://api.whatsapp.com/send?text=<?php the_permalink(); ?>" data-action="share/whatsapp/share" target="_blank" rel="noopener" title="Share at WhatsApp"></a>
                <a class="i_envelope_o" href="mailto:?subject=<?php the_permalink(); ?>&amp;body=<?php the_title(); ?>" title="Send via email"></a>
                <a class="i_pntrst" href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" title="Pin It" target="_blank" rel="noopener"></a>
            </div>
            <?php if(function_exists('comments_template')) :
                //comments_template();
            endif; ?>
            <div class="post_navigation">
                <?php if (get_previous_post_link()) : ?>
                    <div class="prev_post"><?php previous_post_link('<span><i class="i-arr_left"></i>Previous</span> %link'); ?></div>
                <?php endif; ?>
                <?php if (get_next_post_link()) : ?>
                    <div class="next_post"><?php next_post_link('<span>Next<i class="i-arr_right"></i></span> %link'); ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; endif; ?>
</section>

<?php get_footer(); ?>
