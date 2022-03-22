<?php get_header(); /*Template Name: Contact*/
wp_enqueue_script( 'selectric', get_stylesheet_directory_uri() . '/js/libs/selectric.js', array( 'jquery' ), null, true );
?>

<section class="top_panel top_panel__secondary"
         style="<?php echo has_post_thumbnail() ? esc_attr( image_src( get_post_thumbnail_id( $post->ID ), 'full', true ) ) : 'background-image: url(' . esc_url( theme( 'images/top_default.jpg' ) ) . ')'; ?>">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
	if ( get_the_content() ) : ?>
        <section class="default_page container">
			<?php the_content(); ?>
        </section>
	<?php endif; endwhile; endif; ?>

<?php get_footer(); ?>
