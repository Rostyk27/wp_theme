<?php get_header(); ?>

<div class="single_post">
    <section class="single_post__meta top_panel__default">
        <div class="container is_smaller">
            <h1><?php the_title(); ?></h1>

            <div class="author_name">Author:
                <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>"><?php the_author(); ?></a>
            </div>

            <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('F j, Y'); ?></time>

	        <?php if ( get_the_terms( $post->ID, 'category' ) ) : ?>
                <div class="cats">Category: <?php echo wp_kses_post( cats( $post->ID ) ); ?></div>
	        <?php endif; ?>

	        <?php if ( get_the_terms( $post->ID, 'post_tag' ) ) : ?>
                <div class="tags_list">Tags: <?php the_tags(''); ?></div>
	        <?php endif; ?>
        </div>
    </section>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <section class="single_post__content">
            <div class="container is_smaller">
                <ul class="shrs is_vertical">
                    <?php get_template_part( 'tpl-parts/share-buttons' ); ?>
                </ul>

                <div class="content">
                    <?php if ( has_post_thumbnail() ) :
                        $img_id = get_post_thumbnail_id( $post->ID ); ?>
                        <figure class="wp-block-image">
                            <img src="<?php echo esc_url( image_src( $img_id, 'top_default' ) ); ?>" alt="<?php echo esc_attr( get_alt( $img_id ) ); ?>">
                            <?php if ( get_the_post_thumbnail_caption() ) : ?>
                                <figcaption>
                                    <?php the_post_thumbnail_caption(); ?>
                                </figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>

                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
