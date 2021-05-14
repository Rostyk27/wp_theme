<?php
/**
 * Block Name: Custom Gallery
 *
 * This is the template that displays the custom gallery block.
 */

// set a preview for a block
if( !empty( $block['data']['__is_preview'] ) ) : ?>
    <figure>
        <img src="<?php echo esc_url(theme('tpl-parts/blocks/images/custom-gallery-placeholder.jpg')); ?>" alt="preview">
    </figure>
<?php return; endif;

// get fields
$custom_gallery = get_field( 'custom_gallery' );
if ( $custom_gallery ) :
?>
    <div class="block__custom_gallery">
	    <?php foreach ( $custom_gallery as $image ) : ?>
            <figure class="block__custom_gallery_item">
                <a href="<?php echo esc_url( $image['url'] ); ?>" data-fancybox="custom-gallery">
                    <img src="<?php echo esc_url( image_src( $image['id'], 'custom_gallery' ) ); ?>" alt="<?php echo esc_attr( get_alt( $image['id'] ) ); ?>">
                </a>
            </figure>
	    <?php endforeach; ?>
    </div>
<?php endif; ?>