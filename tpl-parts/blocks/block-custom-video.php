<?php
/**
 * Block Name: Custom Video
 *
 * This is the template that displays the custom video block.
 */

// set a preview for a block
if( !empty( $block['data']['__is_preview'] ) ) : ?>
    <figure>
        <img src="<?php echo esc_url(theme('tpl-parts/blocks/images/custom-video-placeholder.png')); ?>" alt="preview" style="max-width: 100%;">
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
            <?php echo wp_get_attachment_image( $img_id, 'top_default', false, array( 'alt' => get_alt( $img_id ) ) ); ?>
            <a href="<?php echo esc_url( $video ); ?>" data-fancybox="<?php echo $img_id; ?>" class="i_play" aria-label="Play video"></a>
        </figure>

        <div class="block__custom_video_content">
            <?php echo wp_kses_post( $content ); ?>
        </div>
    </div>
<?php endif; ?>