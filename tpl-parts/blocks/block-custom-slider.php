<?php
wp_enqueue_script( 'swiper', get_stylesheet_directory_uri() . '/js/libs/swiper.js', array( 'jquery' ), null, true );
wp_enqueue_style( 'swiper', get_stylesheet_directory_uri() . '/style/libs/swiper.css', null, null );

/**
 * Block Name: Custom Slider
 *
 * This is the template that displays the custom slider block.
 */

// set a preview for a block
if ( ! empty( $block['data']['__is_preview'] ) ) : ?>
    <figure>
        <img src="<?php echo esc_url( theme( 'tpl-parts/blocks/images/custom-slider-placeholder.png' ) ); ?>" alt="preview" style="max-width: 100%;">
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
                        <picture>
                            <source media="(max-width: 480px)" srcset="<?php echo wp_get_attachment_image_url( $image['id'], 'mob_slider' ); ?>">
                        	<?php echo wp_get_attachment_image( $image['id'], 'top_default', false, array( 'alt' => get_alt( $image['id'] ), 'class' => 'object_fit' ) ); ?>
                        </picture>
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