<?php
/**
 * Block Name: Custom Slider
 *
 * This is the template that displays the custom slider block.
 */

// set a preview for a block
if( !empty( $block['data']['__is_preview'] ) ) : ?>
    <figure>
        <img src="<?php echo esc_url(theme('tpl-parts/blocks/images/custom-slider-placeholder.png')); ?>" alt="preview">
    </figure>
<?php return; endif;

// get fields
$custom_slider = get_field( 'custom_slider' );
if ( $custom_slider ) :
?>
    <div class="block__custom_slider">
        <div class="swiper">
            <div class="swiper-wrapper">
	            <?php foreach ( $custom_slider as $image ) : ?>
                    <div class="block__custom_slider_item swiper-slide">
                        <img src="<?php echo esc_url( image_src( $image['id'], 'top_default' ) ); ?>" alt="<?php echo esc_attr( get_alt( $image['id'] ) ); ?>">
                    </div>
	            <?php endforeach; ?>
            </div>
        </div>

        <div class="block__custom_slider_controls flex_center">
            <span class="sw_prev circle_arrow is_left"></span>
            <div class="sw_pagination"></div>
            <span class="sw_next circle_arrow is_right"></span>
        </div>
    </div>
<?php endif; ?>