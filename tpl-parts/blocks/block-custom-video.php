<?php
/**
 * Block Name: Custom Video
 *
 * This is the template that displays the custom video block.
 */

// set a preview for a block
if( !empty( $block['data']['__is_preview'] ) ) : ?>
    <figure>
        <img src="<?php echo esc_url(theme('tpl-parts/blocks/images/custom-video-placeholder.png')); ?>" alt="preview">
    </figure>
<?php return; endif;

// get fields
$custom_video = get_field( 'custom_video' );
$video = $custom_video['video'];
$img_id = $custom_video['poster'];
$content = $custom_video['content'];
if ( $video ) :
?>
    <div class="block__custom_video">
        <figure class="block__custom_video_poster">
            <img src="<?php echo esc_url( image_src( $img_id, 'top_default' ) ); ?>" alt="<?php echo esc_attr( get_alt( $img_id ) ); ?>">
            <a href="<?php echo esc_url( $video ); ?>" data-fancybox="<?php echo $img_id; ?>" class="i_play"></a>
        </figure>
        <div class="content">
            <?php echo wp_kses_post( $content ); ?>
        </div>
    </div>
<?php endif; ?>