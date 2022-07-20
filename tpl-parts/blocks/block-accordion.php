<?php
/**
 * Block Name: Accordion
 *
 * This is the template that displays the accordion block.
 */

// set a preview for a block
if( !empty( $block['data']['__is_preview'] ) ) : ?>
    <figure>
        <img src="<?php echo esc_url(theme('tpl-parts/blocks/images/accordion-placeholder.png')); ?>" alt="preview" style="max-width: 100%;">
    </figure>
<?php return; endif;

// get fields
$accordion = get_field( 'accordion' );
if ( $accordion ) :
?>
    <div class="block__accordion" aria-label="Accordion">
        <?php foreach ( $accordion as $row ) : ?>
            <div class="block__accordion_row">
                <div class="block__accordion_title acc_title h3" tabindex="0" aria-expanded="false" aria-label="<?php echo esc_html( $row['title'] ); ?>" role="button">
                    <?php echo esc_html( $row['title'] ); ?>
                    <span class="circle_arrow is_down"></span>
                </div>

                <div class="block__accordion_content" aria-hidden="true" role="region">
                    <?php echo wp_kses_post( $row['content'] ); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>