<?php
/**
 * Block Name: Custom Gallery
 *
 * This is the template that displays the custom gallery block.
 */

// set a preview for a block
if( !empty( $block['data']['__is_preview'] ) ) : ?>
    <figure>
        <img src="<?php echo esc_url(theme('tpl-parts/blocks/images/custom-gallery-placeholder.jpg')); ?>" alt="preview" style="max-width: 100%;">
    </figure>
<?php return; endif;

// get fields
$custom_gallery = get_field( 'custom_gallery' );
if ( $custom_gallery ) :
?>
    <div class="block__custom_gallery">
	    <?php $g_i = 1; foreach ( $custom_gallery as $image ) : ?>
            <figure class="block__custom_gallery_item">
                <a href="<?php echo esc_url( $image['url'] ); ?>" data-fancybox="custom-gallery" aria-label="Open image <?php echo $g_i++; ?>">
                    <?php echo wp_get_attachment_image( $image['id'], 'custom_gallery', false, array( 'alt' => get_alt( $image['id'] ) ) ); ?>
                </a>
            </figure>
	    <?php endforeach; ?>
    </div>
<?php endif; ?>